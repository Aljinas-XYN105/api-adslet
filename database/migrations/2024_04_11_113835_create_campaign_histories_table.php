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
        Schema::create('campaign_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sms_campaign_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->text('message');
            $table->date('date')->nullable();
            $table->time('time')->nullable(); 
            $table->tinyInteger('status')->comment('0 - Not Started, 1 - Running, 2 - Paused, 3 - Cancelled, 4 - Finished');
            $table->string('queue_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_histories');
    }
};
