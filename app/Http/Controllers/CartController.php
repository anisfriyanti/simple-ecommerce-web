<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Product $product)
    {
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
}