<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableDescAndKeywordsForGeneratedSeo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('generated_seo', function (Blueprint $table) {
            $table->text('metaKey')->nullable()->change();
            $table->text('metaDesc')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('generated_seo', function (Blueprint $table) {
            $table->text('metaKey')->change();
            $table->text('metaDesc')->change();
        });
    }
}
