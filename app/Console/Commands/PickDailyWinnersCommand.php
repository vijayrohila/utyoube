<?php

namespace App\Console\Commands;

use App\Models\UtyoubeSubmission;
use App\Models\UtyoubeWinner;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PickDailyWinnersCommand extends Command
{
    protected $signature = 'utyoube:pick-daily-winners
        {--source-date= : Submission date to read from (Y-m-d). Defaults to yesterday}
        {--winner-date= : Winner date to write to (Y-m-d). Defaults to today}
        {--dry-run : Show what would be selected without writing changes}';

    protected $description = 'Pick 1 random submission per chance (1-6) from past day; set total_links to pool size, total_submissions to 0; then delete source-day submissions.';

    public function handle(): int
    {
        $sourceDate = $this->resolveDateOption('source-date', Carbon::yesterday());
        $winnerDate = $this->resolveDateOption('winner-date', Carbon::today());
        $isDryRun = (bool) $this->option('dry-run');
        $startedAt = now();

        Log::info('Cron hit: utyoube:pick-daily-winners started', [
            'source_date' => $sourceDate?->toDateString(),
            'winner_date' => $winnerDate?->toDateString(),
            'dry_run' => $isDryRun,
            'started_at' => $startedAt->toDateTimeString(),
        ]);

        if (!$sourceDate || !$winnerDate) {
            Log::warning('Cron hit: utyoube:pick-daily-winners aborted due to invalid date options');
            return self::INVALID;
        }

        $this->info('Selecting random winners from submissions...');
        $this->line('Source date: ' . $sourceDate->toDateString());
        $this->line('Winner date: ' . $winnerDate->toDateString());
        $this->line('Dry run: ' . ($isDryRun ? 'yes' : 'no'));

        $created = 0;
        $skippedExisting = 0;
        $skippedNoSubmissions = 0;

        for ($chance = 1; $chance <= 6; $chance++) {
            $existingWinner = UtyoubeWinner::query()
                ->whereDate('winner_date', $winnerDate)
                ->where('chance_number', $chance)
                ->first();

            if ($existingWinner) {
                $skippedExisting++;
                $this->warn("Chance {$chance}: winner already exists for {$winnerDate->toDateString()}, skipping.");
                continue;
            }

            $query = UtyoubeSubmission::query()
                ->whereDate('submission_date', $sourceDate)
                ->where('chance_number', $chance);

            $totalForChance = (clone $query)->count();

            if ($totalForChance === 0) {
                $skippedNoSubmissions++;
                $this->warn("Chance {$chance}: no submissions found for {$sourceDate->toDateString()}.");
                continue;
            }

            $picked = (clone $query)->inRandomOrder()->first();

            if (!$picked) {
                $skippedNoSubmissions++;
                $this->warn("Chance {$chance}: unable to pick a random submission.");
                continue;
            }

            $this->line("Chance {$chance}: picked submission #{$picked->id} ({$picked->youtube_link}) from {$totalForChance} links.");

            if ($isDryRun) {
                $created++;
                continue;
            }

            DB::transaction(function () use ($chance, $winnerDate, $totalForChance, $picked): void {
                UtyoubeWinner::query()->create([
                    'winner_date' => $winnerDate->toDateString(),
                    'chance_number' => $chance,
                    'youtube_link' => (string) $picked->youtube_link,
                    'total_links' => $totalForChance,
                    'total_submissions' => 0,
                    'clicks' => 0,
                ]);

                UtyoubeSubmission::query()->whereKey($picked->id)->delete();
            });

            $created++;
        }

        $leftoverQuery = UtyoubeSubmission::query()->whereDate('submission_date', $sourceDate);
        $leftoverCount = (clone $leftoverQuery)->count();

        if ($isDryRun) {
            $this->line('Would delete leftover submissions for source date: ' . $leftoverCount);
        } else {
            $deletedLeftover = $leftoverQuery->delete();
            $this->line('Deleted leftover submissions for source date: ' . $deletedLeftover);
        }

        $this->newLine();
        $this->info('Done.');
        $this->line('Created winners: ' . $created);
        $this->line('Skipped (already exists): ' . $skippedExisting);
        $this->line('Skipped (no submissions): ' . $skippedNoSubmissions);

        Log::info('Cron hit: utyoube:pick-daily-winners completed', [
            'source_date' => $sourceDate->toDateString(),
            'winner_date' => $winnerDate->toDateString(),
            'dry_run' => $isDryRun,
            'created_winners' => $created,
            'skipped_existing' => $skippedExisting,
            'skipped_no_submissions' => $skippedNoSubmissions,
            'finished_at' => now()->toDateTimeString(),
        ]);

        return self::SUCCESS;
    }

    private function resolveDateOption(string $name, Carbon $default): ?Carbon
    {
        $raw = trim((string) $this->option($name));

        if ($raw === '') {
            return $default->copy()->startOfDay();
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $raw)->startOfDay();
        } catch (\Throwable) {
            $this->error("Invalid --{$name} value '{$raw}'. Expected format: Y-m-d.");
            return null;
        }
    }
}
