<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sms_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenantsms_id')->constrained('tenant_sms_gateways');
            $table->foreignId('tenant_id')->constrained('tenants'); 
            $table->integer('msg_length');
            $table->decimal('msg_price', 10, 2);
            $table->integer('msg_count')->default(1);
            $table->string('phonenumber');
            $table->text('textmessage');
            $table->text('response');
            $table->string('sender_id');
            $table->decimal('tenant_sms_price', 10, 2);
            $table->integer('msg_type')->default(1);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_histories');
    }
};
