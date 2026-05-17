<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store()
    {
        $user = auth()->user();

        // GET USER CART
        $cart = Cart::with('items.product')
            ->where('user_id', $user->id)
            ->first();

        // VALIDATE CART
        if (!$cart || $cart->items->count() === 0) {

            return back()->with(
                'error',
                'Cart is empty.'
            );
        }

        // CALCULATE TOTAL
        $subtotal = $cart->items->sum('subtotal');

        // CREATE TRANSACTION
        $transaction = Transaction::create([

            'invoice_number' =>
                'INV-' . now()->format('YmdHis'),

            'user_id' => $user->id,

            'subtotal' => $subtotal,

            'grand_total' => $subtotal,

            'payment_status' => 'pending',

            'transaction_status' => 'pending',

            'payment_method' => null,
        ]);

        // CREATE TRANSACTION ITEMS
        foreach ($cart->items as $item) {

            TransactionItem::create([

                'transaction_id' => $transaction->id,

                'product_id' => $item->product_id,

                'qty' => $item->qty,

                'price' => $item->price,

                'subtotal' => $item->subtotal,
            ]);
        }

        // CLEAR CART ITEMS
        $cart->items()->delete();

        return redirect('/orders')
            ->with(
                'success',
                'Checkout success.'
            );
    }
}