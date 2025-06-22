<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'toko_id',
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
        return $this->belongsTo(User::class, "toko_id");
    }
}
