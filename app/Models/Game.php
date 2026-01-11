<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function vouchers(): HasMany
    {
        return $this->hasMany(Voucher::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function superDeals(): HasMany
    {
        return $this->hasMany(SuperDeal::class);
    }
}
