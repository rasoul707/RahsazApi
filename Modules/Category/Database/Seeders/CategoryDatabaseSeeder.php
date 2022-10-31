<?php

namespace Modules\Category\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\CategoryItem;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Category::query()->truncate();
        CategoryItem::query()->truncate();

        $dasteBandiAsli = Category::query()
            ->create([
                'parent_category_id' => null,
                'type' => Category::TYPES['father'],
                'level' => Category::LEVELS['0'],
                'name' => 'دسته بندی اصلی'
            ]);

        $brand = Category::query()
            ->create([
                'parent_category_id' => $dasteBandiAsli->id,
                'type' => Category::TYPES['child'],
                'level' => Category::LEVELS['1'],
                'name' => 'برند'
            ]);

        for($i = 0; $i<3 ; $i++)
        {
            CategoryItem::query()
                ->create([
                    'order' => $i+1,
                    'parent_category_item_id' => null,
                    'category_id' => $brand->id,
                    'name' => "برند ".Factory::create('fa_IR')->name,
                    'description' => Factory::create('fa_IR')->realText,
                ]);
        }

        $model = Category::query()
            ->create([
                'parent_category_id' => $dasteBandiAsli->id,
                'type' => Category::TYPES['child'],
                'level' => Category::LEVELS['2'],
                'name' => 'مدل'
            ]);

        for($i = 0; $i<3 ; $i++)
        {
            CategoryItem::query()
                ->create([
                    'order' => $i+1,
                    'parent_category_item_id' => CategoryItem::query()
                        ->where('category_id', $brand->id)
                        ->inRandomOrder()->first()->id,
                    'category_id' => $model->id,
                    'name' => "مدل ".Factory::create('fa_IR')->name,
                    'description' => Factory::create('fa_IR')->realText,
                ]);
        }

        $dasteBandi = Category::query()
            ->create([
                'parent_category_id' => $dasteBandiAsli->id,
                'type' => Category::TYPES['child'],
                'level' => Category::LEVELS['3'],
                'name' => 'دسته بندی'
            ]);

        for($i = 0; $i<3 ; $i++)
        {
            CategoryItem::query()
                ->create([
                    'order' => $i+1,
                    'parent_category_item_id' => CategoryItem::query()
                        ->where('category_id', $model->id)
                        ->inRandomOrder()->first()->id,
                    'category_id' => $dasteBandi->id,
                    'name' => "دسته بندی ".Factory::create('fa_IR')->name,
                    'description' => Factory::create('fa_IR')->realText,
                ]);
        }

        $zirDaste = Category::query()
            ->create([
                'parent_category_id' => $dasteBandiAsli->id,
                'type' => Category::TYPES['child'],
                'level' => Category::LEVELS['4'],
                'name' => 'زیر دسته'
            ]);

        for($i = 0; $i<3 ; $i++)
        {
            CategoryItem::query()
                ->create([
                    'order' => $i+1,
                    'parent_category_item_id' => CategoryItem::query()
                        ->where('category_id', $dasteBandi->id)
                        ->inRandomOrder()->first()->id,
                    'category_id' => $zirDaste->id,
                    'name' => "زیر دسته ".Factory::create('fa_IR')->name,
                    'description' => Factory::create('fa_IR')->realText,
                ]);
        }
        ///////////
        $dasteBandiAsli = Category::query()
            ->create([
                'parent_category_id' => null,
                'type' => Category::TYPES['father'],
                'level' => Category::LEVELS['0'],
                'name' => 'نقشه های فنی'
            ]);

        $brand = Category::query()
            ->create([
                'parent_category_id' => $dasteBandiAsli->id,
                'type' => Category::TYPES['child'],
                'level' => Category::LEVELS['1'],
                'name' => 'سطح یک'
            ]);

        $model = Category::query()
            ->create([
                'parent_category_id' => $dasteBandiAsli->id,
                'type' => Category::TYPES['child'],
                'level' => Category::LEVELS['2'],
                'name' => 'سطح دو'
            ]);

        $dasteBandi = Category::query()
            ->create([
                'parent_category_id' => $dasteBandiAsli->id,
                'type' => Category::TYPES['child'],
                'level' => Category::LEVELS['3'],
                'name' => 'سطح سه'
            ]);

        $zirDaste = Category::query()
            ->create([
                'parent_category_id' => $dasteBandiAsli->id,
                'type' => Category::TYPES['child'],
                'level' => Category::LEVELS['4'],
                'name' => 'سطح چهار'
            ]);

    }
}
