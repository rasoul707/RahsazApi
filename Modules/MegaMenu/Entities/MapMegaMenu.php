<?php

namespace Modules\MegaMenu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\CategoryItem;
use Illuminate\Support\Facades\Log;

class MapMegaMenu extends Model
{
    protected $table = 'map_mega_menus';
    protected $guarded = [];
    protected $with = [
        'children',
    ];

    public function children()
    {
        error_log("the message for log");
        $a = $this->hasMany(MapMegaMenu::class, 'parent_id')
            ->select(['id', 'parent_id', 'name'])
            ->orderBy('order');
        // error_log(print_r($a,true));
        // var_dump($a);
        return $a;
    }

    // public function children2()
    // {
    //     error_log("the message for log ----");
    //     $a = $this->hasMany(MapMegaMenu::class, 'parent_id')->select(['id', 'parent_id', 'name']);
    //     // error_log(print_r($a,true));
    //     return $a;
    // }

    public static function make()
    {
        self::query()->truncate();

        $parents = DB::table('category_items')
            ->select('name', 'order', 'icon', 'id')
            ->where('category_id', 7)
            ->groupBy('name')
            ->distinct()
            ->get();

        foreach ($parents as $parent) {
            self::query()->create([
                'parent_id' => null,
                'order'     => $parent->order,
                'icon'     => $parent->icon,
                'name' => $parent->name,
                'cat_id' => $parent->id,
            ]);
        }

        // add children
        $parentMegaMenus = self::query()->where('parent_id', null)->get();
        foreach ($parentMegaMenus as $parentMegaMenu) {
            $parentCategoryItemModels = CategoryItem::query()
                ->where('category_id', 7)
                ->where('name', $parentMegaMenu->name)
                ->get();

            foreach ($parentCategoryItemModels as $parentCategoryItemModel) {
                $childCategoryItemModels = CategoryItem::query()
                    ->where('category_id', 8)
                    ->where('parent_category_item_id', $parentCategoryItemModel->id)
                    ->get();

                foreach ($childCategoryItemModels as $childCategoryItemModel) {
                    if (!self::query()->where('parent_id', $parentMegaMenu->id)
                        ->where('name', $childCategoryItemModel->name)->first()) {
                        self::query()->create([
                            'parent_id' => $parentMegaMenu->id,
                            'order'     => $childCategoryItemModel->order,
                            'icon'     => $childCategoryItemModel->icon,
                            'name' => $childCategoryItemModel->name,
                            'cat_id' => $childCategoryItemModel->id,
                        ]);
                    }

                    $p = self::query()
                        ->where('parent_id', $parentMegaMenu->id)
                        ->where('name', $childCategoryItemModel->name)
                        ->get()
                        ->first();

                    // $parentCategoryItemModels2 = CategoryItem::query()
                    // ->where('category_id', 8)
                    // ->where('name', $childCategoryItemModel->name)
                    // ->get();

                    // foreach ($parentCategoryItemModels2 as $parentCategoryItemModel2)
                    // {

                    $childCategoryItemModels3 = CategoryItem::query()
                        ->where('category_id', 9)
                        ->where('parent_category_item_id', $childCategoryItemModel->id)
                        ->get();

                    foreach ($childCategoryItemModels3 as $childCategoryItemModel3) {
                        self::query()->create([
                            'parent_id' => $p->id,
                            'icon'     => $childCategoryItemModel3->icon,
                            'order'     => $childCategoryItemModel3->order,
                            'name' => $childCategoryItemModel3->name,
                            'cat_id' => $childCategoryItemModel3->id,
                        ]);
                    }
                    // }
                }
            }
        }
    }
}
