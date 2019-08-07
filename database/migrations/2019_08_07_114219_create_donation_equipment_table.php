<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('donation_id');
            $table->string('equipment_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('donation_id')->references('id')->on('donations')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('equipment_id')->references('id')->on('equipment')
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
        Schema::dropIfExists('donation_equipment');
    }
}
