<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Add2KeysIndexToTourTagsRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tour_tags_relations', function (Blueprint $table) {
            $table->index('value');
            $table->index('tour_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tour_tags_relations', function (Blueprint $table) {
            $table->dropIndex('value');
            $table->dropIndex('tour_id');
        });
    }
}
