<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/info', [PageController::class, 'info'])->name('info');
Route::get('/secret', [PageController::class, 'secret'])->name('secret');

Route::get('/api/stats', [PageController::class, 'stats'])->name('api.stats');
Route::get('/api/winners', [PageController::class, 'winners'])->name('api.winners');
Route::post('/api/click', [PageController::class, 'click'])->name('api.click');
Route::post('/api/winner-click', [PageController::class, 'winnerClick'])->name('api.winner-click');
Route::post('/submit-link', [PageController::class, 'submitLink'])->name('submit.link');

Route::get('/home', function () {
    return redirect()->route('home');
})->name('legacy.home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
        Route::post('/login', [AdminController::class, 'login'])->name('login.post')->middleware('throttle:5,1');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/change-password', [AdminController::class, 'changePasswordForm'])->name('change-password');
        Route::post('/change-password', [AdminController::class, 'changePassword'])->name('change-password.post');
        Route::post('/ajax-update', [AdminController::class, 'ajaxUpdate'])->name('ajax-update');
        Route::get('/api/winners', [AdminController::class, 'winnersApi'])->name('api.winners');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    });
});

Route::prefix('utyoube')->group(function () {
    Route::get('/', [PageController::class, 'index']);
    Route::get('/info', [PageController::class, 'info']);
    Route::get('/secret', [PageController::class, 'secret']);

    Route::get('/api/stats', [PageController::class, 'stats']);
    Route::get('/api/winners', [PageController::class, 'winners']);
    Route::post('/api/click', [PageController::class, 'click']);
    Route::post('/api/winner-click', [PageController::class, 'winnerClick']);
    Route::post('/submit-link', [PageController::class, 'submitLink']);

    Route::prefix('admin')->group(function () {
        Route::middleware('guest')->group(function () {
            Route::get('/login', [AdminController::class, 'loginForm']);
            Route::post('/login', [AdminController::class, 'login']);
        });

        Route::middleware('auth')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard']);
            Route::get('/change-password', [AdminController::class, 'changePasswordForm']);
            Route::post('/change-password', [AdminController::class, 'changePassword']);
            Route::post('/ajax-update', [AdminController::class, 'ajaxUpdate']);
            Route::get('/api/winners', [AdminController::class, 'winnersApi']);
            Route::post('/logout', [AdminController::class, 'logout']);
        });
    });
});
