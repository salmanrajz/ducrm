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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('agent_code')->nullable();
            $table->string('role')->nullable();
            $table->string('profile')->nullable();
            $table->string('emirate')->nullable();
            $table->string('phone')->nullable();
            $table->string('notify_email')->nullable();
            $table->string('jobtype')->nullable();
            $table->string('sl')->nullable();
            $table->string('cnic_front')->nullable();
            $table->string('cnic_back')->nullable();
            $table->bigInteger('cnic_number')->nullable();
            $table->string('multi_agentcode')->nullable();
            $table->ipAddress('call_center_ip')->nullable();
            $table->ipAddress('secondary_ip')->nullable();
            $table->string('secondary_email')->nullable();
            $table->bigInteger('extension')->nullable();
            $table->bigInteger('business_whatsapp')->nullable();
            $table->string('business_whatsapp_undertaking')->nullable();
            $table->string('teamleader')->nullable();
            $table->string('contact_docs_old')->nullable();
            $table->integer('is_mnp')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
