<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('rating');
            $table->string('description')->nullable();
            $table->uuid('user_id');
            $table->uuid('video_id');

            $table->timestamps();

            $table->primary(['id']);
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('video_id')
                ->references('id')
                ->on('videos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
