<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasteUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("taste_user", function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBiginteger('user_id');
            $table->unsignedBiginteger('taste_id');
            $table->timestamps();
            $table->softDeletes();
            
            //リレーションの際に記述必要
            $table->foreign('taste_id')
                    ->references('id')
                    ->on('tastes')
                    ->onDelete('cascade');
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("taste_user");
    }
}

