<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sl_hotels', function (Blueprint $table) {
            $table->integer('id')->unique();

            $table->string('name');
            $table->integer('beach_line_id');
            $table->integer('common_rate');
            $table->boolean('is_in_bonus_program');

            $table->string('phone')->nullable();
            $table->integer('photos_count');
            $table->integer('popularity_level');
            $table->integer('rate');
            $table->integer('search_count');
            $table->integer('star_id');
            $table->string('star_name');

            $table->integer('town_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sl_hotels');
    }
}
