<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoursTypeInCities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geo_cities', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->json('images')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->integer('magput')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('geo_cites', function (Blueprint $table) {
            $table->text('image');
            $table->dropColumn('images');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('magput');
        });
    }
}
