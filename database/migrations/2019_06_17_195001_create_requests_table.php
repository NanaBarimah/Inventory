<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('priority_id')->nullable();
            $table->string('image')->nullable();
            $table->string('department_id')->nullable();
            $table->string('unit_id')->nullable();
            $table->string('asset_id')->nullable();
            $table->string('hospital_id');
            $table->string('requested_by')->nullable();
            $table->string('fileName')->nullable();
            $table->string('requester_name')->nullable();
            $table->string('requester_number')->nullable();
            $table->string('requester_email')->nullable();
            $table->smallInteger('status')->default(2);
            $table->text('reason')->nullable();
            $table->text('response')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('asset_id')->references('id')->on('assets')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('priority_id')->references('id')->on('priorities')
                  ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')
                  ->onUpdate('cascade')->onDelete('cascade'); 
            $table->foreign('unit_id')->references('id')->on('units')
                  ->onUpdate('cascade')->onDelete('cascade');  
            $table->foreign('requested_by')->references('id')->on('users')
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
        Schema::dropIfExists('requests');
    }
}
