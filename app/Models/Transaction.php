<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'invoice_number',
        'user_id',
        'recipient_name',
        'recipient_phone',
        'address_line',
        'province',
        'city',
        'district',
        'postal_code',
        'subtotal',
        'grand_total',
        'payment_status',
        'transaction_status',
        'payment_method',
        'courier',
        'shipping_service',
        'shipping_cost',
        'shipping_etd',
        'paid_at',
        'snap_token',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
