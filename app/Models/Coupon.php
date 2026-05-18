<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'value' => 'decimal:2',
    ];

    /**
     * Check if coupon is currently valid.
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount for a given total.
     */
    public function calculateDiscount($total): float
    {
        if ($this->type === 'percent') {
            return round(($this->value / 100) * $total, 2);
        }

        return min((float) $this->value, (float) $total);
    }
}
