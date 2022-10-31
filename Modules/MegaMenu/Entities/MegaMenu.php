<?php

namespace Modules\MegaMenu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\CategoryItem;

class MegaMenu extends Model
{
    protected $table = 'mega_menus';
    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(MegaMenu::class, 'parent_id')->select(['id', 'parent_id', 'name'])->orderBy('order');
    }

    public static function make()
    {
        self::query()->truncate();

        $parents = DB::table('category_items')
        ->select('name', 'order', 'icon')
        ->where('category_id', 4)
            ->groupBy('name')
            ->distinct()
            ->get();

        foreach ($parents as $parent) {
            self::query()
                ->create([
                    'parent_id' => null,
                    'order'     => $parent->order,
                    'icon'     => $parent->icon,
                    'name' => $parent->name,
                ]);
        }

        // add childs
        $parentMegaMenus = self::query()->where('parent_id', null)->get();
        foreach ($parentMegaMenus as $parentMegaMenu) {
            $parentCategoryItemModels = CategoryItem::query()
                ->where('category_id', 4)
                ->where('name', $parentMegaMenu->name)
                ->get();

            foreach ($parentCategoryItemModels as $parentCategoryItemModel) {
                $childCategoryItemModels = CategoryItem::query()
                    ->where('category_id', 5)
                    ->where('parent_category_item_id', $parentCategoryItemModel->id)
                    ->get();

                foreach ($childCategoryItemModels as $childCategoryItemModel) {
                    if (!self::query()->where('parent_id', $parentMegaMenu->id)
                    ->where('name', $childCategoryItemModel->name)->first()) {
                        self::query()
                            ->create([
                                'order'     => $childCategoryItemModel->order,
                                'icon'     => $childCategoryItemModel->icon,
                                'parent_id' => $parentMegaMenu->id,
                                'name' => $childCategoryItemModel->name,
                            ]);
                    }
                }
            }
        }
    }
}
