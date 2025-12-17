<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConfessionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController; 


// 1. Halaman Publik (Landing, About, Safety, term, privacy)
Route::get('/', [PageController::class, 'index'])->name('landing');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/safety', [PageController::class, 'safety'])->name('safety');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

// 2. Akses Publik: Orang Lain Mengirim Pesan (Confess)
// Link: dukasaha.com/u/username
Route::get('/u/{username}', [ConfessionController::class, 'create'])->name('confess.create');
Route::post('/confess', [ConfessionController::class, 'store'])->name('confess.store');

// 3. Akses Guest (Sender): Masuk ke Chat Room pakai Token
// Link: dukasaha.com/reply/token-rahasia
Route::get('/reply/{token}', [ChatController::class, 'guestAccess'])->name('chat.guest');
// Guest kirim balasan chat
Route::post('/chat/guest/{token}', [ChatController::class, 'guestReply'])->name('chat.guest.reply');

Route::get('/confessions/{id}', [ConfessionController::class, 'show'])->name('confessions.show');

// 4. Area User (Harus Login)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard (Halaman Home User lihat link)
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');

    // Inbox (Lihat daftar pesan)
    Route::get('/messages', [ConfessionController::class, 'index'])->name('messages.index');

    // Chat Room (User membalas pesan)
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{id}', [ChatController::class, 'store'])->name('chat.reply'); // User reply

    // Settings Profile
    Route::get('/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings', [ProfileController::class, 'destroy'])->name('profile.destroy');

});



// --- AUTH ROUTES---

// 1. Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// 2. Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// 3. Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Lupa Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Reset Password (Link dari email mengarah kesini)
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');