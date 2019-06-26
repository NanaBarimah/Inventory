<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetPmSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_pm_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pm_schedule_id');
            $table->string('asset_id'); 
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pm_schedule_id')->references('id')->on('pm_schedules')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('asset_id')->references('id')->on('assets')
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
        Schema::dropIfExists('asset_pm_schedules');
    }
}
