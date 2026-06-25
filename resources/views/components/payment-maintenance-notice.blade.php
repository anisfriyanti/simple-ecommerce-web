<div {{ $attributes->merge(['class' => 'rounded-3xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-900 shadow-sm']) }}>
    <div class="flex flex-col gap-3 sm:flex-row sm:items-start">
        <div class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-amber-100 font-black text-amber-700">
            !
        </div>

        <div>
            <p class="font-bold text-amber-950">Payment status sedang maintenance</p>
            <p class="mt-1 leading-relaxed">
                Pembayaran demo tetap bisa dicoba, tetapi status pesanan mungkin tidak langsung berubah otomatis.
                Akun payment gateway demo sedang dipakai bersama oleh beberapa aplikasi, jadi update status bisa membutuhkan pengecekan manual.
            </p>
        </div>
    </div>
</div>
