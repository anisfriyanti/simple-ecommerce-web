<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Product $product)
    {
        if ($product->stock <= 0) {
            return back()->with(
                'error',
                $product->name . ' is currently out of stock.'
            );
        }

        $user = auth()->user();

        // CREATE CART IF NOT EXISTS
        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
        ]);

        // CHECK EXISTING ITEM
        $cartItem = CartItem::where(
            'cart_id',
            $cart->id
        )
            ->where(
                'product_id',
                $product->id
            )
            ->first();

        // IF ITEM EXISTS
        if ($cartItem) {
            if ($cartItem->qty + 1 > $product->stock) {
                return back()->with(
                    'error',
                    'Only ' . $product->stock . ' item(s) left for ' . $product->name . '.'
                );
            }

            $cartItem->qty += 1;

            $cartItem->subtotal =
                $cartItem->qty * $cartItem->price;

            $cartItem->save();

        } else {

            // CREATE NEW ITEM
            CartItem::create([

                'cart_id' => $cart->id,

                'product_id' => $product->id,

                'qty' => 1,

                'price' => $product->price,

                'subtotal' => $product->price,
            ]);
        }

        return back()->with(
            'success',
            'Product added to cart.'
        );
    }

    public function index()
    {
        $cart = Cart::with([
            'items.product'
        ])
            ->where(
                'user_id',
                auth()->id()
            )
            ->first();

        return view(
            'pages.cart',
            compact('cart')
        );
    }

    public function update(Request $request, CartItem $cartItem)
    {
        abort_unless(
            $cartItem->cart && $cartItem->cart->user_id === auth()->id(),
            403
        );

        $validated = $request->validate([
            'qty' => ['required', 'integer', 'min:0'],
        ]);

        $cartItem->loadMissing('product');

        if ($validated['qty'] === 0) {
            $cartItem->delete();

            return back()->with(
                'success',
                'Product removed from cart.'
            );
        }

        if (! $cartItem->product || $cartItem->product->stock <= 0) {
            return back()->with(
                'error',
                'This product is currently out of stock.'
            );
        }

        if ($validated['qty'] > $cartItem->product->stock) {
            return back()->with(
                'error',
                'Only ' . $cartItem->product->stock . ' item(s) left for ' . $cartItem->product->name . '.'
            );
        }

        $cartItem->update([
            'qty' => $validated['qty'],
            'subtotal' => $validated['qty'] * $cartItem->price,
        ]);

        return back()->with(
            'success',
            'Cart updated successfully.'
        );
    }
}
