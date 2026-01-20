<?php

namespace App\Http\Controllers;

use App\Models\LogbookInsiden;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LogbookInsidenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logbooks = LogbookInsiden::latest()->paginate(10);
        return view('logbook.index', compact('logbooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('logbook.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'pelapor' => 'required|string|max:100',
            'metode_pelaporan' => 'required|string|max:50',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'no_ticket' => 'nullable|string|max:50',
            'direspon_oleh' => 'required|string',
            'keterangan' => 'required|string',
        ], [
            'pelapor.required' => 'Nama pelapor wajib diisi',
            'metode_pelaporan.required' => 'Metode pelaporan wajib dipilih',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi',
            'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai',
            'direspon_oleh.required' => 'Penanggung jawab wajib diisi',
            'keterangan.required' => 'Keterangan insiden wajib diisi',
        ]);

        // Hitung downtime otomatis
        $waktuMulai = Carbon::parse($validated['waktu_mulai']);
        $waktuSelesai = Carbon::parse($validated['waktu_selesai']);
        $downtimeMenit = $waktuMulai->diffInMinutes($waktuSelesai);

        // Simpan ke database
        LogbookInsiden::create([
            'pelapor' => $validated['pelapor'],
            'metode_pelaporan' => $validated['metode_pelaporan'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'downtime_menit' => $downtimeMenit,
            'no_ticket' => $validated['no_ticket'],
            'direspon_oleh' => $validated['direspon_oleh'],
            'keterangan' => $validated['keterangan'],
        ]);

        return redirect()->route('logbook.index')
            ->with('success', 'Data insiden berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LogbookInsiden $logbook)
    {
        return view('logbook.edit', compact('logbook'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LogbookInsiden $logbook)
    {
        // Validasi input
        $validated = $request->validate([
            'pelapor' => 'required|string|max:100',
            'metode_pelaporan' => 'required|string|max:50',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'no_ticket' => 'nullable|string|max:50',
            'direspon_oleh' => 'required|string',
            'keterangan' => 'required|string',
        ], [
            'pelapor.required' => 'Nama pelapor wajib diisi',
            'metode_pelaporan.required' => 'Metode pelaporan wajib dipilih',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi',
            'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai',
            'direspon_oleh.required' => 'Penanggung jawab wajib diisi',
            'keterangan.required' => 'Keterangan insiden wajib diisi',
        ]);

        // Hitung ulang downtime
        $waktuMulai = Carbon::parse($validated['waktu_mulai']);
        $waktuSelesai = Carbon::parse($validated['waktu_selesai']);
        $downtimeMenit = $waktuMulai->diffInMinutes($waktuSelesai);

        // Update database
        $logbook->update([
            'pelapor' => $validated['pelapor'],
            'metode_pelaporan' => $validated['metode_pelaporan'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'downtime_menit' => $downtimeMenit,
            'no_ticket' => $validated['no_ticket'],
            'direspon_oleh' => $validated['direspon_oleh'],
            'keterangan' => $validated['keterangan'],
        ]);

        return redirect()->route('logbook.index')
            ->with('success', 'Data insiden berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LogbookInsiden $logbook)
    {
        $logbook->delete();

        return redirect()->route('logbook.index')
            ->with('success', 'Data insiden berhasil dihapus');
    }
}
