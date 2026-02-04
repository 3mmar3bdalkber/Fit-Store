<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    public function order()
{
    return $this->belongsTo(Order::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}
public function getDiscountedPriceAttribute()
{
    return $this->price * (1 - $this->sale/100);
}

public function getTotalPriceAttribute()
{
    return $this->quantity * $this->discounted_price;
}


}

