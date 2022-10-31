<?php

namespace Modules\User\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Address;
use Modules\User\Entities\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        for ($i = 0; $i < 20; $i++)
        {
            $user = User::query()
                ->create([
                    'type' => User::TYPES['مشتری'],
                    'first_name' => Factory::create('fa_IR')->firstName,
                    'last_name' => Factory::create('fa_IR')->lastName,
                    'username' => Factory::create()->userName,
                    'birth_year' => 1377,
                    'birth_month' => 28,
                    'birth_day' => 05,
                    'phone_number' => Factory::create('fa_IR')->phoneNumber,
                    'email' => Factory::create('fa_IR')->freeEmail(),
                    'state' => Factory::create('fa_IR')->city,
                    'city' => Factory::create('fa_IR')->city,
                    'address' => Factory::create('fa_IR')->address,
                    'password' => bcrypt('as12AS!@'),
                ]);

            Address::query()
                ->create([
                    'user_id' => $user->id,
                    'location' => Factory::create('fa_IR')->address,
                    'country' => "ایران",
                    'city' => Factory::create('fa_IR')->city,
                ]);

            User::query()
                ->create([
                    'type' => User::TYPES['مدیر'],
                    'first_name' => Factory::create('fa_IR')->firstName,
                    'last_name' => Factory::create('fa_IR')->lastName,
                    'username' => Factory::create()->userName,
                    'birth_year' => 1377,
                    'birth_month' => 28,
                    'birth_day' => 05,
                    'phone_number' => Factory::create('fa_IR')->phoneNumber,
                    'email' => Factory::create('fa_IR')->freeEmail(),
                    'state' => Factory::create('fa_IR')->city,
                    'city' => Factory::create('fa_IR')->city,
                    'address' => Factory::create('fa_IR')->address,
                    'password' => bcrypt('as12AS!@'),
                ]);

        }

    }
}
