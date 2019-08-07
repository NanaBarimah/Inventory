<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_categories', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->string('parent_id')->nullable();
            $table->string('region_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('region_id')->references('id')->on('regions')
                  ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('admin_categories', function(Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('admin_categories')
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
        Schema::dropIfExists('admin_categories');
    }
}
