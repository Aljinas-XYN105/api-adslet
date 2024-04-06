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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('api_key')->unique();
            $table->string('api_password')->unique();
            $table->string('email')->unique();
            $table->integer('no_of_terminals')->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->string('phone_number')->nullable();
            $table->decimal('wallet', 10, 3)->default(0.000);
            $table->decimal('sms_amount', 10, 3)->default(0.000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
