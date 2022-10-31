<?php

namespace Modules\Product\Entities\Builder;

use App\Models\BaseBuilder;
use App\Models\SearchLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Entities\CategoryItem;
use Modules\MegaMenu\Entities\MegaMenu;
use Modules\Product\Entities\Product;

class ProductBuilder extends BaseBuilder
{

    public function __construct()
    {
        $this->_model = Product::query();
    }

    public function ids($ids)
    {
        if(!empty($ids))
        {
            $this->_model->whereIn('id', $ids);
        }

        return $this;
    }

    public function filterByCategoryLevel($level, $categoryId)
    {
        if(!empty($level) && !empty($categoryId))
        {
            $this->_model
                ->whereHas('cats', function ($q) use($level,$categoryId){
                    $q->where('category_product.category_level_'. $level . '_id' , '=', $categoryId);
                });
        }

        return $this;
    }

    public function filterByMegaMenuId($id)
    {
        if(!empty($id))
        {
            $megaMenu = MegaMenu::query()
                ->where('id', $id)
                ->first();

            if($megaMenu)
            {
                $categoryItem = CategoryItem::query()
                    ->where('name' , 'like', '%'. $megaMenu->name . '%')
                    ->get()
                    ->pluck('id');

                if($categoryItem)
                {
                    $this->_model
                        ->whereHas('cats', function ($q) use ($categoryItem){
                            $q->whereIn('category_product.category_level_'. '4' . '_id' ,  $categoryItem);
                        });

                }

            }
        }

        return $this;
    }


    public function customSearch($text, $columns)
    {
        if(!empty($text))
        {
            $sl = SearchLog::query()
                ->where('search', $text)
                ->first();

            if($sl)
            {
                $sl->count = $sl->count + 1;
                $sl->save();
            }else{
                SearchLog::query()
                    ->create([
                        'search' => $text,
                        'count' => 1,
                    ]);
            }


            $this->_model->where(function ($query) use ($text, $columns) {
                foreach ($columns as $column) {
                    $query->orwhere($column, 'LIKE', "%{$text}%");
                }
            });


            $this->_model->orWhereHas('otherNames', function ($q) use($text){
                $q->where('product_other_names.name', 'LIKE', '%'. $text . '%');
            });

            $categoryItem = CategoryItem::query()
                ->where('name' , 'like', '%'. $text . '%')
                ->first();
            if($categoryItem)
            {
                $this->_model->orWhereHas('cats', function ($q2) use($text, $categoryItem){
                    $q2->where('category_product.category_level_'. '1' . '_id' , '=', $categoryItem->id);
                    $q2->orWhere('category_product.category_level_'. '2' . '_id' , '=', $categoryItem->id);
                    $q2->orWhere('category_product.category_level_'. '3' . '_id' , '=', $categoryItem->id);
                    $q2->orWhere('category_product.category_level_'. '4' . '_id' , '=', $categoryItem->id);

                });
            }

        }
        return $this;

    }
}
