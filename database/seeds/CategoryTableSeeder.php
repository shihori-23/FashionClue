<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create("ja_JP");
            
        $data = [
            [
                
                'category_type' => 0,
                'category_name' => 'トップス',
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now"),
            ],
            [
                'category_type' => 0,
                'category_name' => 'ジャケット/アウター',
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now"),
            ],
            [
                'category_type' => 0,
                'category_name' => 'パンツ',
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now"),
            ],
            [
                'category_type' => 1,
                'category_name' => 'スカート',
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now"),
            ],
            [
                'category_type' => 1,
                'category_name' => 'ワンピース',
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now"),
            ],
            [
                'category_type' => 0,
                'category_name' => 'シューズ',
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now"),
            ],
            [
                'category_type' => 0,
                'category_name' => 'バッグ',
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now"),
            ],
            [
                'category_type' => 0,
                'category_name' => 'ファッション小物',
                "created_at" => $faker->dateTime("now"),
                "updated_at" => $faker->dateTime("now"),
            ],
        ];
        DB::table('categories')->insert($data);
    }
}
