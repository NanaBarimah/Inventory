<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateCompletedToPreventiveMaintenances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('preventive_maintenances', function (Blueprint $table) {
            $table->timestamp('date_completed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('preventive_maintenances', function (Blueprint $table) {
            $table->dropColumn('date_completed');
        });
    }
}
