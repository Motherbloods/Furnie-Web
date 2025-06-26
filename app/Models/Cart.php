<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer'
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Accessor untuk mendapatkan total harga per item
     */
    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }

    /**
     * Scope untuk mendapatkan cart berdasarkan user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Method untuk menambah item ke cart
     */
    public static function addToCart($userId, $productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);

        // Cek apakah item sudah ada di cart
        $cartItem = self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // Update quantity jika item sudah ada
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Buat item baru jika belum ada
            self::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price
            ]);
        }
    }

    /**
     * Method untuk update quantity
     */
    public function updateQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->save();
    }

    /**
     * Method untuk mendapatkan total cart user
     */
    public static function getTotalForUser($userId)
    {
        return self::where('user_id', $userId)
            ->with('product')
            ->get()
            ->sum('total_price');
    }

    /**
     * Method untuk mendapatkan jumlah item dalam cart
     */
    public static function getItemCountForUser($userId)
    {
        return self::where('user_id', $userId)->sum('quantity');
    }
}