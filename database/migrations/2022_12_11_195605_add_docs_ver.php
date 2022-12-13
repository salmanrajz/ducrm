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
        Schema::table('verification_forms', function (Blueprint $table) {
            //
            $table->string('additional_docs_name')->nullable();
            $table->string('front_id')->nullable();
            $table->string('back_id')->nullable();
            $table->string('additional_docs_photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('verification_forms', function (Blueprint $table) {
            //
        });
    }
};
