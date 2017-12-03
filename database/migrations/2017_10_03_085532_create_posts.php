<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function(Blueprint $table){

            $table->increments('id');
            $table->integer('category_id');
            $table->string('title', 100);
            $table->text('description');
            $table->text('text');
            $table->string('h1_title', 100)->nullable();
            $table->string('seo_title', 100)->nullable();
            $table->string('seo_desc', 100)->nullable();
            $table->string('seo_keys', 100)->nullable();
            $table->string('slug', 100)->unique();

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
