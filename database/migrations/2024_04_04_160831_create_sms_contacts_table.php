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
        Schema::create('sms_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('smsgroup_id');
            $table->text('phone_number')->nullable();
            $table->timestamps();

            $table->foreign('smsgroup_id')
                  ->references('id')
                  ->on('sms_groups')
                  ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_contacts');
    }
};
