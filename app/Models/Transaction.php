<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [

    'invoice_number',

    'user_id',

    'subtotal',

    'grand_total',

    'payment_status',

    'transaction_status',

    'payment_method',

    'paid_at',
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
