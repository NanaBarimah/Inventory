<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->string('code')->primary();
            $table->string('serial_number')->unique();
            $table->string('model_number');
            $table->string('manufacturer_name');
            $table->string('status')->default('good');
            $table->text('description');
            $table->string('location');
            $table->string('year_of_purchase');
            $table->timestamp('installation_time')->nullable();
            $table->timestamp('pos_rep_date')->nullable();
            $table->double('equipment_cost')->nullable();
            $table->integer('service_vendor_id')->unsigned();
            $table->integer('hospital_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->string('user_id');
            $table->integer('maintenance_frequency');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('hospital_id')->references('id')->on('hospitals')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('service_vendor_id')->references('id')->on('service_vendors')
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
        Schema::dropIfExists('equipment');
    }
}
