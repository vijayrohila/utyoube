<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $default = 'https://www.youtube.com';
        $now = now();
        foreach (range(1, 6) as $chance) {
            $key = 'fallback_winner_link_' . $chance;
            if (!DB::table('utyoube_settings')->where('key', $key)->exists()) {
                DB::table('utyoube_settings')->insert([
                    'key' => $key,
                    'value' => $default,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        foreach (range(1, 6) as $chance) {
            DB::table('utyoube_settings')->where('key', 'fallback_winner_link_' . $chance)->delete();
        }
    }
};
