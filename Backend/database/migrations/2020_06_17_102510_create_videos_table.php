<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('title');
            $table->string('type');
            $table->string('url');
            $table->boolean('payed')->default('1');
            $table->text('description')->nullable();

            $table->uuid('classe_id')->nullable();
            $table->uuid('user_id')->nullable();

            $table->timestamps();
            $table->primary(['id']);
            $table->foreign('classe_id')
                ->references('id')
                ->on('classes');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
