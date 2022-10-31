<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;

class UserProductVisit extends Model
{
    use HasFactory;

    protected $table = 'user_product_visits';
    protected $guarded = [];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
