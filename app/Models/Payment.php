<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [

    'transaction_id',

    'payment_method',

    'payment_proof',

    'payment_status',

    'paid_at',
];

public function transaction()
{
    return $this->belongsTo(Transaction::class);
}

}
