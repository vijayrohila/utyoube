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
        Schema::table('utyoube_submissions', function (Blueprint $table) {
            $table->dropUnique('utyoube_submissions_daily_session_chance_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utyoube_submissions', function (Blueprint $table) {
            $table->unique(
                ['submission_date', 'session_id', 'chance_number'],
                'utyoube_submissions_daily_session_chance_unique'
            );
        });
    }
};
