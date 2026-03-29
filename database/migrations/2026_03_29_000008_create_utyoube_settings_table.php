<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('utyoube_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value', 255);
            $table->timestamps();
        });

        DB::table('utyoube_settings')->insert([
            'key' => 'min_view_seconds',
            'value' => '5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('utyoube_settings');
    }
};
