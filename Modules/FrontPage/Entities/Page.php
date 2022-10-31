<?php

namespace Modules\FrontPage\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Modules\Coupon\Entities\Coupon;
use Modules\Library\Entities\Image;
use Modules\User\Entities\Address;
use Modules\User\Entities\User;

class Page extends Model
{
    protected $table = 'pages';
    protected $guarded = [];
    public static function updateOrCreatePage(Page $page, $request)
    {
        $page->name = $request->name;
        $page->content = $request->content;
        $page->tag_en = $request->tag_en;
    }
}
