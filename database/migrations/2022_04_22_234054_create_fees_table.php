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
        Schema::create('fees', function (Blueprint $table) {
            $table->id('feeID');
            $table->char('studentID', 11);
            $table->char('staffID', 11);
            $table->char('classID', 8);
            $table->date('date');
            $table->decimal('paidAmount', 7, 2);
            $table->char('paidStatus',1);
            $table->foreign('studentID')->references('studentID')->on('students');
            $table->foreign('staffID')->references('staffID')->on('staff');
            $table->foreign('classID')->references('classID')->on('classes');
            //$table->primary('feeID');
        });

        DB::statement('ALTER TABLE fees ADD CHECK (paidStatus IN ("P", "A"));');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fees');
    }
};
