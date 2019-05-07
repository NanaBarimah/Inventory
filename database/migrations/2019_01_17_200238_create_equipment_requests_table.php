<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_requests', function (Blueprint $table) {
            $table->primary(['requests_id', 'equipment_code']);
            $table->integer('requests_id')->unsigned();
            $table->string('equipment_code');
            $table->timestamps();
            $table->softDeletes();
        
            $table->foreign('equipment_code')->references('code')->on('equipment')
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
        Schema::dropIfExists('equipment_requests');
    }
}
