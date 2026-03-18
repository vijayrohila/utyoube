<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UtyoubeDataStore
{
    private string $path;

    public function __construct()
    {
        $this->path = storage_path('app/private/utyoube_data.json');
    }

    public function getData(): array
    {
        if (!File::exists($this->path)) {
            $this->initialize();
        }

        $raw = File::get($this->path);
        $decoded = json_decode($raw, true);

        if (!is_array($decoded)) {
            $this->initialize();
            $decoded = json_decode(File::get($this->path), true) ?: [];
        }

        return $this->normalize($decoded);
    }

    public function saveData(array $data): void
    {
        $data = $this->normalize($data);
        File::ensureDirectoryExists(dirname($this->path));
        File::put($this->path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function bumpVisitForSession(Request $request): array
    {
        $data = $this->getData();
        $today = Carbon::today()->toDateString();

        if (($data['stats']['today_date'] ?? null) !== $today) {
            $data['stats']['today_date'] = $today;
            $data['stats']['today'] = 0;
        }

        $sessionDay = $request->session()->get('utyoube_visit_day');
        if ($sessionDay !== $today) {
            $data['stats']['today'] = (int) ($data['stats']['today'] ?? 0) + 1;
            $data['stats']['total'] = (int) ($data['stats']['total'] ?? 0) + 1;
            $request->session()->put('utyoube_visit_day', $today);
            $this->saveData($data);
        }

        return $data['stats'];
    }

    public function getStats(): array
    {
        $data = $this->getData();
        return $data['stats'];
    }

    public function getCurrentWinner(): ?array
    {
        $data = $this->getData();
        $winners = $data['winners'] ?? [];
        if (empty($winners)) {
            return null;
        }

        usort($winners, static function (array $a, array $b): int {
            $dateCmp = strcmp($b['winner_date'] ?? '', $a['winner_date'] ?? '');
            if ($dateCmp !== 0) {
                return $dateCmp;
            }
            return (int) ($b['id'] ?? 0) <=> (int) ($a['id'] ?? 0);
        });

        return $winners[0];
    }

    public function addSubmission(array|string $submission): void
    {
        $data = $this->getData();
        $nextId = $this->nextId($data['submissions'] ?? []);

        if (is_string($submission)) {
            $submission = [
                'youtube_link' => $submission,
            ];
        }

        $data['submissions'][] = [
            'id' => $nextId,
            'youtube_link' => (string) ($submission['youtube_link'] ?? ''),
            'chance' => isset($submission['chance']) ? (int) $submission['chance'] : null,
            'submitted_on' => (string) ($submission['submitted_on'] ?? Carbon::today()->toDateString()),
            'created_at' => now()->toDateTimeString(),
        ];

        $this->saveData($data);
    }

    public function incrementWinnerClicks(): int
    {
        $data = $this->getData();
        $current = $this->getCurrentWinner();

        if (!$current) {
            return 0;
        }

        foreach ($data['winners'] as &$winner) {
            if ((int) ($winner['id'] ?? 0) === (int) $current['id']) {
                $winner['clicks'] = (int) ($winner['clicks'] ?? 0) + 1;
                $data['stats']['winner_clicks'] = (int) $winner['clicks'];
                $this->saveData($data);
                return (int) $winner['clicks'];
            }
        }

        return (int) ($data['stats']['winner_clicks'] ?? 0);
    }

    public function listWinners(int $page = 1, int $limit = 10, string $q = ''): array
    {
        $data = $this->getData();
        $winners = $data['winners'] ?? [];

        if ($q !== '') {
            $q = mb_strtolower($q);
            $winners = array_values(array_filter($winners, static function (array $row) use ($q): bool {
                $date = mb_strtolower((string) ($row['winner_date'] ?? ''));
                $link = mb_strtolower((string) ($row['youtube_link'] ?? ''));
                return str_contains($date, $q) || str_contains($link, $q);
            }));
        }

        usort($winners, static function (array $a, array $b): int {
            $dateCmp = strcmp($b['winner_date'] ?? '', $a['winner_date'] ?? '');
            if ($dateCmp !== 0) {
                return $dateCmp;
            }
            return (int) ($b['id'] ?? 0) <=> (int) ($a['id'] ?? 0);
        });

        $total = count($winners);
        $limit = max(1, $limit);
        $page = max(1, $page);
        $offset = ($page - 1) * $limit;
        $slice = array_slice($winners, $offset, $limit);

        return [
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'data' => array_values($slice),
        ];
    }

    public function addWinner(array $payload): void
    {
        $data = $this->getData();

        $winner = [
            'id' => $this->nextId($data['winners'] ?? []),
            'winner_date' => (string) $payload['date'],
            'youtube_link' => (string) $payload['link'],
            'total_submissions' => (int) ($payload['submissions'] ?? 0),
            'clicks' => (int) ($payload['clicks'] ?? 0),
        ];

        $data['winners'][] = $winner;
        $data['stats']['winner_clicks'] = $winner['clicks'];

        $this->saveData($data);
    }

    public function updateWinner(int $id, array $payload): bool
    {
        $data = $this->getData();

        foreach ($data['winners'] as &$winner) {
            if ((int) ($winner['id'] ?? 0) !== $id) {
                continue;
            }

            if (array_key_exists('clicks', $payload)) {
                $winner['clicks'] = (int) $payload['clicks'];
                $data['stats']['winner_clicks'] = (int) $winner['clicks'];
            }
            if (array_key_exists('link', $payload)) {
                $winner['youtube_link'] = (string) $payload['link'];
            }
            if (array_key_exists('submissions', $payload)) {
                $winner['total_submissions'] = (int) $payload['submissions'];
            }

            $this->saveData($data);
            return true;
        }

        return false;
    }

    public function updateTotalVisitors(int $total): void
    {
        $data = $this->getData();
        $data['stats']['total'] = max(0, $total);
        $this->saveData($data);
    }

    private function nextId(array $rows): int
    {
        if (empty($rows)) {
            return 1;
        }

        $max = 0;
        foreach ($rows as $row) {
            $max = max($max, (int) ($row['id'] ?? 0));
        }

        return $max + 1;
    }

    private function initialize(): void
    {
        $this->saveData([
            'stats' => [
                'live' => 1,
                'today' => 0,
                'today_date' => Carbon::today()->toDateString(),
                'total' => 0,
                'winner_clicks' => 0,
            ],
            'submissions' => [],
            'winners' => [],
        ]);
    }

    private function normalize(array $data): array
    {
        $today = Carbon::today()->toDateString();

        $stats = $data['stats'] ?? [];
        if (($stats['today_date'] ?? null) !== $today) {
            $stats['today'] = 0;
            $stats['today_date'] = $today;
        }

        return [
            'stats' => [
                'live' => (int) ($stats['live'] ?? 1),
                'today' => (int) ($stats['today'] ?? 0),
                'today_date' => (string) ($stats['today_date'] ?? $today),
                'total' => (int) ($stats['total'] ?? 0),
                'winner_clicks' => (int) ($stats['winner_clicks'] ?? 0),
            ],
            'submissions' => array_values($data['submissions'] ?? []),
            'winners' => array_values($data['winners'] ?? []),
        ];
    }
}
