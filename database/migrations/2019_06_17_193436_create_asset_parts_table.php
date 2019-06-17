<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_parts', function (Blueprint $table) {
            $table->string('asset_id');
            $table->string('part_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('asset_id')->references('id')->on('assets')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('part_id')->references('id')->on('parts')
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
        Schema::dropIfExists('asset_parts');
    }
}
