<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add plan fields to users
        Schema::table('users', function (Blueprint $table) {
            $table->enum('plan', ['free', 'premium'])->default('free')->after('role');
            $table->timestamp('plan_expires_at')->nullable()->after('plan');
        });

        // Subscriptions table (payment records)
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id('subscription_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('plan', ['premium']);
            $table->enum('duration_months', [1, 3, 6, 12]);
            $table->decimal('amount_bdt', 10, 2);
            $table->enum('payment_method', ['sslcommerz', 'bkash', 'nagad', 'manual'])->default('sslcommerz');
            $table->string('transaction_id', 100)->nullable()->unique();
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->json('payment_response')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['plan', 'plan_expires_at']);
        });
    }
};
