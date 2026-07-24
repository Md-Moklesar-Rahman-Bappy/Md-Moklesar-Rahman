<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Frontend routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [HomeController::class, 'blog'])->name('home.blog');
Route::get('/blog/{slug}', [HomeController::class, 'showBlogPost'])->name('home.blog.show');
Route::get('/project/{slug}', [HomeController::class, 'showProject'])->name('home.project');
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('home.contact.submit');
Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('home.subscribe');

// Load admin routes
require __DIR__.'/admin.php';

// Load Breeze auth routes
require __DIR__.'/auth.php';

// Profile routes (Breeze default)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Redirect /dashboard to admin panel (Breeze compatibility)
    Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))->name('dashboard');
});
