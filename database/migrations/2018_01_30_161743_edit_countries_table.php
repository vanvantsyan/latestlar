<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geo_countries', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->json('images')->nullable();
            $table->integer('magput')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('geo_countries', function (Blueprint $table) {
            $table->text('image');
            $table->dropColumn('images');
            $table->dropColumn('magput');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
}
