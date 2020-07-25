<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_details', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('grade');
            $table->string('birthday')->nullable();
            $table->string('establishment')->nullable();
            $table->string('region')->nullable();
            $table->uuid('client_id')->nullable();
            $table->uuid('classe_id')->nullable();
            $table->uuid('subscription_id')->nullable();

            $table->timestamps();

            $table->primary(['id']);
            $table->foreign('client_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');
            $table->foreign('classe_id')
                ->references('id')
                ->on('classes');
            $table->foreign('subscription_id')
                ->references('id')
                ->on('subscriptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_details');
    }
}
