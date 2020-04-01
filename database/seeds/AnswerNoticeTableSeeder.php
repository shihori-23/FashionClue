<?php
use Illuminate\Database\Seeder;

    class AnswerNoticeTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="answer_noticTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            for( $i=0; $i<10; $i++ ){

                App\AnswerNotice::create([
					"review_owner_id" => $faker->randomDigit(),
					"role" => $faker->randomDigit(),
					"answer_id" => $faker->randomDigit(),
					"post_id" => $faker->randomDigit(),
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            }
        }
    }