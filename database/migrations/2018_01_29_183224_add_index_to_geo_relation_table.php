<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToGeoRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('geo_relation', function (Blueprint $table) {
            $table->index('sub_id');
            $table->index('par_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('geo_relation', function (Blueprint $table) {
            $table->dropIndex('sub_id');
            $table->dropIndex('par_id');
        });
    }
}
