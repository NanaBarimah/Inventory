<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParentIdToDistricts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('districts', function (Blueprint $table) {
            //
            $table->string("parent_id")->nullable()->after("name");
        });

        Schema::table("districts", function($table){
            $table->foreign("parent_id")->references("id")->on("districts")
            ->onUpdate("SET NULL")->onDelete("SET NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('districts', function (Blueprint $table) {
            //
            $table->dropColumn("parent_id");
        });
    }
}
