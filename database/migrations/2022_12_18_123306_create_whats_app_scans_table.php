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
        Schema::create('whats_app_scans', function (Blueprint $table) {
            $table->id();
            $table->string('wapnumber')->nullable();
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->string('count_digit')->nullable();
            $table->string('is_aamt')->nullable();
            $table->integer('is_whatsapp')->default(0);
            $table->string('prefix')->nullable();
            $table->timestamps();
        });
        // protected $fillable = [
        // 'wapnumber','start','end', 'count_digit','is_aamt'
        // ];
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whats_app_scans');
    }
};
