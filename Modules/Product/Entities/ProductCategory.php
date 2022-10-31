<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Entities\CategoryItem;

class ProductCategory extends Model
{
    protected $table = 'category_product';
    protected $guarded = [];
    protected $with = ['categoryItemLevel1', 'categoryItemLevel2', 'categoryItemLevel3' , 'categoryItemLevel4'];

    public function categoryItemLevel1()
    {
        return $this->belongsTo(CategoryItem::class, 'category_level_1_id');
    }

    public function categoryItemLevel2()
    {
        return $this->belongsTo(CategoryItem::class, 'category_level_2_id');
    }

    public function categoryItemLevel3()
    {
        return $this->belongsTo(CategoryItem::class, 'category_level_3_id');
    }

    public function categoryItemLevel4()
    {
        return $this->belongsTo(CategoryItem::class, 'category_level_4_id');
    }
}
