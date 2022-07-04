<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('zip');
            $table->string('uf');
            $table->string('city');
            $table->string('street');
            $table->string('number')->nullable();
            $table->string('neighborhood');
            $table->string('complement')->nullable();
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users'); long syntax, same as ->
            $table->foreignUuid('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
