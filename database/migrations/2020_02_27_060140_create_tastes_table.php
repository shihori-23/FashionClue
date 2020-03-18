<?php
            use Illuminate\Support\Facades\Schema;
            use Illuminate\Database\Schema\Blueprint;
            use Illuminate\Database\Migrations\Migration;
            
            class CreateTastesTable extends Migration
            {
                /**
                 * Run the migrations.
                 *
                 * @return void
                 */
                public function up()
                {
                    Schema::create("tastes", function (Blueprint $table) {
						$table->bigIncrements('id');
						$table->integer('taste_type')->nullable();
						$table->string('taste_name')->nullable();
						$table->timestamps();
                        $table->softDeletes();
                        $table->unique(['taste_type', 'taste_name'], 'uq_tastes_01');

                    });
                }
    
                /**
                 * Reverse the migrations.
                 *
                 * @return void
                 */
                public function down()
                {
                    Schema::dropIfExists("tastes");
                }
            }
        