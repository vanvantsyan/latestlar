<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSeoFiledInTours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->string('seo_title', 100)->nullable();
            $table->string('seo_desc', 255)->nullable();
            $table->text('seo_keywords')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('seo_title');
            $table->dropColumn('seo_desc');
            $table->dropColumn('seo_keywords');
        });
    }
}
