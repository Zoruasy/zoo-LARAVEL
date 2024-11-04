<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public routes for everyone
Route::get('/', [HomeController::class, 'index']);
Route::get('/catalog', [AnimalController::class, 'catalog'])->name('zoo.catalog');
Route::get('/zoo/{animal}', [AnimalController::class, 'show'])->name('zoo.show');
Route::post('/animals/{id}/toggle-status', [AnimalController::class, 'toggleStatus'])->name('animals.toggleStatus');

// Routes for registered users for CRUD
Route::middleware(['auth'])->group(function () {
    Route::get('/zoo/create', [AnimalController::class, 'create'])->name('zoo.create');
    Route::post('/zoo', [AnimalController::class, 'store'])->name('zoo.store');
    Route::get('/zoo/{animal}/edit', [AnimalController::class, 'edit'])->name('zoo.edit');
    Route::put('/zoo/{animal}', [AnimalController::class, 'update'])->name('zoo.update'); // Use PUT here
    Route::delete('/zoo/{animal}', [AnimalController::class, 'destroy'])->name('zoo.destroy');

    // Route for the general dashboard (only for logged-in users)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Admin routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard'); // Admin dashboard
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index'); // List users
        Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit'); // Edit user
        Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update'); // Update user
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy'); // Delete user
    });
});

// Auth routes
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Registered users can edit profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Use PUT here
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include the auth routes
require __DIR__.'/auth.php';
