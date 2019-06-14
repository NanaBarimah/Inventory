<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('equipment_code');
            $table->text('description');
            $table->string('requested_by');
            $table->smallInteger('status')->default(2);
            $table->text('reason');
            $table->text('response');
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
        Schema::dropIfExists('requests');
    }
}
