<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/',[VideoController::class,'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/videos/create', [VideoController::class, 'create'])->name('videos.create');
    Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');
    Route::post('/videos/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/profile', [DashboardController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [DashboardController::class, 'password'])->name('profile.password');
    Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
    Route::post('/videos/{video}/like', [VideoController::class, 'like'])->name('videos.like');


    Route::middleware('admin')->group(function () {
        Route::post('/admin/users/{user}/role', [DashboardController::class, 'updateRole'])->name('admin.users.role');
        Route::post('/admin/users/{user}', [DashboardController::class, 'destroyUser'])->name('admin.users.destroy');


    });
});
require __DIR__.'/auth.php';
