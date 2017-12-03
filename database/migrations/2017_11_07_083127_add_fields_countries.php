<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geo_countries', function(Blueprint $table){

            $table->text('image')->nullable();
            $table->text('description')->nullable();
            $table->string('seo_title', 100)->nullable();
            $table->string('seo_h1', 100)->nullable();
            $table->string('seo_desc', 255)->nullable();
            $table->text('seo_keywords')->nullable();
            $table->string('slug', 100)->unique()->nullable();

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
