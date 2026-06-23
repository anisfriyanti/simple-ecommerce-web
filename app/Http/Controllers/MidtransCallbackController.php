<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $payload = $request->all();

        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentType = $payload['payment_type'] ?? null;
        $serverKey = (string) config('midtrans.server_key');

        Log::info('MIDTRANS CALLBACK HIT', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'payment_type' => $paymentType,
        ]);

        $expectedSignature = hash(
            'sha512',
            (string) $orderId . (string) $statusCode . (string) $grossAmount . $serverKey
        );

        if ($serverKey === '' || ! hash_equals($expectedSignature, (string) $signatureKey)) {
            Log::warning('MIDTRANS CALLBACK INVALID SIGNATURE', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
            ]);

            return response()->json([
                'message' => 'Invalid signature',
            ], 403);
        }

        $transaction = Transaction::where('invoice_number', $orderId)->first();

        if (! $transaction) {
            return response()->json([
                'message' => 'Transaction not found',
            ], 404);
        }

        switch ($transactionStatus) {
            case 'settlement':
            case 'capture':
                $transaction->update([
                    'payment_status' => 'paid',
                    'transaction_status' => 'processing',
                    'payment_method' => $paymentType,
                    'paid_at' => now(),
                ]);
                break;

            case 'pending':
                $transaction->update([
                    'payment_status' => 'pending',
                ]);
                break;

            case 'expire':
                $transaction->update([
                    'payment_status' => 'expired',
                ]);
                break;

            case 'cancel':
                $transaction->update([
                    'payment_status' => 'cancelled',
                ]);
                break;

            case 'deny':
                $transaction->update([
                    'payment_status' => 'failed',
                ]);
                break;
        }

        return response()->json([
            'message' => 'Callback success',
        ]);
    }
}
