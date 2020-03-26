<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreateAnswerNoticesTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("answer_notices", function (Blueprint $table) {
						$table->increments('id');
						$table->integer('review_owner_id')->nullable();
						$table->integer('role')->nullable();
						$table->integer('answer_id');
						$table->integer('post_id');
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
                    Schema::dropIfExists("answer_notices");
                }
            }
        