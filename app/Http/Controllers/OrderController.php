<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class OrderController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(
            'items.product'
        )
        ->where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->get();

        return view(
            'pages.orders',
            compact('transactions')
        );
    }
}