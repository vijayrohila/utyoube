<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UtyoubeWinner extends Model
{
    protected $fillable = [
        'winner_date',
        'chance_number',
        'youtube_link',
        'total_submissions',
        'clicks',
    ];

    protected function casts(): array
    {
        return [
            'winner_date' => 'date',
        ];
    }

    /**
     * Atomically increment the clicks counter on a specific winner by ID,
     * falling back to today's winner if no ID is supplied.
     * Returns the new clicks value, or 0 if no matching row exists.
     */
    public static function incrementClicks(?int $id = null): int
    {
        $winner = $id
            ? self::query()->find($id)
            : self::todaysWinner();

        if (!$winner) {
            return 0;
        }

        $winner->increment('clicks');

        return (int) $winner->clicks;
    }

    /**
     * Return today's winner row, or null if none exists for today.
     */
    public static function todaysWinner(): self|null
    {
        return self::query()
            ->whereDate('winner_date', today())
            ->orderByDesc('id')
            ->first();
    }

    /**
     * Return all of today's winners keyed by chance_number (1-6).
     * Missing chance numbers will simply be absent from the array.
     */
    public static function todaysWinnersByChance(): array
    {
        return self::query()
            ->whereDate('winner_date', today())
            ->get()
            ->keyBy('chance_number')
            ->all();
    }

    /**
     * Return a paginated winner list from the database using the JSON API shape
     * already consumed by the home page and admin page.
     */
    public static function paginatedList(int $page = 1, int $limit = 10, string $q = ''): array
    {
        $page = max(1, $page);
        $limit = max(1, $limit);

        $query = self::query();

        if ($q !== '') {
            $query->where(function ($builder) use ($q): void {
                $builder
                    ->where('winner_date', 'like', '%' . $q . '%')
                    ->orWhere('youtube_link', 'like', '%' . $q . '%');
            });
        }

        $total = (clone $query)->count();

        /** @var Collection<int, self> $rows */
        $rows = $query
            ->orderByDesc('winner_date')
            ->orderByDesc('id')
            ->forPage($page, $limit)
            ->get();

        return [
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'data' => $rows->map(static function (self $winner): array {
                return [
                    'id' => (int) $winner->id,
                    'winner_date' => $winner->winner_date?->toDateString() ?? '',
                    'chance_number' => (int) $winner->chance_number,
                    'youtube_link' => (string) $winner->youtube_link,
                    'total_submissions' => (int) $winner->total_submissions,
                    'clicks' => (int) $winner->clicks,
                ];
            })->values()->all(),
        ];
    }
}
