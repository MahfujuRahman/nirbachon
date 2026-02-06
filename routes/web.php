<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AshonController;
use App\Http\Controllers\Admin\CentarController;
use App\Http\Controllers\Admin\MarkaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ResultController as AdminResultController;
use App\Http\Controllers\Agent\DashboardController as AgentDashboardController;
use App\Http\Controllers\Agent\ResultController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Ashons
    Route::resource('ashons', AshonController::class);

    // Centars
    Route::get('centars/import', [CentarController::class, 'importForm'])->name('centars.import');
    Route::post('centars/import', [CentarController::class, 'import'])->name('centars.import.store');
    Route::resource('centars', CentarController::class);

    // Markas
    Route::resource('markas', MarkaController::class);

    // Users (Agents)
    Route::resource('users', UserController::class);

    // Results Management
    Route::get('results', [AdminResultController::class, 'index'])->name('results.index');
    Route::get('results/{result}', [AdminResultController::class, 'show'])->name('results.show');
    Route::delete('results/{result}', [AdminResultController::class, 'destroy'])->name('results.destroy');
});

// Agent routes
Route::middleware(['auth', 'agent'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', [AgentDashboardController::class, 'index'])->name('dashboard');

    // Results
    Route::get('results/create', [ResultController::class, 'create'])->name('results.create');
    Route::post('results', [ResultController::class, 'store'])->name('results.store');
    Route::get('results/{result}/edit', [ResultController::class, 'edit'])->name('results.edit');
    Route::put('results/{result}', [ResultController::class, 'update'])->name('results.update');
    Route::delete('result-images/{image}', [ResultController::class, 'deleteImage'])->name('result-images.destroy');

    // Other Images (without result_id)
    Route::get('other-images/create', [ResultController::class, 'createOtherImages'])->name('other-images.create');
    Route::post('other-images', [ResultController::class, 'storeOtherImages'])->name('other-images.store');
    Route::delete('other-images/{image}', [ResultController::class, 'deleteOtherImage'])->name('other-images.destroy');
});
