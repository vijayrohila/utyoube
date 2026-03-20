<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('utyoube_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('utyoube_submissions', 'winner_id')) {
                $table->dropConstrainedForeignId('winner_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('utyoube_submissions', function (Blueprint $table) {
            if (!Schema::hasColumn('utyoube_submissions', 'winner_id')) {
                $table->foreignId('winner_id')->nullable()->constrained('utyoube_winners')->nullOnDelete();
            }
        });
    }
};