<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function(Blueprint $table){

            $table->increments('id');
            $table->string('title', 100);
            $table->string('a_title', 255)->nullable();
            $table->string('slug', 100);
            $table->tinyInteger('out')->default(0);
            $table->integer('sort');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
