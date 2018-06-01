<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursSletatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours_sletat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('price_id');
            $table->text('title');
            $table->integer('cityFrom_id');
            $table->integer('way_id');
            $table->string('leaveDate');
            $table->string('departDate');
            $table->integer('resort_id');
            $table->integer('hotel_id');
            $table->integer('operator_id');
            $table->string('hash_operator_id');
            $table->integer('adults_count');
            $table->integer('children_count');
            $table->string('meal_type');
            $table->string('hotel_category');
            $table->text('hotel_desc');
            $table->string('price');
            $table->tinyInteger('duration');
            $table->string('source');
            $table->string('image_url');
            $table->string('finish_date');
            $table->string('tour_id_cash');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours_sletat');
    }
}
