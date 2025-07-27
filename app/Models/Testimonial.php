<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_order_id',
        'buyer_id',
        'seller_id',
        'rating',
        'comment'
    ];

    // Relationships
    public function productOrder()
    {
        return $this->belongsTo(ProductOrder::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // Scope untuk rating
    public function scopeWithRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopeHighRating($query)
    {
        return $query->where('rating', '>=', 4);
    }
}
