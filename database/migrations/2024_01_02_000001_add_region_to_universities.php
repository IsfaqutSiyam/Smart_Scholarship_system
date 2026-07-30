<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            // China's 7 geographic macro-regions
            $table->string('region', 50)->default('East China')
                  ->comment('North, Northeast, East, Central, South, Southwest, Northwest')
                  ->after('province');

            // Full-text search index for fast LIKE queries
            $table->index(['university_name', 'city', 'province', 'region'], 'uni_search_idx');
        });
    }

    public function down(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            $table->dropIndex('uni_search_idx');
            $table->dropColumn('region');
        });
    }
};
