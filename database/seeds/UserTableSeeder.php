<?php

use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $user = new User;
        $user->uuid = $faker->uuid;
        $user->save();
    }
}
