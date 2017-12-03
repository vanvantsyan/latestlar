<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa', function(Blueprint $table){

            $table->increments('id');
            $table->integer('country_id');
            $table->string('time', 30);
            $table->decimal('amount');
            $table->string('amount_desc', 100)->nullable();
            $table->text('docs');
            $table->json('add_docs')->nullable();
            $table->timestamps();

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
