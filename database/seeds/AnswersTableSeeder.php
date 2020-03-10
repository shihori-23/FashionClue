<?php
use Illuminate\Database\Seeder;

    class AnswersTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            //Cmd: php artisan db:seed --class="answerTableSeeder"
            
            $faker = Faker\Factory::create("ja_JP");
            
            for( $i=0; $i<10; $i++ ){

                App\Answer::create([
					"user_id" => $faker->randomDigit(),
					"text" => $faker->word(),
					"url" => $faker->url(),
					"answer_image" => $faker->bothify('##??.jpg'),
					"post_id" => $faker->randomDigit(),
					"created_at" => $faker->dateTime("now"),
					"updated_at" => $faker->dateTime("now")
                ]);
            }
        }
    }