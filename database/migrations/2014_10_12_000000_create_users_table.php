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
        Schema::create('users', function (Blueprint $table) {
            $table->char('userID', 8);
            $table->string('userName', 30)->unique();
            $table->char('password', 100)->unique();
            $table->char('privilege', 13)->default('Guess');
            $table->char('status', 10)->default('Active');
            $table->rememberToken();
            $table->primary('userID');
        });

        DB::statement('ALTER TABLE users ADD CHECK (privilege IN ("Administrator", "Standard", "Guess"));');
        DB::statement('ALTER TABLE users ADD CHECK(status IN ("Active", "Deactivate"));');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
