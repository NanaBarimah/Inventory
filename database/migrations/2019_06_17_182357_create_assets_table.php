<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('parent_id')->nullable();
            $table->string('name');
            $table->string('asset_code');
            $table->string('asset_category_id')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('image')->nullable();
            $table->string('user_id')->nullable();
            $table->date('installation_date')->nullable();
            $table->string('status');
            $table->string('availability');
            $table->text('description')->nullable();
            $table->string('area')->nullable();
            $table->string('department_id')->nullable();
            $table->string('unit_id')->nullable();
            $table->date('pos_rep_date')->nullable();
            $table->string('serial_number')->unique()->nullable();
            $table->string('model_number')->nullable();
            $table->string('manufacturer_name')->nullable();
            $table->string('service_vendor_id')->nullable();
            $table->string('hospital_id');
            $table->text('reason')->nullable();
            $table->date('warranty_expiration')->nullable();
            $table->string('procurement_type');
            $table->string('donor')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('service_vendor_id')->references('id')->on('service_vendors')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('hospital_id')->references('id')->on('hospitals')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('asset_category_id')->references('id')->on('asset_categories')
                  ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('assets', function($table) {
            $table->foreign('parent_id')->references('id')->on('assets')
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
        Schema::dropIfExists('assets');
    }
}
