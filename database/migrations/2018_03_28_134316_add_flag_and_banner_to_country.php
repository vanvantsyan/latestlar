<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFlagAndBannerToCountry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geo_countries', function (Blueprint $table) {
            $table->json('flag')->nullable();
            $table->json('banner')->nullable();
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
            $table->dropColumn('flag');
            $table->dropColumn('banner');
        });
    }
}
