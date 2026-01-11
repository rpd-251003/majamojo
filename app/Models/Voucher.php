<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voucher extends Model
{
    protected $fillable = [
        'game_id',
        'promo_code',
        'type',
        'description',
        'start_date',
        'end_date',
        'external_link',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    public function scopeForRole($query, $role)
    {
        if ($role === 'admin') {
            return $query;
        }

        if ($role === 'membership') {
            return $query->whereIn('type', ['membership_only', 'all']);
        }

        return $query->whereIn('type', ['reguler_only', 'all']);
    }
}
