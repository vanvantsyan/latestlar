<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DoNullableDescWay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ways', function (Blueprint $table) {
            $table->string('description')->nullable()->change();
            $table->boolean('off')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ways', function (Blueprint $table) {
            $table->string('description')->nullable(false)->change();
            $table->boolean('off')->nullable(false)->change();
        });
    }
}
