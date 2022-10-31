<?php

namespace Modules\WebsiteSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Library\Entities\Image;

class Banner extends Model
{
    protected $table = 'banners';
    protected $guarded = [];
}
