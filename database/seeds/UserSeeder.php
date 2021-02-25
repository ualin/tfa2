<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\User');
        DB::table('users')->insert([
            'name' => $faker->name(),
            'email' => $faker->email,
            'password' => Hash::make('secret'),
            'username' => $faker->userName,
            'phone' => $faker->phoneNumber,
            'prefer_sms' => 0
        ]);
    }
}
