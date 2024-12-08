<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function buyer(){
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
