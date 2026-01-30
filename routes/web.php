<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogbookInsidenController;
use App\Http\Controllers\LogbookInsidenInfrastrukturController;
use App\Http\Controllers\IdentitasServerController;
use App\Http\Controllers\HakAksesServerController;
use App\Http\Controllers\CatatanSocController;

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
    // Get stats for Logbook Insiden Aplikasi
    $totalInsidenAplikasi = \App\Models\LogbookInsiden::count();
    $bulanIniAplikasi = \App\Models\LogbookInsiden::whereMonth('created_at', now()->month)->count();
    $downtimeAplikasi = \App\Models\LogbookInsiden::sum('downtime_menit');

    // Get stats for Logbook Insiden Infrastruktur
    $totalInsidenInfrastruktur = \App\Models\LogbookInsidenInfrastruktur::count();
    $bulanIniInfrastruktur = \App\Models\LogbookInsidenInfrastruktur::whereMonth('created_at', now()->month)->count();
    $downtimeInfrastruktur = \App\Models\LogbookInsidenInfrastruktur::sum('lama_downtime');

    return view('dashboard', compact(
        'totalInsidenAplikasi',
        'totalInsidenInfrastruktur',
        'bulanIniAplikasi',
        'bulanIniInfrastruktur',
        'downtimeAplikasi',
        'downtimeInfrastruktur'
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

    // CRUD Logbook Insiden Infrastruktur
    Route::resource('infrastruktur', LogbookInsidenInfrastrukturController::class)->except(['show']);

    // CRUD Identitas Server
    Route::resource('identitas-server', IdentitasServerController::class)->except(['show']);

    // CRUD Hak Akses Server
    Route::resource('hak-akses-server', HakAksesServerController::class)->except(['show']);

    // CRUD Catatan SOC
    Route::resource('catatan-soc', CatatanSocController::class)->except(['show']);
    Route::get('/catatan-soc/{catatanSoc}/print', [CatatanSocController::class, 'print'])->name('catatan-soc.print');
    Route::get('/catatan-soc/{catatanSoc}/download-pdf', [CatatanSocController::class, 'downloadPdf'])->name('catatan-soc.download-pdf');
});

require __DIR__.'/auth.php';