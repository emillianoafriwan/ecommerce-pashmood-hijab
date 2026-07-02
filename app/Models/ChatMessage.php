<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sender_id',
        'message',
        'product_id',
        'order_id',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // The buyer who owns the chat room/thread
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Who sent the message (either the buyer or the admin)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Optional referenced product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Optional referenced order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
