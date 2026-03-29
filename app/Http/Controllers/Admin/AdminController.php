<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UtyoubeSetting;
use App\Models\UtyoubeStatistic;
use App\Models\UtyoubeWinner;
use App\Support\UtyoubeDataStore;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function __construct(private UtyoubeDataStore $store)
    {
    }

    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, false)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Invalid credentials.');
    }

    public function dashboard()
    {
        $stats = UtyoubeStatistic::getStats();

        return view('admin.dashboard', [
            'stats' => [
                'live'  => (int) $stats['live'],
                'today' => (int) $stats['today'],
                'total' => (int) $stats['total'],
            ],
            'minViewSeconds' => UtyoubeSetting::getMinViewSeconds(),
            'fallbackWinnerLinks' => UtyoubeSetting::getFallbackWinnerLinks(),
        ]);
    }

    public function changePasswordForm()
    {
        return view('admin.change_password');
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'new_password'     => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            ]);
        

            $request->user()->update([
                'password' => Hash::make($request->new_password),
            ]);

            // Invalidate the current session so the user must re-authenticate.
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('admin.login')
                ->with('success', 'Password changed successfully. Please log in again.');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return back()
                ->with('error', 'An error occurred while changing the password. Please try again.')
                ->withInput();
        }
    }

    public function winnersApi(Request $request): JsonResponse
    {
        $page  = (int) $request->query('p', 1);
        $limit = (int) $request->query('limit', 10);
        $q     = trim((string) $request->query('q', ''));

        return response()->json(UtyoubeWinner::paginatedList($page, $limit, $q));
    }

    public function ajaxUpdate(Request $request): JsonResponse
    {
        try {
            $action = (string) $request->input('action', '');

            // ── Update total visitors count in stats table ──────────────
            if ($action === 'update_total_visitors') {
                $request->validate(['total' => ['required', 'integer', 'min:0']]);
                UtyoubeStatistic::whereDate('stats_date', today())
                    ->update(['total_visitors' => (int) $request->input('total')]);
                return response()->json(['success' => true]);
            }

            if ($action === 'update_min_view_seconds') {
                $request->validate([
                    'seconds' => ['required', 'integer', 'min:1', 'max:3600'],
                ]);
                UtyoubeSetting::setMinViewSeconds((int) $request->input('seconds'));

                return response()->json([
                    'success' => true,
                    'seconds' => UtyoubeSetting::getMinViewSeconds(),
                ]);
            }

            if ($action === 'update_fallback_winner_links') {
                $rules = [];
                foreach (range(1, 6) as $c) {
                    $rules['fallback_link_' . $c] = ['required', 'string', 'url', 'max:2000'];
                }
                $validated = $request->validate($rules);
                $byChance = [];
                foreach (range(1, 6) as $c) {
                    $byChance[$c] = (string) $validated['fallback_link_' . $c];
                }
                UtyoubeSetting::setFallbackWinnerLinks($byChance);

                return response()->json([
                    'success' => true,
                    'links' => UtyoubeSetting::getFallbackWinnerLinks(),
                ]);
            }

            // ── Update an existing winner row ───────────────────────────
            if ($action === 'update_winner') {
                $request->validate([
                    'id'            => ['required', 'integer', 'min:1'],
                    'clicks'        => ['nullable', 'integer', 'min:0'],
                    'submissions'   => ['nullable', 'integer', 'min:0'],
                    'total_links'   => ['nullable', 'integer', 'min:0'],
                    'link'          => ['nullable', 'url', 'max:500'],
                    'chance_number' => ['nullable', 'integer', 'between:1,6'],
                    'winner_date'   => ['nullable', 'date'],
                ]);

                $winner = UtyoubeWinner::find((int) $request->input('id'));
                if (!$winner) {
                    return response()->json(['success' => false, 'message' => 'Winner not found.'], 404);
                }

                $payload = [];
                if ($request->filled('clicks'))        $payload['clicks']            = (int)    $request->input('clicks');
                if ($request->filled('submissions'))   $payload['total_submissions'] = (int)    $request->input('submissions');
                if ($request->filled('total_links'))   $payload['total_links']       = (int)    $request->input('total_links');
                if ($request->filled('link'))          $payload['youtube_link']      = (string) $request->input('link');
                if ($request->filled('chance_number')) $payload['chance_number']     = (int)    $request->input('chance_number');
                if ($request->filled('winner_date'))   $payload['winner_date']       = $request->input('winner_date');

                $winner->update($payload);

                return response()->json(['success' => true]);
            }
            
            // ── Add a new winner (or update if same date + chance exists) ─────────────
            if ($request->filled('date') && $request->filled('link')) {
                $request->validate([
                    'date'          => ['required', 'date'],
                    'chance_number' => ['required', 'integer', 'between:1,6'],
                    'link'          => ['required', 'url', 'max:500'],
                    'total_links'   => ['required', 'integer', 'min:0'],
                    'submissions'   => ['required', 'integer', 'min:0'],
                    'clicks'        => ['required', 'integer', 'min:0'],
                ]);

                UtyoubeWinner::updateOrCreate(
                    [
                        'winner_date'   => $request->input('date'),
                        'chance_number' => (int) $request->input('chance_number'),
                    ],
                    [
                        'youtube_link'      => $request->input('link'),
                        'total_links'       => (int) $request->input('total_links'),
                        'total_submissions' => (int) $request->input('submissions'),
                        'clicks'            => (int) $request->input('clicks'),
                    ]
                );

                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false, 'message' => 'Invalid action or payload.'], 422);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->serverErrorResponse();
        }
    }

    private function validationErrorResponse(ValidationException $exception): JsonResponse
    {
        $errors = $exception->errors();
        $firstError = Arr::first(Arr::flatten($errors)) ?? 'Validation failed.';

        return response()->json([
            'success' => false,
            'message' => $firstError,
            'errors' => $errors,
        ], 422);
    }

    private function serverErrorResponse(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while processing the request.',
        ], 500);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
