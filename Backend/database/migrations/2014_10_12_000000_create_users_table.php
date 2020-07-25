<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

                $table->uuid('id');
                $table->string('fname');
                $table->string('lname');
                $table->string('phone')->nullable();
                $table->uuid('role_id');
                $table->boolean('active')->default(false);
                $table->string('activation_token');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->softDeletes();
                $table->rememberToken();
                $table->timestamps();

                $table->primary(['id']);
                $table->foreign('role_id')
                    ->references('id')
                    ->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
