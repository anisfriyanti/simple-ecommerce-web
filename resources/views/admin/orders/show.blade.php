<x-app-layout>
    @php
        $paymentStatusLabels = [
            'paid' => 'Paid',
            'pending' => 'Pending',
            'expired' => 'Expired',
            'cancelled' => 'Cancelled',
            'failed' => 'Failed',
        ];

        $orderStatuses = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        $paymentStatusClasses = [
            'paid' => 'bg-green-100 text-green-700 ring-green-200',
            'pending' => 'bg-amber-100 text-amber-700 ring-amber-200',
            'expired' => 'bg-slate-100 text-slate-700 ring-slate-200',
            'cancelled' => 'bg-red-100 text-red-700 ring-red-200',
            'failed' => 'bg-red-100 text-red-700 ring-red-200',
        ];

        $orderStatusClasses = [
            'pending' => 'bg-amber-100 text-amber-700 ring-amber-200',
            'processing' => 'bg-blue-100 text-blue-700 ring-blue-200',
            'shipped' => 'bg-indigo-100 text-indigo-700 ring-indigo-200',
            'completed' => 'bg-green-100 text-green-700 ring-green-200',
            'cancelled' => 'bg-red-100 text-red-700 ring-red-200',
        ];

        $paymentStatus = $transaction->payment_status ?? 'pending';
        $orderStatus = $transaction->transaction_status ?? 'pending';
        $paymentBadgeClass = $paymentStatusClasses[$paymentStatus] ?? $paymentStatusClasses['pending'];
        $orderBadgeClass = $orderStatusClasses[$orderStatus] ?? $orderStatusClasses['pending'];
    @endphp

    <div class="mx-auto max-w-5xl px-6 py-10">
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-rose-500">
                    Admin Order
                </p>

                <h1 class="mt-2 text-3xl font-black text-slate-900">
                    Order Detail
                </h1>
            </div>

            <a href="/admin/orders" class="inline-flex rounded-2xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-rose-200 hover:text-rose-500">
                Back to Orders
            </a>
        </div>

        <div class="mb-6 grid gap-4 md:grid-cols-2">
            <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">
                    Payment Status
                </p>

                <span class="mt-3 inline-flex rounded-full px-4 py-2 text-sm font-semibold ring-1 {{ $paymentBadgeClass }}">
                    {{ $paymentStatusLabels[$paymentStatus] ?? ucfirst($paymentStatus) }}
                </span>
            </div>

            <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                <p class="text-sm font-semibold text-slate-500">
                    Order Status
                </p>

                <span class="mt-3 inline-flex rounded-full px-4 py-2 text-sm font-semibold ring-1 {{ $orderBadgeClass }}">
                    {{ $orderStatuses[$orderStatus] ?? ucfirst($orderStatus) }}
                </span>
            </div>
        </div>

        <div class="mb-6 rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
            <div class="grid gap-4 md:grid-cols-2">
                <p><span class="font-semibold text-slate-500">Invoice:</span> {{ $transaction->invoice_number }}</p>
                <p><span class="font-semibold text-slate-500">Customer:</span> {{ $transaction->user->name ?? '-' }}</p>
                <p><span class="font-semibold text-slate-500">Email:</span> {{ $transaction->user->email ?? '-' }}</p>
                <p><span class="font-semibold text-slate-500">Total:</span> Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="mb-6 rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-bold text-slate-900">
                Items
            </h2>

            @foreach ($transaction->items as $item)
                <div class="flex flex-col justify-between gap-3 border-b border-slate-100 py-4 last:border-b-0 md:flex-row md:items-center">
                    <div>
                        <p class="font-semibold text-slate-900">
                            {{ $item->product->name ?? 'Deleted Product' }}
                        </p>

                        <p class="mt-1 text-sm text-slate-500">
                            Qty: {{ $item->qty }} · Price: Rp {{ number_format($item->price, 0, ',', '.') }}
                        </p>
                    </div>

                    <p class="font-semibold text-slate-900">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-bold text-slate-900">
                Update Order Status
            </h2>

            <form
                method="POST"
                action="/admin/orders/{{ $transaction->id }}/status"
                class="flex flex-wrap items-center gap-4"
            >
                @csrf

                <select
                    name="transaction_status"
                    class="rounded-2xl border border-slate-200 px-4 py-3 shadow-sm focus:border-rose-300 focus:outline-none focus:ring-2 focus:ring-rose-100"
                >
                    @foreach ($orderStatuses as $status => $label)
                        <option value="{{ $status }}" @selected($orderStatus === $status)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <button class="rounded-2xl bg-slate-900 px-6 py-3 font-semibold text-white transition hover:bg-rose-500">
                    Update Order Status
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
