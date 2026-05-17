<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Transaction $transaction)
    {
        return view(
            'pages.payment',
            compact('transaction')
        );
    }

    public function store(
        Request $request,
        Transaction $transaction
    )
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $path = $request
            ->file('payment_proof')
            ->store('payments', 'public');

        Payment::create([

            'transaction_id' => $transaction->id,

            'payment_method' => 'bank_transfer',

            'payment_proof' => $path,

            'payment_status' => 'pending',
        ]);

        return redirect('/orders')
            ->with(
                'success',
                'Payment uploaded successfully.'
            );
    }
}