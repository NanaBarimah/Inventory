<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('equipment_code');
            $table->string('job_number');
            $table->timestamp('date_reported')->nullable();
            $table->timestamp('date_inspected')->nullable();
            $table->text('problem_found');
            $table->text('action_taken');
            $table->string('faulty_category');
            $table->text('recommendation');
            $table->double('cost');
            $table->string('mtce_officer');
            $table->string('type');
            $table->text('duration')->nullable();
            $table->string('duration_units')->nullable();
            $table->integer('down_time')->nullable();
            $table->text('reason')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->boolean('function_check');
            $table->boolean('safety_check');
            $table->boolean('calibration_check');
            $table->boolean('is_hospital_approved')->default(false);
            $table->timestamp('date_out')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('equipment_code')->references('code')->on('equipment')
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
        Schema::dropIfExists('maintenances');
    }
}
