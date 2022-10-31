<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttributes extends Model
{
    protected $table = 'product_attributes';
    protected $guarded = [];
}
