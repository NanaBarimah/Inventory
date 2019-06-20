<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title');
            $table->integer('po_number');
            $table->date('due_date');
            $table->string('service_vendor_id');
            $table->string('added_by');
            $table->decimal('item_cost', 10, 2);
            $table->decimal('sales_tax', 10, 2)->nullable();
            $table->decimal('shipping_cost', 10, 2)->nullable();
            $table->decimal('other_cost', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('shipping_method')->nullable();
            $table->text('terms')->nullable();
            $table->text('notes')->nullable();
            $table->string('hospital_id');
            $table->string('hospital_name')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('contact_name')->nullable();
            $table->smallInteger('status')->default(2);
            $table->smallInteger('is_fulfilled')->default(0);
            $table->string('work_order_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('service_vendor_id')->references('id')->on('service_vendors')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('hospital_id')->references('id')->on('hospitals')
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
        Schema::dropIfExists('purchase_orders');
    }
}
