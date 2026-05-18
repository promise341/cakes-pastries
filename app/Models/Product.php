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
        if ($this->image) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                return $this->image;
            }
            if (file_exists(public_path($this->image))) {
                return asset($this->image);
            }
            if (file_exists(storage_path('app/public/' . $this->image))) {
                return asset('storage/' . $this->image);
            }
        }
        return 'https://placehold.co/600x400/F2C4B0/6B3F2A?text=🎂';
    }

    public function isInStock(): bool
    {
        return $this->status === 'active' && $this->stock > 0;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 5.0, 1);
    }

    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->count();
    }
}
