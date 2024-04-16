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
            $table->foreignId('tenant_id')->constrained();
            $table->foreignId('branch_id')->nullable()->constrained();
            $table->string('name');
            $table->string('terminal_code');
            $table->string('background_image')->nullable();
            $table->string('terminal_logo')->nullable();
            $table->string('success_message')->nullable();
            $table->string('feedback_group_id')->nullable();
            $table->string('sms_sender_id')->nullable();
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
