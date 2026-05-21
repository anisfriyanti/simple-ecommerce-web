<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function store()
    {
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

        $subtotal = $cart->items->sum('subtotal');

        $transaction = DB::transaction(function () use ($user, $cart, $subtotal) {
            $transaction = Transaction::create([
                'invoice_number' => 'INV-' . now()->format('YmdHis') . '-' . $user->id,
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'grand_total' => $subtotal,
                'payment_status' => 'pending',
                'transaction_status' => 'pending',
                'payment_method' => 'midtrans',
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
                    'gross_amount' => $transaction->grand_total,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                'item_details' => $cart->items->map(function ($item) {
                    return [
                        'id' => $item->product_id,
                        'price' => (int) $item->price,
                        'quantity' => (int) $item->qty,
                        'name' => $item->product->name,
                    ];
                })->values()->all(),
            ];

            $transaction->update([
                'snap_token' => Snap::getSnapToken($params),
            ]);

            $cart->items()->delete();

            return $transaction;
        });

        return redirect('/payments/' . $transaction->id);
    }
}