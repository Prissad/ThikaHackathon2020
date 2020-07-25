<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectLevel1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_level1s', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('pdf')->nullable();
            $table->uuid('subject_id')->nullable();
            $table->uuid('subject_level1_id')->nullable();
            $table->timestamps();


            $table->primary('id');

            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects');
            $table->foreign('subject_level1_id')
                ->references('id')
                ->on('subject_level1s');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_level1s');
    }
}
