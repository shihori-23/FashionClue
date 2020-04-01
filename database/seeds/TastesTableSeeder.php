<?php
use Illuminate\Database\Seeder;


    class TastesTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="tasteTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            $data = [
                [
                    'taste_type' => 1,
                    'taste_name' => 'きれいめ',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 1,
                    'taste_name' => 'カジュアル',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 1,
                    'taste_name' => 'ナチュラル',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 1,
                    'taste_name' => 'ストリート',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 1,
                    'taste_name' => 'トレンド',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 1,
                    'taste_name' => 'スポーティー',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 1,
                    'taste_name' => 'モード',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 1,
                    'taste_name' => 'クール',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 1,
                    'taste_name' => 'ロック',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 1,
                    'taste_name' => 'トラッド',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 0,
                    'taste_name' => 'きれいめ',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 0,
                    'taste_name' => 'カジュアル',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 0,
                    'taste_name' => 'ナチュラル',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 0,
                    'taste_name' => 'ストリート',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 0,
                    'taste_name' => 'トレンド',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 0,
                    'taste_name' => 'スポーティー',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 0,
                    'taste_name' => 'モード',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 0,
                    'taste_name' => 'クール',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 0,
                    'taste_name' => 'マニッシュ',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 0,
                    'taste_name' => 'コンサバ',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 0,
                    'taste_name' => 'ガーリー',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
                [
                    'taste_type' => 0,
                    'taste_name' => 'フェミニン',
                    "created_at" => $faker->dateTime("now"),
                    "updated_at" => $faker->dateTime("now"),
                    "deleted_at" => NULL,
                ],
            ];
            DB::table('tastes')->insert($data);
        }
    }