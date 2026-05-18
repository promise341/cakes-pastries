<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'email',
        'phone',
        'address',
        'city',
        'notes',
        'total_amount',
        'status',
        'payment_status',
        'payment_reference',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    const STATUSES = ['pending', 'paid', 'processing', 'delivered', 'cancelled'];
    const PAYMENT_STATUSES = ['unpaid', 'paid', 'refunded'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'yellow',
            'paid'       => 'green',
            'processing' => 'blue',
            'delivered'  => 'emerald',
            'cancelled'  => 'red',
            default      => 'gray',
        };
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . strtoupper(uniqid());
        });
    }
}
