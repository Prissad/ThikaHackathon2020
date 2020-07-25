<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasseSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /*public function up()
    {
        Schema::create('classe_subject', function (Blueprint $table) {
            $table->uuid('classe_id');
            $table->uuid('subject_id');
            $table->timestamps();

            $table->foreign('classe_id')
                    ->references('id')
                    ->on('classes');
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects');

        });
    }*/

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classe_subject');
    }
}
