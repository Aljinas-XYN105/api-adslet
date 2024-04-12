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
        Schema::create('feedback_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('terminal_id')->nullable();
            $table->unsignedBigInteger('feedback_group_id')->nullable();
            $table->unsignedInteger('total_feedbacks')->default(0);
            $table->float('average_rating')->default(0);
            $table->text('low_rank_question')->nullable();
            $table->text('high_rank_question')->nullable();
            $table->timestamps();

            $table->foreign('terminal_id')->references('id')->on('terminals')->onDelete('cascade');
            $table->foreign('feedback_group_id')->references('id')->on('feedback_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_reports');
    }
};
