<?php

namespace App\Http\Controllers;

use App\Models\LogbookInsidenInfrastruktur;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LogbookInsidenInfrastrukturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logbooks = LogbookInsidenInfrastruktur::latest()->paginate(10);

        // Hitung SLA tahunan global
        $slaTahunan = LogbookInsidenInfrastruktur::hitungSlaTahunanGlobal();

        // Target SLA global (default 98%)
        $targetSla = 98.00;

        // Status SLA
        $statusSla = $slaTahunan >= $targetSla ? 'TERCAPAI' : 'TIDAK TERCAPAI';

        return view('infrastruktur.index', compact(
            'logbooks',
            'slaTahunan',
            'targetSla',
            'statusSla'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $slaTahunan = LogbookInsidenInfrastruktur::hitungSlaTahunanGlobal();
        $targetSla = 98.00;

        // Get options from model
        $lokasiOptions = LogbookInsidenInfrastruktur::getLokasiOptions();
        $responderOptions = LogbookInsidenInfrastruktur::getResponderOptions();
        $tipeInsidenOptions = LogbookInsidenInfrastruktur::getTipeInsidenOptions();

        return view('infrastruktur.create', compact(
            'slaTahunan',
            'targetSla',
            'lokasiOptions',
            'responderOptions',
            'tipeInsidenOptions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // User Input Only
            'pelapor' => 'required|string|max:255',
            'metode_pelaporan' => 'required|string|max:100',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'keterangan_sla' => 'nullable|string',
            'lokasi' => 'required|string|max:255',
            'insiden' => 'required|string|max:255',
            'tipe_insiden' => 'nullable|string|max:100',
            'keterangan' => 'required|string',
            'akar_penyebab' => 'nullable|string',
            'tindak_lanjut_detail' => 'nullable|string',
            'no_ticket' => 'nullable|string|max:100',
            'direspon_oleh' => 'required|array|min:1',
            'direspon_oleh.*' => 'string',
        ]);

        // =========================
        // 6. HITUNG LAMA DOWNTIME (OTOMATIS)
        // =========================
        $waktuMulai = Carbon::parse($validated['waktu_mulai']);
        $waktuSelesai = Carbon::parse($validated['waktu_selesai']);
        $lamaDowntime = $waktuMulai->diffInMinutes($waktuSelesai);

        // =========================
        // 7. HITUNG KONVERSI KE JAM (OTOMATIS)
        // =========================
        $konversiKeJam = round($lamaDowntime / 60, 2);

        // =========================
        // 8. HITUNG SLA PER KEJADIAN (OTOMATIS)
        // Formula: SLA_per_kejadian = 100 - ((konversi_ke_jam / 8760) * 100)
        // =========================
        $jamTahunan = 8760;
        $sla = 100 - (($konversiKeJam / $jamTahunan) * 100);
        $sla = round($sla, 6);

        // =========================
        // 9. HITUNG % SLA TAHUNAN (OTOMATIS)
        // Formula: persentase_sla_tahunan = 100 - SLA_per_kejadian
        // =========================
        $persentaseSlaTahunan = 100 - $sla;
        $persentaseSlaTahunan = round($persentaseSlaTahunan, 6);

        // =========================
        // SIMPAN DATA
        // =========================
        LogbookInsidenInfrastruktur::create([
            // 2-3. Informasi Pelapor (USER INPUT)
            'pelapor' => $validated['pelapor'],
            'metode_pelaporan' => $validated['metode_pelaporan'],

            // 4-5. Waktu (USER INPUT)
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],

            // 6-9. OTOMATIS
            'lama_downtime' => $lamaDowntime,
            'konversi_ke_jam' => $konversiKeJam,
            'sla' => $sla,
            'persentase_sla_tahunan' => $persentaseSlaTahunan,

            // 10. Keterangan SLA
            'keterangan_sla' => $validated['keterangan_sla'],

            // 11-18. Detail Insiden (USER INPUT)
            'lokasi' => $validated['lokasi'],
            'insiden' => $validated['insiden'],
            'tipe_insiden' => $validated['tipe_insiden'],
            'keterangan' => $validated['keterangan'],
            'akar_penyebab' => $validated['akar_penyebab'],
            'tindak_lanjut_detail' => $validated['tindak_lanjut_detail'],
            'no_ticket' => $validated['no_ticket'],
            'direspon_oleh' => $validated['direspon_oleh'],
        ]);

        return redirect()->route('infrastruktur.index')
            ->with('success', 'Data insiden infrastruktur berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LogbookInsidenInfrastruktur $infrastruktur)
    {
        $slaTahunan = LogbookInsidenInfrastruktur::hitungSlaTahunanGlobal();
        $targetSla = 98.00;

        $lokasiOptions = LogbookInsidenInfrastruktur::getLokasiOptions();
        $responderOptions = LogbookInsidenInfrastruktur::getResponderOptions();
        $tipeInsidenOptions = LogbookInsidenInfrastruktur::getTipeInsidenOptions();

        return view('infrastruktur.edit', compact(
            'infrastruktur',
            'slaTahunan',
            'targetSla',
            'lokasiOptions',
            'responderOptions',
            'tipeInsidenOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LogbookInsidenInfrastruktur $infrastruktur)
    {
        $validated = $request->validate([
            'pelapor' => 'required|string|max:255',
            'metode_pelaporan' => 'required|string|max:100',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'keterangan_sla' => 'nullable|string',
            'lokasi' => 'required|string|max:255',
            'insiden' => 'required|string|max:255',
            'tipe_insiden' => 'nullable|string|max:100',
            'keterangan' => 'required|string',
            'akar_penyebab' => 'nullable|string',
            'tindak_lanjut_detail' => 'nullable|string',
            'no_ticket' => 'nullable|string|max:100',
            'direspon_oleh' => 'required|array|min:1',
            'direspon_oleh.*' => 'string',
        ]);

        // =========================
        // HITUNG ULANG SEMUA NILAI OTOMATIS
        // =========================
        $waktuMulai = Carbon::parse($validated['waktu_mulai']);
        $waktuSelesai = Carbon::parse($validated['waktu_selesai']);
        $lamaDowntime = $waktuMulai->diffInMinutes($waktuSelesai);
        $konversiKeJam = round($lamaDowntime / 60, 2);
        $jamTahunan = 8760;
        $sla = 100 - (($konversiKeJam / $jamTahunan) * 100);
        $sla = round($sla, 6);
        $persentaseSlaTahunan = 100 - $sla;
        $persentaseSlaTahunan = round($persentaseSlaTahunan, 6);

        // =========================
        // UPDATE DATA
        // =========================
        $infrastruktur->update([
            'pelapor' => $validated['pelapor'],
            'metode_pelaporan' => $validated['metode_pelaporan'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'lama_downtime' => $lamaDowntime,
            'konversi_ke_jam' => $konversiKeJam,
            'sla' => $sla,
            'persentase_sla_tahunan' => $persentaseSlaTahunan,
            'keterangan_sla' => $validated['keterangan_sla'],
            'lokasi' => $validated['lokasi'],
            'insiden' => $validated['insiden'],
            'tipe_insiden' => $validated['tipe_insiden'],
            'keterangan' => $validated['keterangan'],
            'akar_penyebab' => $validated['akar_penyebab'],
            'tindak_lanjut_detail' => $validated['tindak_lanjut_detail'],
            'no_ticket' => $validated['no_ticket'],
            'direspon_oleh' => $validated['direspon_oleh'],
        ]);

        return redirect()->route('infrastruktur.index')
            ->with('success', 'Data insiden infrastruktur berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LogbookInsidenInfrastruktur $infrastruktur)
    {
        $infrastruktur->delete();

        return redirect()->route('infrastruktur.index')
            ->with('success', 'Data insiden infrastruktur berhasil dihapus');
    }
}
