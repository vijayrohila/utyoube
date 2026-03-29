<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UtyoubeSetting extends Model
{
    public const KEY_MIN_VIEW_SECONDS = 'min_view_seconds';

    public const DEFAULT_FALLBACK_YOUTUBE = 'https://www.youtube.com';

    protected $fillable = [
        'key',
        'value',
    ];

    protected static ?int $minViewSecondsCache = null;

    public static function getMinViewSeconds(): int
    {
        if (self::$minViewSecondsCache !== null) {
            return self::$minViewSecondsCache;
        }

        $raw = self::query()->where('key', self::KEY_MIN_VIEW_SECONDS)->value('value');
        $seconds = (int) $raw;
        if ($seconds < 1) {
            $seconds = 5;
        }

        self::$minViewSecondsCache = $seconds;

        return $seconds;
    }

    public static function setMinViewSeconds(int $seconds): void
    {
        self::updateOrCreate(
            ['key' => self::KEY_MIN_VIEW_SECONDS],
            ['value' => (string) $seconds]
        );

        self::$minViewSecondsCache = $seconds;
    }

    /**
     * @return array<int, string> chance 1..6 => URL when no winner row exists
     */
    public static function getFallbackWinnerLinks(): array
    {
        $out = [];
        foreach (range(1, 6) as $chance) {
            $key = 'fallback_winner_link_' . $chance;
            $raw = self::query()->where('key', $key)->value('value');
            $url = is_string($raw) && $raw !== '' ? trim($raw) : self::DEFAULT_FALLBACK_YOUTUBE;
            if (! filter_var($url, FILTER_VALIDATE_URL)) {
                $url = self::DEFAULT_FALLBACK_YOUTUBE;
            }
            $out[$chance] = $url;
        }

        return $out;
    }

    /**
     * @param  array<int, string>  $linksByChance  keys 1..6
     */
    public static function setFallbackWinnerLinks(array $linksByChance): void
    {
        foreach (range(1, 6) as $chance) {
            $url = $linksByChance[$chance] ?? self::DEFAULT_FALLBACK_YOUTUBE;
            self::updateOrCreate(
                ['key' => 'fallback_winner_link_' . $chance],
                ['value' => $url]
            );
        }
    }
}
