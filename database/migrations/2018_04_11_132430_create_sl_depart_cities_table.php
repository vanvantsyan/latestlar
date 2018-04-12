<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlDepartCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sl_depart_cities', function (Blueprint $table) {

            $table->integer('id');
            $table->string('name');
            $table->integer('country_id')->nullable();
            $table->text('description_url')->nullable();
            $table->boolean('is_popular')->nullable();
            $table->integer('parent_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sl_depart_cities');
    }
}
