<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(
        Transaction $transaction
    )
    {
        abort_unless(
            $transaction->user_id === auth()->id(),
            403
        );

        return view(
            'payments.create',
            compact('transaction')
        );
    }

    public function store(
        Request $request,
        Transaction $transaction
    )
    {
        abort_unless(
            $transaction->user_id === auth()->id(),
            403
        );

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

        $transaction->update([
            'payment_method' => 'bank_transfer',
            'payment_status' => 'pending',
        ]);

        return redirect('/orders')
            ->with(
                'success',
                'Payment uploaded successfully.'
            );
    }
}