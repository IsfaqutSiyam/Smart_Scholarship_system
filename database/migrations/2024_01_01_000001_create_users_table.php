<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('full_name', 100);
            $table->string('email', 150)->unique();
            $table->string('password_hash', 255);
            $table->string('academic_background', 150)->nullable();
            $table->string('preferred_field', 100)->nullable();
            $table->decimal('cgpa', 3, 2)->nullable();
            $table->string('language_proficiency', 100)->nullable()->comment('e.g. IELTS 6.5, HSK 4, English Native');
            $table->enum('degree_seeking', ['bachelor', 'master', 'phd'])->nullable();
            $table->enum('role', ['student', 'admin'])->default('student');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
