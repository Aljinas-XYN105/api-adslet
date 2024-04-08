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
        Schema::create('sms_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();  
            $table->text('message')->nullable(); 
            $table->boolean('type')->default('0');
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable(); 
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
        Schema::dropIfExists('sms_campaigns');
    }
};
