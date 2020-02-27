<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //********************************************
        // Cmd:[ php artisan db:seed ]
        //********************************************
        // $this->call(UsersTableSeeder::class);
		// $this->call(UsersTableSeeder::class);
		$this->call(PostsTableSeeder::class);
		$this->call(AnswersTableSeeder::class);
		$this->call(ReviewsTableSeeder::class);
		$this->call(BookmarkPostTableSeeder::class);
		$this->call(PostNoticeTableSeeder::class);
		$this->call(AdminsTableSeeder::class);
		$this->call(TastesTableSeeder::class);
		$this->call(TasteUserTableSeeder::class);
		$this->call(BookmarkAnswerTableSeeder::class);
		$this->call(AnswerNoticeTableSeeder::class);
    }
}