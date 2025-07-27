<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'avatar',
        'password',
        'occupation',
        'bank_account_name',
        'bank_name',
        'bank_account_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class, 'creator_id');
    }

    public function productOrders()
    {
        return $this->hasMany(ProductOrder::class, 'buyer_id');
    }

    public function sales()
    {
        return $this->hasMany(ProductOrder::class, 'creator_id');
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class, 'seller_id');
    }

    public function givenTestimonials()
    {
        return $this->hasMany(Testimonial::class, 'buyer_id');
    }

    // Helper methods
    public function isPenjual()
    {
        return $this->role === 'penjual';
    }

    public function isPembeli()
    {
        return $this->role === 'pembeli';
    }
}
