<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MotusController;
use App\Http\Controllers\ArchiveController;

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');


// LARAVEL BREEZE

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/good-logout', [AuthenticatedSessionController::class, 'destroy'])->name('game');


// app/routes/web.php

// ACCUEIL
Route::get('/', [HomeController::class, 'index'])->name('welcome');


// LE JEU
Route::get('/motus/daily', [MotusController::class, 'showDailyGame'])->name('motus.daily');

// les mots du mois
Route::get('/motus/archive', [MotusController::class, 'showArchives'])->name('archives');

// jouer au jeu par dates
Route::get('/motus/play/{date}', [MotusController::class, 'showGameByDate'])->name('motus.play.show');
Route::post('/motus/play/{date}/attempt', [MotusController::class, 'attemptGameByDate'])->name('motus.play.attempt');

// ACCOUNT
Route::get('/account', [AccountController::class, 'showAccount'])->name('account');
Route::post('/account/upload-avatar', [AccountController::class, 'uploadAvatar'])->name('account.upload-avatar');


// SOCIAL
Route::get('/social', [SocialController::class, 'index'])->name('social')->middleware('auth');
Route::get('/social/profile/{user_id}', [SocialController::class, 'showUserProfile'])->name('social.profile')->middleware('auth');

Route::post('/add-friend/{user}', [SocialController::class, 'addFriend'])->name('add.friend')->middleware('auth');
Route::post('/accept-friend-request/{senderId}', [SocialController::class, 'acceptFriendRequest'])->name('accept.friend.request')->middleware('auth');

Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
Route::post('/account/update', [AccountController::class, 'update'])->name('account.update');

Route::get('/account/profile', [AccountController::class, 'showAccount'])->name('account.profile');

require __DIR__.'/auth.php';
