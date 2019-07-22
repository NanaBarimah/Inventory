<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreventiveMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preventive_maintenances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pm_schedule_id');
            $table->text('observation')->nullable();
            $table->text('recommendation')->nullable();
            $table->text('action_taken')->nullable();
            $table->smallInteger('is_completed')->default(0);
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
        Schema::dropIfExists('preventive_maintenances');
    }
}
