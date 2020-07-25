<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilePDFSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_p_d_f_s', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('title');
            $table->string('pdf');
            $table->string('type')->nullable();
            $table->uuid('video_id')->nullable();
            $table->uuid('classe_id')->nullable();

            $table->timestamps();

            $table->primary(['id']);
            $table->foreign('classe_id')
                    ->references('id')
                    ->on('classes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_p_d_f_s');
    }
}
