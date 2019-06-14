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
            $table->increments('id');
            $table->string('equipment_code');
            $table->integer('service_vendor_id')->unsigned();
            $table->integer('requests_id')->unsigned();
            $table->smallInteger('status')->default(2);
            $table->smallInteger('is_local')->default(1);
            $table->text('description');
            $table->string('job_type');
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('equipment_code')->references('code')->on('equipment')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('service_vendor_id')->references('id')->on('service_vendors')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('requests_id')->references('id')->on('requests')
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
