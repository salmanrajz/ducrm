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
        Schema::create('lead_sales', function (Blueprint $table) {
            //
            $table->id();
            $table->string('customer_name');
            $table->string('customer_number');
            $table->string('email')->nullable();
            $table->string('emirate_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->string('address')->nullable();
            $table->string('emirate')->nullable();
            $table->string('plans');
            $table->date('emirate_expiry')->nullable();
            $table->date('dob')->nullable();
            $table->float('status');
            $table->integer('saler_id');
            $table->string('saler_name');
            $table->date('lead_date')->useCurrent();
            // $table->date('lead_date')->useCurrent();
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
        Schema::table('lead_sales', function (Blueprint $table) {
            //
        });
    }
};
