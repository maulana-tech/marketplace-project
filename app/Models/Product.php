<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    // Alias for backward compatibility
    public function user()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function productOrders()
    {
        return $this->hasMany(ProductOrder::class);
    }

    // Scope untuk produk yang masih ada stok
    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    // Helper method untuk mengurangi stok
    public function decreaseStock($quantity)
    {
        if ($this->quantity >= $quantity) {
            $this->decrement('quantity', $quantity);
            return true;
        }
        return false;
    }
}
