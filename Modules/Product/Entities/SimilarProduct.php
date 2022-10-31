<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SimilarProduct extends Model
{
    protected $table = 'similar_products';
    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(Product::class,'id', 'similar_product_id');
    }
}
