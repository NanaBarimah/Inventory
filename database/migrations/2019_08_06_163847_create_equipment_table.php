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
            $table->string('id')->primary();
            $table->string('parent_id')->nullable();
            $table->string('name');
            $table->string('type');
            $table->string('region_id');
            $table->string('equipment_code');
            $table->string('admin_category_id')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('image')->nullable();
            $table->string('admin_id')->nullable();
            $table->string('status');
            $table->text('description')->nullable();
            $table->string('area')->nullable();
            $table->string('serial_number')->unique()->nullable();
            $table->string('model_number')->nullable();
            $table->string('manufacturer_name')->nullable();
            $table->text('reason')->nullable();
            $table->date('warranty_expiration')->nullable();
            $table->string('procurement_type');
            $table->string('donor')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('region_id')->references('id')->on('regions')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('admin_category_id')->references('id')->on('admin_categories')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')
                  ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('equipment', function($table) {
            $table->foreign('parent_id')->references('id')->on('equipment')
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
