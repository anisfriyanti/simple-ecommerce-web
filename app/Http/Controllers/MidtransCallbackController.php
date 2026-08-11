<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                $stockIssue = $this->markTransactionAsPaid($transaction->id, $paymentType);

                if ($stockIssue) {
                    return response()->json([
                        'message' => $stockIssue,
                    ], 409);
                }

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

    private function markTransactionAsPaid(int $transactionId, ?string $paymentType): ?string
    {
        return DB::transaction(function () use ($transactionId, $paymentType) {
            $transaction = Transaction::with('items')
                ->whereKey($transactionId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($transaction->payment_status === 'paid') {
                return null;
            }

            $requiredQuantities = $transaction->items
                ->groupBy('product_id')
                ->map(fn ($items) => (int) $items->sum('qty'));

            $products = collect();

            foreach ($requiredQuantities as $productId => $requiredQty) {
                $product = Product::whereKey($productId)
                    ->lockForUpdate()
                    ->first();

                if (! $product) {
                    Log::error('MIDTRANS CALLBACK PRODUCT MISSING', [
                        'transaction_id' => $transaction->id,
                        'invoice_number' => $transaction->invoice_number,
                        'product_id' => $productId,
                        'required_qty' => $requiredQty,
                    ]);

                    return 'Product not available for settlement';
                }

                if ($product->stock < $requiredQty) {
                    Log::error('MIDTRANS CALLBACK STOCK INSUFFICIENT', [
                        'transaction_id' => $transaction->id,
                        'invoice_number' => $transaction->invoice_number,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'available_stock' => $product->stock,
                        'required_qty' => $requiredQty,
                    ]);

                    return 'Insufficient stock for settlement';
                }

                $products->put($product->id, $product);
            }

            foreach ($requiredQuantities as $productId => $requiredQty) {
                $products->get($productId)->decrement('stock', $requiredQty);
            }

            $transaction->update([
                'payment_status' => 'paid',
                'transaction_status' => 'processing',
                'payment_method' => $paymentType ?? $transaction->payment_method,
                'paid_at' => now(),
            ]);

            return null;
        });
    }
}
