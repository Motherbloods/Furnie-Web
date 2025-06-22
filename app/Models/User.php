<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user can access Filament admin panel
     *
     * @return bool
     */
    public function canAccessFilament(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is seller
     *
     * @return bool
     */
    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    /**
     * Check if user is regular user
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Get the seller profile for the user.
     */
    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    /**
     * Get the user's full store information (for sellers)
     *
     * @return array|null
     */
    public function getStoreInfoAttribute(): ?array
    {
        if (!$this->isSeller() || !$this->seller) {
            return null;
        }

        return $this->seller->store_info;
    }

    /**
     * Get products through seller relationship
     */
    public function products()
    {
        if ($this->isSeller() && $this->seller) {
            return $this->seller->products();
        }

        return $this->hasMany(Product::class)->whereNull('id'); // Empty relationship
    }

    /**
     * Check if seller is verified (for sellers only)
     *
     * @return bool
     */
    public function isSellerVerified(): bool
    {
        return $this->isSeller() && $this->seller && $this->seller->isVerified();
    }

    /**
     * Check if seller is suspended (for sellers only)
     *
     * @return bool
     */
    public function isSellerSuspended(): bool
    {
        return $this->isSeller() && $this->seller && $this->seller->isSuspended();
    }
}