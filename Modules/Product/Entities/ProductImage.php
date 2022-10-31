<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Library\Entities\Image;

class ProductImage extends Model
{
    protected $table = 'product_image';
    protected $guarded = [];

    const IMAGE_TYPE = [
        'cover' => 'cover',
        'gallery' => 'gallery',
    ];

    public function image()
    {
        return $this->hasOne(Image::class,'id', 'image_id');
    }
}
