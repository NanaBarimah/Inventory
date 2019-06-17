<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('quantity')->default(0);
            $table->integer('min_quantity')->default(0);
            $table->decimal('cost', 10, 2);
            $table->string('image')->nullable();
            $table->string('area')->nullable();
            $table->string('part_category_id')->nullable();
            $table->string('hospital_id');
            $table->text('description')->nullable();
            $table->date('manufacturer_year')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('part_category_id')->references('id')->on('part_categories')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('hospital_id')->references('id')->on('hospitals')
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
        Schema::dropIfExists('parts');
    }
}
