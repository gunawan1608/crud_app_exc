<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogbookInsidenController;
use App\Http\Controllers\LogbookInsidenInfrastrukturController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ROOT → LOGIN PAGE
Route::get('/', function () {
    return redirect('/login');
});

// LOGIN PAGE (GET)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// DASHBOARD
Route::get('/dashboard', function () {
    // Get stats for all logbook types
    $totalInsidenAplikasi = \App\Models\LogbookInsiden::count();
    $totalInsidenInfrastrukturBaru = \App\Models\LogbookInsidenInfrastruktur::count();

    $bulanIniAplikasi = \App\Models\LogbookInsiden::whereMonth('created_at', now()->month)->count();
    $bulanIniInfrastrukturBaru = \App\Models\LogbookInsidenInfrastruktur::whereMonth('created_at', now()->month)->count();

    $downtimeAplikasi = \App\Models\LogbookInsiden::sum('downtime_menit');
    $downtimeInfrastrukturBaru = \App\Models\LogbookInsidenInfrastruktur::sum('lama_downtime');

    return view('dashboard', compact(
        'totalInsidenAplikasi',
        'totalInsidenInfrastruktur',
        'totalInsidenInfrastrukturBaru',
        'bulanIniAplikasi',
        'bulanIniInfrastruktur',
        'bulanIniInfrastrukturBaru',
        'downtimeAplikasi',
        'downtimeInfrastruktur',
        'downtimeInfrastrukturBaru'
    ));
})->middleware('auth')->name('dashboard');

// PROTECTED ROUTES
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Import & Export Logbook Insiden
    Route::post('/logbook/import', [LogbookInsidenController::class, 'import'])->name('logbook.import');
    Route::get('/logbook/export', [LogbookInsidenController::class, 'export'])->name('logbook.export');

    // CRUD Logbook Insiden (Aplikasi)
    Route::resource('logbook', LogbookInsidenController::class)->except(['show']);

    // CRUD Logbook Insiden Infrastruktur (BARU - Sesuai Excel)
    Route::resource('logbook_infrastruktur', LogbookInsidenInfrastrukturController::class)->except(['show']);
});

require __DIR__.'/auth.php';
