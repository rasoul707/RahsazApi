<?php

namespace Modules\WebsiteSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;

class HomepageGroupProduct extends Model
{
    protected $table = 'homepage_group_products';
    protected $guarded = [];
    protected $with = ['product'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
