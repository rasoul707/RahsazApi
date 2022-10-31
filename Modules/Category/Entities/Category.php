<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    protected $guarded = [];
    protected $appends = ['brother'];

    const TYPES = [
        'father' => 'father',
        'child' => 'child'
    ];

    const LEVELS = [
        '0' => '0',
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
    ];

    // relations

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    /* mutators */

    public function getBrotherAttribute()
    {
        if ($this->level == 0) {
            return null;
        } else {
            return Category::query()->where('parent_category_id', $this->parent_category_id)
                ->where('level', $this->level - 1)
                ->first();
        }
    }


    public function generateNavbar()
    {
        $collection = collect([]);
        $mainCategoryLevelOneItems = CategoryItem::query()
            ->with(['subsets'])
            ->where('parent_category_item_id', null)
            ->where('category_id', 2)
            ->orderBy('order', 'asc')
            ->get();
        $technicalMapsLevelOneItems = CategoryItem::query()
            ->with(['subsets'])
            ->where('parent_category_item_id', null)
            ->where('category_id', 7)
            ->orderBy('order', 'asc')
            ->get();
        $mainCategory = [
            "دسته بندی اصلی" => $mainCategoryLevelOneItems,
            "نقشه های فنی" => $technicalMapsLevelOneItems,
        ];
        $collection->add($mainCategory);
        return $collection;
    }
}
