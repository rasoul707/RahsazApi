<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\User\Entities\Permission;

class SeedPermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Permission::query()->truncate();
        $permissions = $this->getPermissions();
        foreach ($permissions as $permission)
        {
            Permission::query()
                ->create([
                    'tag_id_fa' => $permission['fa'],
                    'tag_id_en' => $permission['en'],
                    'category' => "منو اصلی"
                ]);
        }
    }

    private function getPermissions()
    {
        return [
            ["fa" => "داشبورد من", "en" => "my_dashboard"],
            ["fa" => "مدیریت وبسایت", "en" => "website_management"],
            ["fa" => "لیست سفارشات", "en" => "orders"],
            ["fa" => "کاربران من", "en" => "my_users"],
            ["fa" => "محصولات من", "en" => "my_products"],
            ["fa" => "دسته بندی های من", "en" => "my_categories"],
            ["fa" => "مدیریت تیم من", "en" => "my_teams"],
            ["fa" => "تنظیمات", "en" => "settings"],
            ["fa" => "تخفیف ها", "en" => "coupons"],
            ["fa" => "دیدگاه و پرسش و پاسخ", "en" => "comments"],
            ["fa" => "وبلاگ من", "en" => "my_blog"],
            ["fa" => "گزارشات", "en" => "reports"],
            ["fa" => "کتابخانه", "en" => "library"],
            ["fa" => "صندوق ایمیل", "en" => "emails"],
        ];
    }
}
