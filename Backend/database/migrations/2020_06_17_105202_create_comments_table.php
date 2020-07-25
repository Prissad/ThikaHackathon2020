<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table)
        {
            $table->uuid('id');
            $table->string('name');
            $table->text('text');
            $table->uuid('comment_id')->nullable()->default(null);
            $table->uuid('user_id');
            $table->uuid('video_id');
            $table->timestamps();

            $table->primary(['id']);
            $table->foreign('comment_id')
                ->references('id')
                ->on('comments');
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
        Schema::dropIfExists('comments');
    }
}
