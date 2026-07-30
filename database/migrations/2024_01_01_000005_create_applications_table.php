<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id('application_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('scholarship_id')->nullable();
            $table->enum('status', ['draft', 'submitted', 'under_review', 'accepted', 'rejected'])->default('draft');
            $table->text('notes')->nullable();
            $table->date('submitted_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('program_id')->references('program_id')->on('programs')->onDelete('cascade');
            $table->foreign('scholarship_id')->references('scholarship_id')->on('scholarships')->onDelete('set null');

            $table->unique(['user_id', 'program_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
