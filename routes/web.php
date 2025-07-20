<?php

use App\Http\Controllers\ObatalkesController;
use App\Http\Controllers\ResepController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'resep', 'middleware' => ['auth', 'verified']], function () {
    route::get('/', [ResepController::class, 'index'])->name('resep.index');
    route::post('/', [ResepController::class, 'store'])->name('resep.store');
    route::get('/{id}', [ResepController::class, 'show'])->name('resep.show');
    route::get('/{id}/print', [ResepController::class, 'print'])->name('resep.print');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
