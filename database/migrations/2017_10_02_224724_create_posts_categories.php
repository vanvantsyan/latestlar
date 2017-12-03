<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_categories',function(Blueprint $table){

            $table->increments('id');
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->tinyInteger('private')->default(0);
            $table->string('h1_title', 100)->nullable();
            $table->string('seo_title', 100)->nullable();
            $table->text('seo_desc')->nullable();
            $table->text('seo_keys')->nullable();
            $table->string('slug', 100);

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
