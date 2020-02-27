<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreateAnswersTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("answers", function (Blueprint $table) {
						$table->increments('id');
						$table->integer('user_id')->nullable();
						$table->string('text')->nullable();
						$table->string('url')->nullable();
						$table->string('image')->nullable();
						$table->integer('post_id')->nullable();
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
                    Schema::dropIfExists("answers");
                }
            }
        