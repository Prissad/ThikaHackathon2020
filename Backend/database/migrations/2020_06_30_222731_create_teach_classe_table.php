<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachClasseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('teach_classe', function (Blueprint $table) {
            $table->uuid('teach_id');
            $table->uuid('classe_id');

            $table->foreign('teach_id')
                ->references('id')
                ->on('teaches')
                ->onDelete('cascade');

            $table->foreign('classe_id')
                ->references('id')
                ->on('classes')
                ->onDelete('cascade');

            $table->primary(['teach_id', 'classe_id']);
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teach_classe');
    }
}
