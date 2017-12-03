<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeoVisa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visa', function(Blueprint $table){

            $table->string('seo_title', 100)->nullable();
            $table->string('seo_h1', 100)->nullable();
            $table->string('seo_desc', 255)->nullable();
            $table->text('seo_keywords')->nullable();
            $table->string('slug')->unique();

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
