<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title');
            $table->integer('wo_number');
            $table->smallInteger('status')->default(4);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->date('due_date')->nullable();
            $table->string('frequency')->nullable();
            $table->integer('estimated_duration')->nullable();
            $table->string('priority_id')->nullable();
            $table->string('hospital_id');
            $table->string('fault_category_id')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('admin_id')->nullable();
            $table->string('department_id')->nullable();
            $table->string('unit_id')->nullable();
            $table->string('service_vendor_id')->nullable();
            $table->string('request_id')->nullable();
            $table->string('fileName')->nullable();
            $table->smallInteger('is_local')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('priority_id')->references('id')->on('priorities')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('hospital_id')->references('id')->on('hospitals')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fault_category_id')->references('id')->on('fault_categories')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('service_vendor_id')->references('id')->on('service_vendors')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('request_id')->references('id')->on('requests')
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
        Schema::dropIfExists('work_orders');
    }
}
