<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToSletatTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('sl_depart_cities', function (Blueprint $table) {
//            $table->primary('id');
//        });
//        Schema::table('sl_countries', function (Blueprint $table) {
//            $table->primary('id');
//        });
//        Schema::table('sl_hotels', function (Blueprint $table) {
//            $table->primary('id');
//        });
        Schema::table('sl_hotel_stars', function (Blueprint $table) {
            $table->primary('id');
        });
        Schema::table('sl_meals', function (Blueprint $table) {
            $table->primary('id');
        });
        Schema::table('sl_operators', function (Blueprint $table) {
            $table->primary('id');
        });
        Schema::table('sl_resort', function (Blueprint $table) {
            $table->primary('id');
        });

        Schema::table('sl_geo_relation', function(Blueprint $table){
            $table->index('sub_ess');
            $table->index('par_ess');
            $table->index('sub_id');
            $table->index('par_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('sl_depart_cities', function (Blueprint $table) {
//            $table->dropPrimary('id');
//        });
//        Schema::table('sl_countries', function (Blueprint $table) {
//            $table->dropPrimary('id');
//        });
//        Schema::table('sl_hotels', function (Blueprint $table) {
//            $table->dropPrimary('id');
//        });
        Schema::table('sl_hotel_stars', function (Blueprint $table) {
            $table->dropPrimary('id');
        });
        Schema::table('sl_meals', function (Blueprint $table) {
            $table->dropPrimary('id');
        });
        Schema::table('sl_operators', function (Blueprint $table) {
            $table->dropPrimary('id');
        });
        Schema::table('sl_resort', function (Blueprint $table) {
            $table->dropPrimary('id');
        });

        Schema::table('sl_geo_relation', function(Blueprint $table){
            $table->dropIndex('sub_ess');
            $table->dropIndex('par_ess');
            $table->dropIndex('sub_id');
            $table->dropIndex('par_id');
        });
    }
}
