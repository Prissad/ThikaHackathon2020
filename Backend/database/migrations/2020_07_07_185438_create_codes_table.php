<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('code')->unique();
            $table->unsignedInteger('point')->nullable();
            $table->boolean('verified')->nullable();
            $table->uuid('client_id')->nullable();


            $table->timestamps();
            $table->primary(['id']);
            $table->foreign('client_id')
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
        Schema::dropIfExists('codes');
    }
}
