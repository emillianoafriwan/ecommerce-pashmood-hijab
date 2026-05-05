<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'total_price', 
        'status', 
        'address', 
        'phone', 
        'payment_proof',
        'courier',
        'resi_number' // Tambahkan ini
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Fungsi untuk menerjemahkan status ke Bahasa Indonesia
    public function statusIndo()
    {
        return match($this->status) {
            'pending'   => 'Tertunda',
            'waiting'   => 'Menunggu persetujuan',
            'paid'      => 'Pembayaran Selesai',
            'shipped'   => 'Dalam Perjalanan Menuju Lokasi Anda',
            'completed' => 'Pesanan Selesai',
            'canceled'  => 'Pesanan Dibatalkan',
            default     => $this->status, // Jaga-jaga kalau ada status lain
        };
    }
}