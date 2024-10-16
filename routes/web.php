<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Animal;
use App\Http\Controllers\ZooController;
use App\Http\Controllers\HomeController;


// Route voor de zoo catalogus
Route::get('/catalog', [ZooController::class, 'catalogg']);
Route::get('/zoo/{id}', [ZooController::class, 'show'])->name('zoo.show');
Route::get('/', [HomeController::class, 'index']);

// resource zegt die waar die voor is. het is een shortcut om het op te schrijven

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
