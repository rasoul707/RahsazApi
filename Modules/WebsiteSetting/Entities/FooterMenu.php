<?php

namespace Modules\WebsiteSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FooterMenu extends Model
{
    protected $table = 'footer_menu';
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(FooterMenuItems::class, 'menu_id')
            ->orderBy('priority');
    }
}
