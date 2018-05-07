<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ToursDescCanBeNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tours', function(Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->string('url')->nullable()->change();
            $table->json('images')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tours', function(Blueprint $table) {
            $table->text('description')->nullable(false)->change();
            $table->json('images')->nullable(false)->change();
        });
    }
}
