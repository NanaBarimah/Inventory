<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_purchases', function (Blueprint $table) {
            $table->string('part_id')->nullable();
            $table->string('purchase_order_id');
            $table->string('part_name')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_cost', 10, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('part_id')->references('id')->on('parts')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')
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
        Schema::dropIfExists('part_purchases');
    }
}
