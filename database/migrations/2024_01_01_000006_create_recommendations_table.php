<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id('recommendation_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('university_id');
            $table->unsignedBigInteger('program_id');
            $table->decimal('match_score', 5, 2)->comment('0-100 score from rule-based engine');
            $table->json('score_breakdown')->nullable()->comment('JSON: {field_match, cgpa_score, language_score, ranking_score}');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('university_id')->references('university_id')->on('universities')->onDelete('cascade');
            $table->foreign('program_id')->references('program_id')->on('programs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
