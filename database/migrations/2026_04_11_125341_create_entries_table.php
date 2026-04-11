<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('manuscript_path');
            $table->foreignId('sponsorship_code_id')->nullable()->constrained('sponsorship_codes')->nullOnDelete();
            $table->string('stripe_session_id')->nullable()->unique();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('current_round')->nullable();
            $table->string('round_status')->nullable();
            $table->string('feedback_path')->nullable();
            $table->string('feedback_token')->nullable()->unique();
            $table->timestamp('feedback_sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
