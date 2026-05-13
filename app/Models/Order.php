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
            'pre_order' => 'Pre-Order Menunggu Pembayaran',
            'pending'   => 'Pre-Order Menunggu Pembayaran',
            'waiting'   => 'Menunggu Verifikasi Pembayaran',
            'paid'      => 'Pre-Order Dikonfirmasi',
            'shipped'   => 'Pashmina Dalam Pengiriman',
            'completed' => 'Pre-Order Selesai',
            'canceled'  => 'Pre-Order Dibatalkan',
            default     => $this->status, // Jaga-jaga kalau ada status lain
        };
    }
}
