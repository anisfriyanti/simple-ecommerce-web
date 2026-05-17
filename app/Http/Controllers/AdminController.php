<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();

        $totalUsers = User::count();

        $totalTransactions = Transaction::count();

        $totalIncome = Transaction::where(
            'payment_status',
            'paid'
        )->sum('grand_total');

        return view(
            'admin.dashboard',
            compact(
                'totalProducts',
                'totalUsers',
                'totalTransactions',
                'totalIncome'
            )
        );
    }
    public function payments()
{
    $payments = Payment::with(
        'transaction.user'
    )
    ->latest()
    ->get();

    return view(
        'admin.payments',
        compact('payments')
    );
}
public function approvePayment(Payment $payment)
{
    // UPDATE PAYMENT
    $payment->update([

        'payment_status' => 'paid',

        'paid_at' => now(),
    ]);

    // UPDATE TRANSACTION
    $payment->transaction->update([

        'payment_status' => 'paid',

        'transaction_status' => 'completed',

        'paid_at' => now(),
    ]);

    return back()->with(
        'success',
        'Payment approved.'
    );
}
    
}