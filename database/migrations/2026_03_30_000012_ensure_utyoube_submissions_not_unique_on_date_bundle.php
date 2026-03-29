<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const INDEX = 'utyoube_submissions_daily_session_chance_unique';

    /**
     * submission_date (and session/chance bundle) must not be unique — many rows per day are allowed.
     * Idempotent: safe if the index was never created or was already dropped.
     */
    public function up(): void
    {
        if (! Schema::hasTable('utyoube_submissions')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            $schema = Schema::getConnection()->getDatabaseName();
            $row = DB::selectOne(
                'SELECT COUNT(1) AS c FROM information_schema.statistics
                 WHERE table_schema = ? AND table_name = ? AND index_name = ?',
                [$schema, 'utyoube_submissions', self::INDEX]
            );
            if ($row && (int) $row->c > 0) {
                Schema::table('utyoube_submissions', function (Blueprint $table): void {
                    $table->dropUnique(self::INDEX);
                });
            }

            return;
        }

        if ($driver === 'sqlite') {
            DB::statement('DROP INDEX IF EXISTS "' . self::INDEX . '"');

            return;
        }

        if ($driver === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS ' . self::INDEX);
        }
    }

    public function down(): void
    {
        // Do not re-add uniqueness; see 2026_03_24_000007 down() if rollback is required.
    }
};
