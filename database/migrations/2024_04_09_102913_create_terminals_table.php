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
        Schema::create('terminals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('background_image')->nullable();
            $table->string('terminal_logo')->nullable();
            $table->string('success_message')->nullable();
            $table->unsignedBigInteger('feedback_group_id')->nullable();
            $table->boolean('phone_number_required')->default(false);
            $table->boolean('email_required')->default(false);
            $table->string('sms_sender_id')->nullable();
            $table->json('notification_settings')->nullable();
            $table->boolean('customer_notification')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('feedback_group_id')->references('id')->on('feedback_groups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terminals');
    }
};
