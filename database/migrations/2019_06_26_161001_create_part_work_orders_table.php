<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_work_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('part_id');
            $table->string('work_order_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('part_id')->references('id')->on('parts')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('work_order_id')->references('id')->on('work_orders')
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
        Schema::dropIfExists('part_work_orders');
    }
}
