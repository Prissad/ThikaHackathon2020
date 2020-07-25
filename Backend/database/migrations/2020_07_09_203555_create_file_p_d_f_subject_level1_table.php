<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilePDFSubjectLevel1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_p_d_f_subject_level1', function (Blueprint $table) {
            $table->uuid('file_p_d_f_id');
            $table->uuid('subject_level1_id');
            $table->timestamps();

            $table->foreign('file_p_d_f_id')
                ->references('id')
                ->on('file_p_d_f_s')
                ->onDelete('cascade');;

            $table->foreign('subject_level1_id')
                ->references('id')
                ->on('subject_level1s')
                ->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_p_d_f_subject_level1');
    }
}
