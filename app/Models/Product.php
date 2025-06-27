<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'seller_id',
        'name',
        'description',
        'price',
        'original_price',
        'rating',
        'reviews',
        'discount',
        'stock',
        'kategori',
        'status',
        'image',
        'images',
        'specifications',
        'features',
    ];

    protected $casts = [
        'images' => 'array',
        'specifications' => 'array',
        'features' => 'array',
    ];



    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the user who owns this product through seller
     */
    public function user()
    {
        return $this->hasOneThrough(User::class, Seller::class, 'id', 'id', 'seller_id', 'user_id');
    }

    /**
     * Scope to get products from verified sellers only
     */
    public function scopeFromVerifiedSellers($query)
    {
        return $query->whereHas('seller', function ($q) {
            $q->where('is_verified', true);
        });
    }

    /**
     * Scope to get products from active sellers only
     */
    public function scopeFromActiveSellers($query)
    {
        return $query->whereHas('seller', function ($q) {
            $q->where('is_suspended', false);
        });
    }

    /**
     * Scope to get available products
     */
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0)
            ->where('status', 'aktif');
    }
}