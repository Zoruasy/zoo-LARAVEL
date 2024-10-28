<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Route voor de startpagina
Route::get('/', [HomeController::class, 'index']);

// Route voor de catalogus
Route::get('/catalog', [AnimalController::class, 'catalog'])->name('zoo.catalog');

// Route voor een specifiek dier
Route::get('/zoo/{animal}', [AnimalController::class, 'show'])->name('zoo.show');

// Routes voor het beheren van dieren
Route::middleware(['auth'])->group(function () {
    Route::get('/zoo/create', [AnimalController::class, 'create'])->name('zoo.create');
    Route::post('/zoo', [AnimalController::class, 'store'])->name('zoo.store');
    Route::get('/zoo/{animal}/edit', [AnimalController::class, 'edit'])->name('zoo.edit');
    Route::put('/zoo/{animal}', [AnimalController::class, 'update'])->name('zoo.update');
    Route::delete('/zoo/{animal}', [AnimalController::class, 'destroy'])->name('zoo.destroy');
});

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth routes
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


