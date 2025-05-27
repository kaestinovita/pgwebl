<?php

use function Laravel\Prompts\table;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableController;
use App\Http\Controllers\Pointscontroller;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Polygonscontroller;
use App\Http\Controllers\Polylinescontroller;

Route::get('/', [PublicController::class, 'index'])->name ('home');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('points', Pointscontroller::class);
Route::resource('polylines', Polylinescontroller::class);
Route::resource('polygons', Polygonscontroller::class);

Route::get('/map', [Pointscontroller::class, 'index'])->middleware(['auth', 'verified'])->name('map');
Route::get('/table',[TableController::class, 'index'])->name('table');

require __DIR__.'/auth.php';
