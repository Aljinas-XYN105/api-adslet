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
        Schema::create('feedback_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_name');
            $table->integer('answer_type')->comment('1-Stars, 2-Numbers');
            $table->integer('no_expected_answers');
            $table->json('answer_labels')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_groups');
    }
};
