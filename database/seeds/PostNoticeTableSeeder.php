<?php
use Illuminate\Database\Seeder;

    class PostNoticeTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="post_noticTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            for( $i=0; $i<10; $i++ ){

                App\PostNotice::create([
					"post_id" => $faker->randomDigit(),
					"answer_owner_id" => $faker->randomDigit(),
					"role" => $faker->randomDigit(),
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            }
        }
    }