<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentReference extends Model
{
    protected $guarded = ['id'];

    public function payment() : BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
