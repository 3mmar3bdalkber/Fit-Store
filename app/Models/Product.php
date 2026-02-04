<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

        protected $fillable = [
        'name'
        , 'color'
        , 'price'
        , 'sale'
        , 'collection'
        , 'gender'
        , 'category'
        , 'image1'
        , 'image2'
        , 'quantity'
    ];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items');
    }
}



// $data = $request->validated();
// Product::create($data);
