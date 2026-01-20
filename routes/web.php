<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogbookInsidenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Import & Export - HARUS SEBELUM resource route
    Route::post('/logbook/import', [LogbookInsidenController::class, 'import'])->name('logbook.import');
    Route::get('/logbook/export', [LogbookInsidenController::class, 'export'])->name('logbook.export');

    // Route Logbook Insiden (CRUD)
    Route::resource('logbook', LogbookInsidenController::class)->except(['show']);
});

require __DIR__.'/auth.php';
