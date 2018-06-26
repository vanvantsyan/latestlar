<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePtitleAndBtitleInGeneratedSeo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('generated_seo', function (Blueprint $table) {
            $table->text('pTitle')->nullable()->change();
            $table->text('bTitle')->nullable()->change();
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
            $table->text('pTitle')->change();
            $table->text('bTitle')->change();
        });
    }
}
