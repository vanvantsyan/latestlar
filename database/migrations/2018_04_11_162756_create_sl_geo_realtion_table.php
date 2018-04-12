<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlGeoRealtionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sl_geo_relation', function (Blueprint $table) {

            $table->increments('id');

            $table->string('sub_ess');
            $table->string('par_ess');

            $table->integer('sub_id');
            $table->integer('par_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sl_geo_relation');
    }
}
