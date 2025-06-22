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
        'stock',
        'kategori',
        'status',
        'image',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
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
            ->where('status', 'active');
    }
}