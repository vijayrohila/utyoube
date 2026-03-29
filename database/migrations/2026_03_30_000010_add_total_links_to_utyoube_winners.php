<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('utyoube_winners', function (Blueprint $table) {
            $table->unsignedInteger('total_links')->default(0)->after('youtube_link');
        });

        // Former meaning of total_submissions was "pool size"; move to total_links and reset submissions counter.
        DB::table('utyoube_winners')->update([
            'total_links' => DB::raw('total_submissions'),
            'total_submissions' => 0,
        ]);
    }

    public function down(): void
    {
        // Best-effort: restore pool size into total_submissions
        DB::table('utyoube_winners')->update([
            'total_submissions' => DB::raw('total_links'),
        ]);

        Schema::table('utyoube_winners', function (Blueprint $table) {
            $table->dropColumn('total_links');
        });
    }
};
