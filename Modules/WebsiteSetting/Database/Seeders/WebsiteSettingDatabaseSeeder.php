<?php

namespace Modules\WebsiteSetting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Library\Entities\Image;
use Modules\Product\Entities\Product;
use Modules\WebsiteSetting\Entities\Banner;
use Modules\WebsiteSetting\Entities\HomepageGroup;
use Modules\WebsiteSetting\Entities\HomepageGroupProduct;
use Modules\WebsiteSetting\Entities\Slider;

class WebsiteSettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for($i = 0; $i<5 ; $i++)
        {
            Slider::query()
                ->create([
                    'image_id' => Image::query()->inRandomOrder()->first()->id,
                    'href' => 'https://google.com',
                    'order' => $i + 1,
                ]);
        }

        for ($i = 0; $i<3; $i++)
        {
            $homepageGroup = HomepageGroup::query()
                ->create([
                    'title' => 'NUMBER' . (string)($i+1),
                    'status' => HomepageGroup::STATUSES['enable'],
                ]);

            for($j = 0; $j<5; $j++)
            {
                HomepageGroupProduct::query()
                    ->create([
                        'homepage_group_id' => $homepageGroup->id,
                        'product_id' => Product::query()->inRandomOrder()->first()->id
                    ]);
            }
        }

        for($i = 0; $i<3; $i++)
        {
            Banner::query()
                ->create([
                    'image_id' => Image::query()->inRandomOrder()->first()->id
                ]);
        }
    }
}
