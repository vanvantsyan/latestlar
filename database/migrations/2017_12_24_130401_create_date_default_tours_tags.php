<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;
class CreateDateDefaultToursTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tours_tags', function (Blueprint $table) {
            $table->date('date')->default(Carbon::now())->change();
            $table->string('type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tours_tags', function (Blueprint $table) {
            $table->date('date')->default(NULL)->change();
            $table->string('type')->nullable(false)->change();
        });
    }
}
