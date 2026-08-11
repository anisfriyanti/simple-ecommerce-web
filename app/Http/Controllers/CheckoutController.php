<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        $cart = Cart::with('items.product')
            ->where('user_id', $user->id)
            ->first();

        if (! $cart || $cart->items->count() === 0) {
            return redirect('/cart')->with(
                'error',
                'Cart is empty.'
            );
        }

        if ($stockError = $this->stockValidationError($cart)) {
            return redirect('/cart')->with(
                'error',
                $stockError
            );
        }

        $subtotal = (int) $cart->items->sum('subtotal');
        $shippingCost = $this->shippingCostPlaceholder();
        $grandTotal = $subtotal + $shippingCost;

        return view(
            'pages.checkout',
            compact(
                'cart',
                'subtotal',
                'shippingCost',
                'grandTotal'
            )
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => ['required', 'string', 'max:255'],
            'recipient_phone' => ['required', 'string', 'regex:/^[0-9+\-\s().]{8,20}$/'],
            'address_line' => ['required', 'string', 'max:1000'],
            'province' => ['required', 'string', 'max:120'],
            'city' => ['required', 'string', 'max:120'],
            'district' => ['required', 'string', 'max:120'],
            'postal_code' => ['required', 'digits_between:5,10'],
            'courier' => ['nullable', 'string', 'max:50'],
            'shipping_service' => ['nullable', 'string', 'max:100'],
            'shipping_cost' => ['nullable', 'numeric', 'min:0'],
            'shipping_etd' => ['nullable', 'string', 'max:100'],
        ]);

        $user = auth()->user();

        $cart = Cart::with('items.product')
            ->where('user_id', $user->id)
            ->first();

        if (! $cart || $cart->items->count() === 0) {
            return back()->with(
                'error',
                'Cart is empty.'
            );
        }

        if ($stockError = $this->stockValidationError($cart)) {
            return back()->with(
                'error',
                $stockError
            );
        }

        $subtotal = (int) $cart->items->sum('subtotal');
        $shippingCost = $this->shippingCostPlaceholder();
        $grandTotal = $subtotal + $shippingCost;

        $transaction = DB::transaction(function () use ($user, $cart, $subtotal, $shippingCost, $grandTotal, $validated) {
            $transaction = Transaction::create([
                'invoice_number' => 'INV-' . now()->format('YmdHis') . '-' . $user->id,
                'user_id' => $user->id,
                'recipient_name' => $validated['recipient_name'],
                'recipient_phone' => $validated['recipient_phone'],
                'address_line' => $validated['address_line'],
                'province' => $validated['province'],
                'city' => $validated['city'],
                'district' => $validated['district'],
                'postal_code' => $validated['postal_code'],
                'subtotal' => $subtotal,
                'grand_total' => $grandTotal,
                'payment_status' => 'pending',
                'transaction_status' => 'pending',
                'payment_method' => 'midtrans',
                'courier' => $validated['courier'] ?? null,
                'shipping_service' => $validated['shipping_service'] ?? null,
                'shipping_cost' => $shippingCost,
                'shipping_etd' => $validated['shipping_etd'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $transaction->invoice_number,
                    'gross_amount' => (int) $transaction->grand_total,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $transaction->recipient_phone,
                    'shipping_address' => [
                        'first_name' => $transaction->recipient_name,
                        'phone' => $transaction->recipient_phone,
                        'address' => $transaction->address_line,
                        'city' => $transaction->city,
                        'postal_code' => $transaction->postal_code,
                        'country_code' => 'IDN',
                    ],
                ],
                'item_details' => $this->midtransItemDetails($cart, $shippingCost),
            ];

            $transaction->update([
                'snap_token' => Snap::getSnapToken($params),
            ]);

            $cart->items()->delete();

            return $transaction;
        });

        return redirect('/payments/' . $transaction->id);
    }

    private function midtransItemDetails(Cart $cart, int $shippingCost): array
    {
        $items = $cart->items->map(function ($item) {
            return [
                'id' => $item->product_id,
                'price' => (int) $item->price,
                'quantity' => (int) $item->qty,
                'name' => $item->product->name,
            ];
        });

        if ($shippingCost > 0) {
            $items->push([
                'id' => 'SHIPPING',
                'price' => (int) $shippingCost,
                'quantity' => 1,
                'name' => 'Shipping Cost',
            ]);
        }

        return $items->values()->all();
    }

    private function stockValidationError(Cart $cart): ?string
    {
        foreach ($cart->items as $item) {
            if (! $item->product) {
                return 'One of the products in your cart is no longer available.';
            }

            if ($item->product->stock <= 0) {
                return $item->product->name . ' is currently out of stock.';
            }

            if ($item->qty > $item->product->stock) {
                return 'Only ' . $item->product->stock . ' item(s) left for ' . $item->product->name . '. Please update your cart.';
            }
        }

        return null;
    }

    private function shippingCostPlaceholder(): int
    {
        return max(0, (int) config('shipping.placeholder_cost', 0));
    }
}
