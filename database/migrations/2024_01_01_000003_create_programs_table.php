<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id('program_id');
            $table->unsignedBigInteger('university_id');
            $table->string('program_name', 150);
            $table->enum('degree_level', ['bachelor', 'master', 'phd']);
            $table->string('field_of_study', 100);
            $table->string('duration', 50)->comment('e.g. 4 years, 2.5 years');
            $table->string('tuition_fee', 100)->nullable()->comment('Annual fee in CNY or USD');
            $table->string('language_requirement', 100)->nullable()->comment('e.g. IELTS 6.0, HSK 4, None');
            $table->decimal('min_cgpa', 3, 2)->nullable()->comment('Minimum CGPA required');
            $table->text('application_guidance')->nullable()->comment('Required docs, steps, deadlines');
            $table->date('application_deadline')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('university_id')
                  ->references('university_id')
                  ->on('universities')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
