<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin/jobs', function () {
    return "Halaman Admin Jobs";
})->middleware(['auth', 'isAdmin']);

// Jobs: admin can manage except index/show, authenticated users can view index and show
Route::resource('jobs', JobController::class)
    ->middleware(['auth', 'isAdmin'])
    ->except(['index', 'show']);

Route::resource('jobs', JobController::class)
    ->middleware(['auth'])
    ->only(['index', 'show']);

Route::get('/admin', function () {
    return "Halo Admin!";
})->middleware(['auth', 'isAdmin']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])
    ->name('apply.store')
    ->middleware('auth');

// Export applications (admin only)
Route::get('/applications/export', [ApplicationController::class, 'export'])
    ->name('applications.export')
    ->middleware(['auth', 'isAdmin']);

Route::resource('applications', ApplicationController::class)
    ->middleware(['auth', 'isAdmin'])
    ->except(['index', 'show']);

Route::resource('applications', ApplicationController::class)
    ->middleware(['auth'])
    ->only(['index', 'show']);

// Import jobs (admin only)
Route::post('/jobs/import', [JobController::class, 'import'])
    ->name('jobs.import')
    ->middleware(['auth', 'isAdmin']);

// Download import template (admin only)
Route::get('/jobs/import-template', [JobController::class, 'downloadTemplate'])
    ->name('jobs.import.template')
    ->middleware(['auth', 'isAdmin']);
