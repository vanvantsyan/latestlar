<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_categories', function(Blueprint $table){

            $table->increments('id');
            $table->integer('parent_id')->default(0);
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();
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
        Schema::dropIfExists('news_categories');
    }
}
