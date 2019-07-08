<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_schedules', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title');
            $table->string('recurringSchedule');
            $table->date('due_date');
            $table->date('endDueDate')->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->string('department_id')->nullable();
            $table->string('unit_id')->nullable();
            $table->string('priority_id')->nullable();
            $table->string('hospital_id');
            $table->boolean('rescheduledBasedOnCompletion')->default(1);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('department_id')->references('id')->on('departments')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('priority_id')->references('id')->on('priorities')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('hospital_id')->references('id')->on('hospitals')
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
        Schema::dropIfExists('pm_schedules');
    }
}
