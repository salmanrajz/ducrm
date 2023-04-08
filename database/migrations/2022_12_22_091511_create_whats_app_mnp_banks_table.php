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
        Schema::create('whats_app_mnp_banks', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('number_id')->nullable();
            $table->string('language')->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->string('soft_dnd')->nullable();
            $table->string('dnd')->nullable();
            $table->string('data_valid_from')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whats_app_mnp_banks');
    }
};
