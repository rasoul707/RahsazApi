<?php

namespace Modules\WebsiteSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Library\Entities\Image;

class Slider extends Model
{
    protected $table = 'sliders';
    protected $guarded = [];
    protected $with = ['image'];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
