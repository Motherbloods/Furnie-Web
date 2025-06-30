<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'store_name',
        'store_address',
        'store_description',
        'is_suspended',
        'rating_toko'
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_suspended' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the seller profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products for the seller.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the seller's full store information
     *
     * @return array
     */
    public function getStoreInfoAttribute(): array
    {
        return [
            'name' => $this->store_name,
            'address' => $this->store_address,
            'description' => $this->store_description,
            'is_suspended' => $this->is_suspended,
            'user' => $this->user->only(['name', 'email', 'phone']),
        ];
    }

    /**
     * Check if seller is verified
     *
     * @return bool
     */
    // public function isVerified(): bool
    // {
    //     return $this->is_verified;
    // }

    /**
     * Check if seller is suspended
     *
     * @return bool
     */
    public function isSuspended(): bool
    {
        return $this->is_suspended;
    }

    /**
     * Check if seller is active (verified and not suspended)
     *
     * @return bool
     */
    // public function isActive(): bool
    // {
    //     return $this->is_verified && !$this->is_suspended;
    // }
    public function isActive(): bool
    {
        return !$this->is_suspended;
    }

    /**
     * Get product count for this seller
     *
     * @return int
     */
    public function getProductCountAttribute(): int
    {
        return $this->products()->count();
    }

    /**
     * Get active product count for this seller
     *
     * @return int
     */
    public function getActiveProductCountAttribute(): int
    {
        return $this->products()->where('status', 'aktif')->count();
    }



    /**
     * Scope to get only active (not suspended) sellers
     */
    public function scopeActive($query)
    {
        return $query->where('is_suspended', false);
    }

}