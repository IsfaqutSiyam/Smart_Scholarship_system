<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id('university_id');
            $table->string('university_name', 150);
            $table->string('city', 100);
            $table->string('province', 100);
            $table->string('ranking_tier', 50)->comment('985, 211, Double First Class, Provincial');
            $table->enum('language_of_instruction', ['English', 'Mandarin', 'Bilingual'])->default('English');
            $table->text('description')->nullable();
            $table->string('website_url', 255)->nullable();
            $table->string('logo_url', 255)->nullable();
            $table->integer('established_year')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
