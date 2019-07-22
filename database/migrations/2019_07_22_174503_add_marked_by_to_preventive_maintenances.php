<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMarkedByToPreventiveMaintenances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preventive_maintenances', function (Blueprint $table) {
            $table->string('marked_by')->nullable();

            $table->foreign('marked_by')->references('id')->on('users')
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
        Schema::table('preventive_maintenances', function (Blueprint $table) {
            $table->dropColumn('marked_by');
        });
    }
}
