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
        Schema::create('test_number_emirtis', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('fiver_four')->nullable();
            $table->string('five_five')->nullable();
            $table->string('five_eight')->nullable();
            // $table->string('prefix')->nullable();
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
        Schema::dropIfExists('test_number_emirtis');
    }
};
