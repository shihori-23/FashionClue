<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreatePostsTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("posts", function (Blueprint $table) {
						$table->increments('id');
						$table->integer('category_id')->nullable();
						$table->text('text')->nullable();
						$table->integer('user_id')->nullable();
						$table->integer('gender_id');
						$table->string('post_image')->nullable();
						$table->timestamps();
						$table->softDeletes();

                    });
                }
    
                /**
                 * Reverse the migrations.
                 *
                 * @return void
                 */
                public function down()
                {
                    Schema::dropIfExists("posts");
                }
            }
        