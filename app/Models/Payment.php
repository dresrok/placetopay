<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne};

class Payment extends Model
{
    protected $guarded = ['id'];

    public static function generateReference($length)
    {
        return Str::random($length);
    }

    public function expirationDates() : HasMany
    {
        return $this->hasMany(ExpirationDate::class, 'payment_id', 'id');
    }

    public function detail() : HasOne
    {
        return $this->hasOne(PaymentDetail::class, 'payment_id', 'id');
    }

    public function buyer() : BelongsTo
    {
        return $this->belongsTo(Buyer::class, 'buyer_id');
    }
}
