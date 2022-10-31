<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;

class CartProduct extends Model
{
    protected $table = 'cart_products';
    protected $guarded = [];
    protected $appends = ['total_price'];
    protected $with = ['product'];

    public function product()
    {
        return $this->belongsTo(Product::class)->with(['productAttributes']);
    }

    public function getTotalPriceAttribute()
    {
        return $this->totalPrice();
    }

    public function totalPrice()
    {
        return $this->rate * $this->count;
    }
}
