<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariation extends Model
{
    use SoftDeletes;

    protected $fillable = ['product_id', 'color', 'image_path'];

    protected static function booted()
    {
        static::deleted(function ($variation) {
            // Automatically delete cart items referencing this variation when soft-deleted
            \App\Models\CartItem::where('product_variation_id', $variation->id)->delete();
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function imageUrl(): string
    {
        if (!$this->image_path) {
            return $this->product->imageUrl();
        }

        if (\Illuminate\Support\Str::startsWith($this->image_path, ['http://', 'https://'])) {
            return $this->image_path;
        }

        if (\Illuminate\Support\Str::startsWith($this->image_path, 'images/')) {
            return asset($this->image_path);
        }

        return asset('storage/' . $this->image_path);
    }
}
