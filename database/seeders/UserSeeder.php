<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Enum\RoleUser;
use Faker;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'display_name'=>'Nga',
            'email'=>'hongnga@yopmail.com',
            'password'=>Hash::make('nga123'),
            'role_id'=>RoleUser::ADMIN
        ]);
        // $faker = Faker\Factory::create();
        // for ($i = 0; $i < 10; $i++) {
        //     User::create([
        //         'display_name' => $faker->name,
        //         'email' => $faker->unique()->email,
        //         'password' => Hash::make('11111111'),
        //         'role_id' => RoleUser::ADMIN,
        //     ]);
        //}
    }
}
