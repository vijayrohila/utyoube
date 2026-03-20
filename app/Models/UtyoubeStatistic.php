<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtyoubeStatistic extends Model
{
    protected $table = 'utyoube_statistics';

    protected $fillable = [
        'stats_date',
        'live_visitors',
        'today_visitors',
        'total_visitors',
        'winner_clicks',
    ];

    protected function casts(): array
    {
        return [
            'stats_date' => 'date',
        ];
    }

    // ---------------------------------------------------------------
    // Public API
    // ---------------------------------------------------------------

    /**
     * Bump today's visitor count if this session has not been counted
     * yet today, then return the current stats as an array.
     */
    public static function bumpVisit(Request $request): array
    {
        $today = Carbon::today()->toDateString();
        $row = self::getOrCreateToday();

        $sessionDay = $request->session()->get('utyoube_visit_day');
        if ($sessionDay !== $today) {
            $row->increment('today_visitors');
            $row->increment('total_visitors');
            $request->session()->put('utyoube_visit_day', $today);
            $row->refresh();
        }

        return [
            'live'    => self::getLiveCount(),
            'today'   => (int) $row->today_visitors,
            'total'   => (int) $row->total_visitors,
        ];
    }

    /**
     * Return live/today/total without bumping any counter.
     */
    public static function getStats(): array
    {
        $row = self::getOrCreateToday();

        return [
            'live'  => self::getLiveCount(),
            'today' => (int) $row->today_visitors,
            'total' => (int) $row->total_visitors,
        ];
    }

    /**
     * Count sessions that were active in the last 10 minutes.
     */
    public static function getLiveCount(): int
    {
        $threshold = Carbon::now()->subMinutes(10)->timestamp;

        $count = DB::table('sessions')
            ->where('last_activity', '>=', $threshold)
            ->count();

        return max(1, (int) $count);
    }

    // ---------------------------------------------------------------
    // Internal helpers
    // ---------------------------------------------------------------

    /**
     * Get today's statistics row, creating it if it does not exist.
     * When creating, the total_visitors is seeded from the most recent
     * previous row so the counter is always cumulative.
     */
    private static function getOrCreateToday(): self
    {
        $today = Carbon::today()->toDateString();

        return self::firstOrCreate(
            ['stats_date' => $today],
            [
                'live_visitors'  => 1,
                'today_visitors' => 0,
                'total_visitors' => self::previousTotal(),
                'winner_clicks'  => 0,
            ]
        );
    }

    /**
     * Return the total_visitors from the most recent past row,
     * or 0 if no previous row exists.
     */
    private static function previousTotal(): int
    {
        $row = self::query()
            ->whereDate('stats_date', '<', Carbon::today())
            ->orderByDesc('stats_date')
            ->first();

        return $row ? (int) $row->total_visitors : 0;
    }
}
