<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class MidtransCallbackController extends Controller
{
   public function handle(Request $request)
{
    \Log::info('MIDTRANS CALLBACK HIT');

    \Log::info($request->all());

    $payload = $request->all();

  $transactionStatus =
    $payload['transaction_status'] ?? null;

 $orderId =
    $payload['order_id'] ?? null;
$paymentType =
    $payload['payment_type'] ?? null;

    // FIND TRANSACTION
    $transaction = Transaction::where(
        'invoice_number',
        $orderId
    )->first();

    if (!$transaction) {

        return response()->json([
            'message' => 'Transaction not found'
        ], 404);
    }

    // SUCCESS
    if (
        $transactionStatus == 'settlement'
        || $transactionStatus == 'capture'
    ) {

        $transaction->update([

            'payment_status' => 'paid',

            'transaction_status' =>
                'processing',

            'payment_method' =>
                $paymentType,

            'paid_at' => now(),
        ]);
    }

    // EXPIRED
    if ($transactionStatus == 'expire') {

        $transaction->update([

            'payment_status' =>
                'expired',
        ]);
    }

    // CANCEL
    if ($transactionStatus == 'cancel') {

        $transaction->update([

            'payment_status' =>
                'cancelled',
        ]);
    }

    return response()->json([

        'message' => 'Callback success',
    ]);
}
}