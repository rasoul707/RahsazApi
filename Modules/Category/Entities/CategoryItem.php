<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Library\Entities\Image;
use Modules\MegaMenu\Entities\MegaMenu;
use Modules\Product\Entities\Product;

class CategoryItem extends Model
{
    protected $guarded = [];
    protected $appends = ['number_of_subsets'];
    protected $with = ['icon'];


    public function image()
    {
        return $this->belongsTo(Image::class,'image_id');
    }

    public function icon()
    {
        return $this->belongsTo(Image::class, 'icon_image_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(CategoryItem::class, 'parent_category_item_id')
            ->with(['parent' ,'category']);
    }

    public function subsets()
    {
        return $this->hasMany(CategoryItem::class, 'parent_category_item_id')->with(['subsets']);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_item_product')->withPivot([
            'image',
            'product_number_in_map'
        ]);
    }

    /* Mutators */
    public function getNumberOfSubsetsAttribute()
    {
        return $this->numberOfSubsets();
    }

    public function numberOfSubsets()
    {
        return $this->subsets()->count();
    }
}
