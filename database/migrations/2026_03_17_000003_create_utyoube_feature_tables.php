<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('utyoube_chance_unlocks');
        Schema::dropIfExists('utyoube_statistics');
        Schema::dropIfExists('utyoube_submissions');
        Schema::dropIfExists('utyoube_winners');

        Schema::create('utyoube_winners', function (Blueprint $table) {
            $table->id();
            $table->date('winner_date')->index();
            $table->unsignedTinyInteger('chance_number')->default(1);
            $table->text('youtube_link');
            $table->unsignedInteger('total_submissions')->default(0);
            $table->unsignedBigInteger('clicks')->default(0);
            $table->timestamps();

            $table->unique(['winner_date', 'chance_number'], 'utyoube_winners_date_chance_unique');
        });

        Schema::create('utyoube_submissions', function (Blueprint $table) {
            $table->id();
            $table->date('submission_date')->index();
            $table->unsignedTinyInteger('chance_number');
            $table->text('youtube_link');
            $table->string('access_token', 64)->nullable()->index();
            $table->string('session_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->dateTime('unlocked_at')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->timestamps();

            $table->unique(
                ['submission_date', 'session_id', 'chance_number'],
                'utyoube_submissions_daily_session_chance_unique'
            );
        });

        Schema::create('utyoube_statistics', function (Blueprint $table) {
            $table->id();
            $table->date('stats_date')->unique();
            $table->unsignedInteger('live_visitors')->default(1);
            $table->unsignedInteger('today_visitors')->default(0);
            $table->unsignedBigInteger('total_visitors')->default(0);
            $table->unsignedBigInteger('winner_clicks')->default(0);
            $table->timestamps();
        });

        Schema::create('utyoube_chance_unlocks', function (Blueprint $table) {
            $table->id();
            $table->date('unlock_date')->index();
            $table->unsignedTinyInteger('chance_number');
            $table->string('access_token', 64)->unique();
            $table->string('session_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->dateTime('clicked_at');
            $table->dateTime('available_at');
            $table->dateTime('expires_at');
            $table->dateTime('used_at')->nullable();
            $table->timestamps();

            $table->unique(
                ['unlock_date', 'session_id', 'chance_number'],
                'utyoube_unlocks_daily_session_chance_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utyoube_chance_unlocks');
        Schema::dropIfExists('utyoube_statistics');
        Schema::dropIfExists('utyoube_submissions');
        Schema::dropIfExists('utyoube_winners');
    }
};