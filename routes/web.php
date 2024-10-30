<?php use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;


// Publieke routes voor iedereen
Route::get('/', [HomeController::class, 'index']);
Route::get('/catalog', [AnimalController::class, 'catalog'])->name('zoo.catalog');
Route::get('/zoo/{animal}', [AnimalController::class, 'show'])->name('zoo.show');



// Routes voor geregistreerde gebruikers voor CRUD
Route::middleware(['auth'])->group(function () {
Route::get('/zoo/create', [AnimalController::class, 'create'])->name('zoo.create');
Route::post('/zoo', [AnimalController::class, 'store'])->name('zoo.store');
Route::get('/zoo/{animal}/edit', [AnimalController::class, 'edit'])->name('zoo.edit');
Route::put('/zoo/{animal}', [AnimalController::class, 'update'])->name('zoo.update');
Route::delete('/zoo/{animal}', [AnimalController::class, 'destroy'])->name('zoo.destroy');
});

// Route voor het algemene dashboard (alleen ingelogde gebruikers)
Route::get('/dashboard', function () {
return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin-only routes (alleen voor ingelogde admin-gebruikers)
Route::middleware(['admin'])->group(function () {
Route::get('/admin/dashboard', function () {
return view('admindashboard');
})->name('admin.dashboard');
});

// Auth routes
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::post('/animals/{animal}/toggle-status', [AnimalController::class, 'toggleStatus'])->name('animals.toggleStatus');




// Geregistreerde gebruikers kunnen profiel bewerken
Route::middleware('auth')->group(function () {
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
