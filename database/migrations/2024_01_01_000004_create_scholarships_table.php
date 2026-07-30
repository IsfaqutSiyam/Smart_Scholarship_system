<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id('scholarship_id');
            $table->unsignedBigInteger('university_id');
            $table->string('scholarship_name', 150);
            $table->enum('funding_type', ['full', 'partial', 'tuition_only']);
            $table->text('coverage_details')->nullable();
            $table->date('application_deadline');
            $table->text('eligibility_criteria');
            $table->decimal('min_cgpa', 3, 2)->nullable()->comment('Minimum CGPA for eligibility');
            $table->string('eligible_degree_levels', 100)->nullable()->comment('comma-separated: bachelor,master,phd');
            $table->string('eligible_fields', 255)->nullable()->comment('comma-separated fields, null = all');
            $table->integer('annual_amount_cny')->nullable()->comment('Annual award in CNY');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_visible')->default(true)->comment('Admin can hide upcoming deadlines');
            $table->timestamps();

            $table->foreign('university_id')
                  ->references('university_id')
                  ->on('universities')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
