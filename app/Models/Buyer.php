<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, HasOne};

class Buyer extends Model
{
    protected $guarded = ['id'];

    public function payments() : HasMany
    {
        return $this->hasMany(Payment::class, 'buyer_id', 'id');
    }
}
