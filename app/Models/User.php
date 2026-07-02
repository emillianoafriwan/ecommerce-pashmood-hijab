<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Tambahkan bank_name, bank_account, dan bank_owner di sini
#[Fillable(['name', 'email', 'avatar', 'theme_color', 'theme_settings', 'password', 'address', 'phone', 'province', 'province_code', 'city', 'city_code', 'district', 'district_code', 'village', 'village_code', 'detail_address', 'bank_name', 'bank_account', 'bank_owner'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'theme_settings'    => 'array',
        ];
    }

    // Relasi ke pesanan
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi ke riwayat chat
    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'user_id');
    }

    // Relasi ke rekening bank (multiple)
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class)->orderBy('sort_order');
    }

    // Relasi ke keranjang belanja
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Check if the user has completed their profile data.
     *
     * @return bool
     */
    public function isProfileComplete(): bool
    {
        return !empty($this->phone) &&
            !empty($this->province) &&
            !empty($this->city) &&
            !empty($this->district) &&
            !empty($this->village) &&
            !empty($this->detail_address);
    }
}