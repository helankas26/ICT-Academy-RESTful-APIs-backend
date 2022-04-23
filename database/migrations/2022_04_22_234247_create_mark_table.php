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
        Schema::create('mark', function (Blueprint $table) {
            $table->char('examID', 8);
            $table->char('studentID', 11);
            $table->smallInteger('mark')->default(0);
            $table->foreign('examID')->references('examID')->on('exams')->cascadeOnDelete();
            $table->foreign('studentID')->references('studentID')->on('students')->cascadeOnDelete();
            $table->primary(['examID', 'studentID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mark');
    }
};
