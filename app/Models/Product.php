<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'image',
        'category_id', 'status', 'stock', 'featured'
    ];

    protected $casts = [
        'price'    => 'decimal:2',
        'featured' => 'boolean',
        'stock'    => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(storage_path('app/public/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return 'https://placehold.co/600x400/F2C4B0/6B3F2A?text=🎂';
    }

    public function isInStock(): bool
    {
        return $this->status === 'active' && $this->stock > 0;
    }
}
