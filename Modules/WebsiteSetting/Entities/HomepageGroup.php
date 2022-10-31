<?php

namespace Modules\WebsiteSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomepageGroup extends Model
{
    protected $table = 'homepage_groups';
    protected $guarded = [];
    const STATUSES = [
        'enable' => 'enable',
        'disable' => 'disable',
    ];
    public function products()
    {
        return $this->hasMany(HomepageGroupProduct::class)->with(['product']);
    }


}
