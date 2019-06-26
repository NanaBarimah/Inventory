<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PmScheduleActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_schedule_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('pm_schedule_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pm_schedule_id')->references('id')->on('pm_schedules')
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
        Schema::dropIfExists('pm_schedule_actions');
    }
}
