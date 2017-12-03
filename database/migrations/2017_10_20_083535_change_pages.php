<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function(Blueprint $table){
            $table->string('title', 255)->after('id');
            $table->text('description')->after('title');
            $table->text('content')->after('description');
            $table->timestamp('date_pub')->after('content');
            $table->string('seo_title', 100)->after('content');
            $table->string('seo_h1', 100)->after('seo_title');
            $table->string('seo_desc', 255)->after('seo_h1');
            $table->text('seo_keywords')->after('seo_desc');
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
