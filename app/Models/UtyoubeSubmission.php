<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtyoubeSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_date',
        'chance_number',
        'youtube_link',
        'access_token',
        'session_id',
        'ip_address',
        'unlocked_at',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'submission_date' => 'date',
            'unlocked_at' => 'datetime',
            'submitted_at' => 'datetime',
        ];
    }
}