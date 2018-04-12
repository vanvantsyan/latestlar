<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sl_countries', function (Blueprint $table) {
            $table->integer('id')->unique();

            $table->string('name');
            $table->string('alias');

            $table->integer('city_id');

            $table->integer('flags')->nullable();

            $table->boolean('has_tickets');
            $table->boolean('hotel_is_not_stop');
            $table->boolean('is_pro_visa');
            $table->boolean('is_visa');

            $table->integer('rank')->nullable();
            $table->boolean('tickets_included');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sl_countries');
    }
}
