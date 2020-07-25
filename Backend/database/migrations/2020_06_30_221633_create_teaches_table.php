<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teaches', function (Blueprint $table) {
            $table->uuid('classe_id');
            $table->uuid('subject_id');
            $table->uuid('teacher_id');

            $table->foreign('classe_id')
                ->references('id')
                ->on('classes');
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects');
            $table->foreign('teacher_id')
                ->references('id')
                ->on('users');

            $table->primary(['classe_id', 'subject_id', 'teacher_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teaches');
    }
}
