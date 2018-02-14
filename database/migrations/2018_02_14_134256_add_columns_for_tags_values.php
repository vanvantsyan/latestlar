<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsForTagsValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tours_tags_values', function (Blueprint $table) {
            $table->json('images')->nullable();
            $table->text('description')->nullable();
            $table->string('seo_title', 100)->nullable();
            $table->string('seo_h1', 100)->nullable();
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
        Schema::table('tours_tags_values', function (Blueprint $table) {
            $table->dropColumn('images');
            $table->dropColumn('seo_title');
            $table->dropColumn('seo_h1');
            $table->dropColumn('seo_desc');
            $table->dropColumn('seo_keywords');
        });
    }
}
