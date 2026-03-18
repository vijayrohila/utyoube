<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('utyoube_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('utyoube_submissions', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });

        Schema::table('utyoube_chance_unlocks', function (Blueprint $table) {
            if (Schema::hasColumn('utyoube_chance_unlocks', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('utyoube_submissions', function (Blueprint $table) {
            if (!Schema::hasColumn('utyoube_submissions', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            }
        });

        Schema::table('utyoube_chance_unlocks', function (Blueprint $table) {
            if (!Schema::hasColumn('utyoube_chance_unlocks', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            }
        });
    }
};