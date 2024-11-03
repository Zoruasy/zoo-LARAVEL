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
    Route::put('/zoo/{animal}', [AnimalController::class, 'update'])->name('zoo.update');
    Route::delete('/zoo/{animal}', [AnimalController::class, 'destroy'])->name('zoo.destroy');
});

// Route for the general dashboard (only for logged-in users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'showAdminDashboard'])->name('admin.dashboard');


    // User management routes
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

// Auth routes
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Registered users can edit profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include the auth routes
require __DIR__.'/auth.php';
