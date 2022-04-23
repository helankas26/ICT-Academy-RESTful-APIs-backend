<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advance_employees', function (Blueprint $table) {
            $table->foreignId('advanceID');
            $table->char('employeeID', 11);
            $table->foreign('advanceID')->references('advanceID')->on('advances')->cascadeOnDelete();
            $table->foreign('employeeID')->references('employeeID')->on('employees')->cascadeOnDelete();
            $table->primary(['advanceID', 'employeeID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advance_employees');
    }
};
