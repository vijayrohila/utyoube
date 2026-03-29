<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const UNIQUE = 'utyoube_winners_date_chance_unique';

    private const COMPOSITE_INDEX = 'utyoube_winners_winner_date_chance_index';

    /**
     * Allow multiple winner rows for the same (winner_date, chance_number).
     */
    public function up(): void
    {
        if (! Schema::hasTable('utyoube_winners')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            $schema = Schema::getConnection()->getDatabaseName();
            $row = DB::selectOne(
                'SELECT COUNT(1) AS c FROM information_schema.statistics
                 WHERE table_schema = ? AND table_name = ? AND index_name = ?',
                [$schema, 'utyoube_winners', self::UNIQUE]
            );
            if ($row && (int) $row->c > 0) {
                Schema::table('utyoube_winners', function (Blueprint $table): void {
                    $table->dropUnique(self::UNIQUE);
                });
            }

            $hasComposite = DB::selectOne(
                'SELECT COUNT(1) AS c FROM information_schema.statistics
                 WHERE table_schema = ? AND table_name = ? AND index_name = ?',
                [$schema, 'utyoube_winners', self::COMPOSITE_INDEX]
            );
            if (! $hasComposite || (int) $hasComposite->c === 0) {
                Schema::table('utyoube_winners', function (Blueprint $table): void {
                    $table->index(['winner_date', 'chance_number'], self::COMPOSITE_INDEX);
                });
            }

            return;
        }

        if ($driver === 'sqlite') {
            DB::statement('DROP INDEX IF EXISTS "' . self::UNIQUE . '"');
            // SQLite: non-unique composite for lookups (ignore error if duplicate name on re-run)
            try {
                Schema::table('utyoube_winners', function (Blueprint $table): void {
                    $table->index(['winner_date', 'chance_number'], self::COMPOSITE_INDEX);
                });
            } catch (\Throwable) {
                // index may already exist
            }

            return;
        }

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE utyoube_winners DROP CONSTRAINT IF EXISTS ' . self::UNIQUE);
            try {
                Schema::table('utyoube_winners', function (Blueprint $table): void {
                    $table->index(['winner_date', 'chance_number'], self::COMPOSITE_INDEX);
                });
            } catch (\Throwable) {
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('utyoube_winners')) {
            return;
        }

        Schema::table('utyoube_winners', function (Blueprint $table): void {
            try {
                $table->dropIndex(self::COMPOSITE_INDEX);
            } catch (\Throwable) {
            }
            $table->unique(['winner_date', 'chance_number'], self::UNIQUE);
        });
    }
};
