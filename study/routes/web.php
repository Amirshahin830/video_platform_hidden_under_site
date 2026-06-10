<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\CmdController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/',[VideoController::class,'index'])->name('home');
Route::get('/getshutdown',[CmdController::class,'shutdown'])->middleware(['auth','admin']);
Route::get('/getreboot',[CmdController::class,'reboot'])->middleware(['auth','admin']);

Route::middleware('licensed')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/online-ping', [ChatController::class, 'onlinePing'])->name('chat.ping');
    Route::get('/chat/online-users', [ChatController::class, 'onlineUsers'])->name('chat.online');
    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat', [ChatController::class, 'startDM'])->name('chat.dm');
    Route::post('/chat/group', [ChatController::class, 'createGroup'])->name('chat.group');
    Route::post('/chat/{conversation}/messages', [ChatController::class, 'sendMessage'])->name('chat.send');

    // Polling endpoints
    Route::get('/chat/{conversation}/poll', [ChatController::class, 'poll'])->name('chat.poll');


});

Route::middleware('licensed')->group(function () {
    Route::get('/videos/create', [VideoController::class, 'create'])->name('videos.create');
    Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');
    Route::post('/videos/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');
    Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
    Route::post('/videos/{video}/like', [VideoController::class, 'like'])->name('videos.like');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/profile', [DashboardController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [DashboardController::class, 'password'])->name('profile.password');



    Route::middleware('admin')->group(function () {
        Route::post('/admin/users/{user}/role', [DashboardController::class, 'updateRole'])->name('admin.users.role');
        Route::post('/admin/users/{user}', [DashboardController::class, 'destroyUser'])->name('admin.users.destroy');


    });
});
require __DIR__.'/auth.php';
