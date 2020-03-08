<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker\Factory::create("ja_JP");

        DB::table('users')->insert(
            [
            'name' => 'ユーザー１',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('11111111'),
            'age' => NULL,
            'gender' => 0,
            'api_token' => Str::random(80),
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")

        ]
        );
        DB::table('users')->insert(
            [
            'name' => 'ユーザー２',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('22222222'),
            'age' => NULL,
            'gender' => NULL,
            'api_token' => Str::random(80),
            "created_at" => $faker->dateTime("now"),
            "updated_at" => $faker->dateTime("now")

        ]
        );
    }
}
