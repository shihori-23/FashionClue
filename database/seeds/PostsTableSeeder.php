<?php
use Illuminate\Database\Seeder;

    class PostsTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="postTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            for( $i=0; $i<10; $i++ ){

                App\Post::create([
					"category_id" => $faker->randomDigit(),
					"text" => $faker->word(),
					"user_id" => $faker->randomDigit(),
					"gender_id" => $faker->randomDigit(),
					"post_image" => $faker->bothify('##??.jpg'),
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            }
        }
    }