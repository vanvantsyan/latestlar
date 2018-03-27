<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableGeneratedSeo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generated_seo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->unique();

            $table->string('pTitle');
            $table->string('bTitle');

            $table->text('metaKey');
            $table->text('metaDesc');
            $table->text('subText');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generated_seo');
    }
}
