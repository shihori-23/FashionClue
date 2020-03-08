<?php
use Illuminate\Database\Seeder;

    class TasteUserTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="taste_useTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            $data = [
                [
                    'user_id' => 1,
                    'taste_id' => 11,
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                ],
                [
                    'user_id' => 1,
                    'taste_id' => 12,
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                ],
                [
                    'user_id' => 1,
                    'taste_id' => 13,
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                ],
            ];
                DB::table('taste_users')->insert($data);
        }
    }