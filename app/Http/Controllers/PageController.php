<?php

namespace App\Http\Controllers;

use App\Models\UtyoubeSetting;
use App\Models\UtyoubeStatistic;
use App\Models\UtyoubeSubmission;
use App\Models\UtyoubeWinner;
use App\Support\UtyoubeDataStore;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private const UNLOCK_TTL_SECONDS = 600;

    public function __construct(private UtyoubeDataStore $store)
    {
    }

    public function index(Request $request)
    {
        $stats = UtyoubeStatistic::bumpVisit($request);

        return view('home', [
            'stats' => $stats,
            'winners' => UtyoubeWinner::todaysWinnersByChance(),
            'minViewSeconds' => UtyoubeSetting::getMinViewSeconds(),
            'fallbackWinnerLinks' => UtyoubeSetting::getFallbackWinnerLinks(),
        ]);
    }

    public function info()
    {
        return view('info');
    }

    public function secret()
    {
        return view('secret');
    }

    public function stats(): JsonResponse
    {
        $stats = UtyoubeStatistic::getStats();

        return response()->json([
            'live'  => (int) $stats['live'],
            'today' => (int) $stats['today'],
            'total' => (int) $stats['total'],
        ]);
    }

    public function winners(Request $request): JsonResponse
    {
        $page = (int) $request->query('p', 1);
        $limit = (int) $request->query('limit', 10);
        $q = trim((string) $request->query('q', ''));

        return response()->json(UtyoubeWinner::paginatedList($page, $limit, $q));
    }

    public function click(Request $request): JsonResponse
    {
        $request->validate([
            'chance' => ['required', 'integer', 'between:1,6'],
            'button_id' => ['nullable', 'string', 'max:50'],
            'winner_id' => ['nullable', 'integer', 'min:1'],
        ]);

        $chance = (int) $request->input('chance');
        $chanceState = $this->getChanceState($request);

        $winnerId = $request->input('winner_id') ? (int) $request->input('winner_id') : null;
        $clicks = UtyoubeWinner::incrementClicks($winnerId);
        $this->store->incrementWinnerClicks();

        $minViewSeconds = UtyoubeSetting::getMinViewSeconds();
        $token = bin2hex(random_bytes(20));
        $now = Carbon::now();

        $chanceState['unlocked'][$chance] = [
            'token' => $token,
            'available_at' => $now->copy()->addSeconds($minViewSeconds)->timestamp,
            'expires_at' => $now->copy()->addSeconds(self::UNLOCK_TTL_SECONDS)->timestamp,
        ];

        $this->putChanceState($request, $chanceState);

        return response()->json([
            'success' => true,
            'clicks' => $clicks,
            'chance' => $chance,
            'token' => $token,
            'available_at' => $chanceState['unlocked'][$chance]['available_at'],
            'min_view_seconds' => $minViewSeconds,
        ]);
    }

    public function winnerClick(Request $request): JsonResponse
    {
        $request->validate([
            'winner_id' => ['required', 'integer', 'min:1'],
        ]);

        $clicks = UtyoubeWinner::incrementClicks((int) $request->input('winner_id'));
        $this->store->incrementWinnerClicks();

        return response()->json([
            'success' => true,
            'clicks' => $clicks,
        ]);
    }

    public function submitLink(Request $request): JsonResponse
    {
        $request->validate([
            'link' => ['required', 'url', 'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+/i'],
            'chance' => ['required', 'integer', 'between:1,6'],
            'access_token' => ['required', 'string', 'size:40'],
        ]);

        $chance = (int) $request->input('chance');
        $chanceState = $this->getChanceState($request);

        $unlock = $chanceState['unlocked'][$chance] ?? null;
        if (!is_array($unlock) || ($unlock['token'] ?? null) !== $request->input('access_token')) {
            return response()->json([
                'success' => false,
                'error' => 'Click on Past Day Winner first to unlock this chance.',
            ], 422);
        }

        $nowTimestamp = Carbon::now()->timestamp;
        if ($nowTimestamp < (int) ($unlock['available_at'] ?? 0)) {
            $min = UtyoubeSetting::getMinViewSeconds();

            return response()->json([
                'success' => false,
                'error' => "Please spend at least {$min} seconds on the Past Day Winner video before submitting.",
            ], 422);
        }

        if ($nowTimestamp > (int) ($unlock['expires_at'] ?? 0)) {
            unset($chanceState['unlocked'][$chance]);
            $this->putChanceState($request, $chanceState);

            return response()->json([
                'success' => false,
                'error' => 'This unlocked chance has expired. Click on Past Day Winner again.',
            ], 422);
        }

        $this->store->addSubmission([
            'youtube_link' => $request->input('link'),
            'chance' => $chance,
            'submitted_on' => Carbon::today()->toDateString(),
        ]);

        $this->persistSubmissionToDatabase($request, $chance);

        unset($chanceState['unlocked'][$chance]);
        $this->putChanceState($request, $chanceState);

        return response()->json([
            'success' => true,
            'message' => 'Your YouTube link has been submitted successfully.',
        ]);
    }

    private function getChanceState(Request $request): array
    {
        $today = Carbon::today()->toDateString();
        $state = $request->session()->get('utyoube_chances', []);

        if (($state['date'] ?? null) !== $today) {
            $state = [
                'date' => $today,
                'used' => [],
                'unlocked' => [],
            ];
        }

        $state['used'] = is_array($state['used'] ?? null) ? $state['used'] : [];
        $state['unlocked'] = is_array($state['unlocked'] ?? null) ? $state['unlocked'] : [];

        return $state;
    }

    private function putChanceState(Request $request, array $state): void
    {
        $request->session()->put('utyoube_chances', $state);
    }

    private function persistSubmissionToDatabase(Request $request, int $chance): void
    {
        $now = Carbon::now();
        $submissionDate = Carbon::today()->toDateString();
        $sessionId = $request->hasSession() ? $request->session()->getId() : null;

        UtyoubeSubmission::query()->create([
            'submission_date' => $submissionDate,
            'session_id' => $sessionId,
            'chance_number' => $chance,
            'youtube_link' => (string) $request->input('link'),
            'access_token' => (string) $request->input('access_token'),
            'ip_address' => $request->ip(),
            'submitted_at' => $now,
        ]);
    }
}
