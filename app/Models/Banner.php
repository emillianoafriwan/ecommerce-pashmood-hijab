<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'image_path',
        'file_size_bytes',
        'link_url',
        'sort_order',
        'is_active',
        'placement',
        'width',
        'height',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'sort_order'       => 'integer',
        'file_size_bytes'  => 'integer',
    ];

    /**
     * Map placement to readable Indonesian text.
     */
    public function placementLabel(): string
    {
        return [
            'above_recommendations' => 'Di atas Rekomendasi',
            'below_recommendations' => 'Di bawah Rekomendasi (Tengah)',
            'below_catalog'         => 'Di bawah Katalog Utama',
        ][$this->placement] ?? 'Tidak Diketahui';
    }

    /**
     * Map width to readable text.
     */
    public function widthLabel(): string
    {
        return [
            'full' => 'Lebar Penuh (1 Kolom)',
            'half' => 'Setengah Lebar (2 Kolom)',
        ][$this->width] ?? 'Tidak Diketahui';
    }

    /**
     * Map height to readable text.
     */
    public function heightLabel(): string
    {
        return [
            'small'  => 'Pendek',
            'medium' => 'Sedang',
            'large'  => 'Tinggi',
        ][$this->height] ?? 'Tidak Diketahui';
    }

    /**
     * Ambil URL publik gambar banner.
     */
    public function imageUrl(): string
    {
        return asset('storage/' . $this->image_path);
    }

    /**
     * Kembalikan ukuran file dalam format MB yang mudah dibaca.
     */
    public function fileSizeMb(): string
    {
        if (!$this->file_size_bytes) return '-';
        $mb = $this->file_size_bytes / 1048576;
        return $mb < 0.1
            ? round($this->file_size_bytes / 1024, 0) . ' KB'
            : round($mb, 2) . ' MB';
    }

    /**
     * Scope hanya banner yang aktif, diurutkan berdasarkan sort_order.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
