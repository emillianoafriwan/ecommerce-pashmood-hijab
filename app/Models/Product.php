<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    // TAMBAHKAN BAGIAN INI DI DALAM CLASS
    protected $fillable = [
        'category_id', 
        'name', 
        'slug', 
        'description', 
        'price', 
        'image_path'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest(); // Ambil ulasan dari yang terbaru
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function imageUrl(): string
    {
        if (!$this->image_path) {
            return asset('images/pashmina-voal.svg');
        }

        if (Str::startsWith($this->image_path, ['http://', 'https://'])) {
            return $this->image_path;
        }

        if (Str::startsWith($this->image_path, 'images/')) {
            return asset($this->image_path);
        }

        return asset('storage/' . $this->image_path);
    }
}
