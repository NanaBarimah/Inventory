<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssetCategoryIdToPmSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pm_schedules', function (Blueprint $table) {
            $table->string('asset_category_id')->nullable();

            $table->foreign('asset_category_id')->references('id')->on('asset_categories')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pm_schedules', function (Blueprint $table) {
            $table->dropColumn('asset_category_id');
        });
    }
}
