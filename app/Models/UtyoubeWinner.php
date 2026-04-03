<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UtyoubeWinner extends Model
{
    protected $fillable = [
        'winner_date',
        'chance_number',
        'youtube_link',
        'total_links',
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
     * Atomically increment the clicks counter on the winner with the given ID.
     * Returns the new clicks value, or 0 if the ID is missing or no row exists.
     */
    public static function incrementClicks(?int $id = null): int
    {
        if ($id === null || $id < 1) {
            return 0;
        }

        $winner = self::query()->find($id);

        if (!$winner) {
            return 0;
        }

        $winner->increment('clicks');

        return (int) $winner->clicks;
    }

    /**
     * Winner rows for "Past Day Winner" on the home page: same calendar day as cron (today).
     */
    public static function displayedWinnerDate(): Carbon
    {
        return today()->subDay();
    }

    /**
     * Return winners for the home "Past Day Winner" section, keyed by chance_number (1-6).
     * If multiple rows share the same date + chance, the newest row (highest id) is used.
     */
    public static function todaysWinnersByChance(): array
    {
        return self::query()
            ->whereDate('winner_date', self::displayedWinnerDate())
            ->orderByDesc('id')
            ->get()
            ->unique('chance_number')
            ->keyBy('chance_number')
            ->all();
    }

    /**
     * After a successful submit for this chance, bump total_submissions on today's winner row (latest id).
     */
    public static function incrementSubmissionsForDisplayedChance(int $chance): void
    {
        $winner = self::query()
            ->whereDate('winner_date', self::displayedWinnerDate())
            ->where('chance_number', $chance)
            ->orderByDesc('id')
            ->first();

        if ($winner) {
            $winner->increment('total_submissions');
        }
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
        $query->whereDate('winner_date', '<', today()->subDay()); // Only winners from before today

        if ($q !== '') {
            $query->where(function ($builder) use ($q): void {
                // Check if the search query looks like a date
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $q)) {
                    // It's a YYYY-MM-DD format date
                    $builder->whereDate('winner_date', '=', $q);
                } 
                elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $q)) {
                    // It's a DD/MM/YYYY format date
                    $formattedDate = \Carbon\Carbon::createFromFormat('d/m/Y', $q)->format('Y-m-d');
                    $builder->whereDate('winner_date', '=', $formattedDate);
                }
                elseif (preg_match('/^\d{2}-\d{2}-\d{4}$/', $q)) {
                    // It's a DD-MM-YYYY format date
                    $formattedDate = \Carbon\Carbon::createFromFormat('d-m-Y', $q)->format('Y-m-d');
                    $builder->whereDate('winner_date', '=', $formattedDate);
                }
                else {
                    // Not a date format - do normal text search
                    $builder
                        ->where('winner_date', 'like', '%' . $q . '%')
                        ->orWhere('youtube_link', 'like', '%' . $q . '%');
                }
            });
        }

        $total = (clone $query)->count();

        /** @var Collection<int, self> $rows */
        $rows = $query
            ->orderByDesc('winner_date')
            ->orderByDesc('id')
            ->forPage($page, $limit)
            ->get();

        $serializedRows = $rows->map(static function (self $winner): array {
            return [
                'id' => (int) $winner->id,
                'winner_date' => $winner->winner_date?->toDateString() ?? '',
                'chance_number' => (int) $winner->chance_number,
                'youtube_link' => (string) $winner->youtube_link,
                'total_links' => (int) $winner->total_links,
                'total_submissions' => (int) $winner->total_submissions,
                'clicks' => (int) $winner->clicks,
            ];
        });

        return [
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'data' => $serializedRows
                ->groupBy('winner_date')
                ->map(static fn (Collection $group): array => $group->values()->all())
                ->all(),
        ];
    }
}
