<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
     public function index()
    {
        $transactions = Transaction::with([
            'user',
            'items.product'
        ])
        ->latest()
        ->get();

        return view(
            'admin.orders.index',
            compact('transactions')
        );
    }

    public function updateStatus(
        Request $request,
        Transaction $transaction
    )
    {
        $request->validate([

            'transaction_status' => 'required'
        ]);

        $transaction->update([

            'transaction_status' =>
                $request->transaction_status
        ]);

        return back()->with(
            'success',
            'Order status updated.'
        );
    }
}
