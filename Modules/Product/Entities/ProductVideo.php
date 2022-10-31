<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Library\Entities\Image;
use Modules\Library\Entities\Video;

class ProductVideo extends Model
{
    protected $table = 'product_video';
    protected $guarded = [];

    public function video()
    {
        return $this->hasOne(Video::class,'id', 'video_id');
    }
}
