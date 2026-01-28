<?php

namespace App\Http\Controllers;

use App\Models\LogInsidenInfrastruktur;
use App\Http\Requests\LogInfrastrukturRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LogInfrastrukturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = LogInsidenInfrastruktur::latest()->paginate(10);

        // Hitung SLA tahunan
        $slaTahunan = LogInsidenInfrastruktur::hitungSlaTahunan();

        // Ambil target SLA terendah atau default
        $targetSla = LogInsidenInfrastruktur::min('target_sla') ?? 98.00;

        // Tentukan status SLA
        $statusSla = LogInsidenInfrastruktur::tentukanStatusSla(
            $slaTahunan,
            $targetSla
        );

        return view('infrastruktur.index', compact(
            'logs',
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
        $slaTahunan = LogInsidenInfrastruktur::hitungSlaTahunan();
        $targetSla = 98.00; // Default target

        // Get options from model
        $lokasiOptions = LogInsidenInfrastruktur::getLokasiOptions();
        $responderOptions = LogInsidenInfrastruktur::getResponderOptions();
        $tipeInsidenOptions = LogInsidenInfrastruktur::getTipeInsidenOptions();

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
    public function store(LogInfrastrukturRequest $request)
    {
        $validated = $request->validated();

        // =========================
        // HITUNG DOWNTIME (OTOMATIS)
        // =========================
        $waktuMulai = Carbon::parse($validated['waktu_mulai']);
        $waktuSelesai = Carbon::parse($validated['waktu_selesai']);
        $lamaDowntime = $waktuMulai->diffInMinutes($waktuSelesai);
        $downtimeJam = round($lamaDowntime / 60, 2);

        // =========================
        // HITUNG SLA PER KEJADIAN (OTOMATIS)
        // Formula: SLA_persen = 100 - (downtime_jam / 24 * 100)
        // =========================
        $jamPerHari = 24;
        $slaPersen = 100 - (($downtimeJam / $jamPerHari) * 100);
        $slaPersen = round($slaPersen, 6);

        // =========================
        // HITUNG KONTRIBUSI SLA TAHUNAN (OTOMATIS)
        // Formula: 100 - SLA_persen
        // =========================
        $slaTahunan = 100 - $slaPersen;
        $slaTahunan = round($slaTahunan, 6);

        // =========================
        // SIMPAN DATA
        // =========================
        $log = LogInsidenInfrastruktur::create([
            'lokasi' => $validated['lokasi'],
            'insiden' => $validated['insiden'],
            'tipe_insiden' => $validated['tipe_insiden'],
            'keterangan' => $validated['keterangan'],
            'akar_penyebab' => $validated['akar_penyebab'],
            'tindak_lanjut' => $validated['tindak_lanjut'],
            'no_ticket' => $validated['no_ticket'],
            'direspon_oleh' => $validated['direspon_oleh'], // Will be cast to JSON automatically
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'lama_downtime' => $lamaDowntime,
            'downtime_jam' => $downtimeJam,
            'sla_persen' => $slaPersen, // AUTO-CALCULATED
            'sla_tahunan' => $slaTahunan, // AUTO-CALCULATED
            'target_sla' => $validated['target_sla'], // USER INPUT
            'status_sla' => null, // Akan diupdate di bawah
        ]);

        // =========================
        // HITUNG STATUS SLA (OTOMATIS)
        // Bandingkan SLA Tahunan dengan Target SLA
        // =========================
        $statusSla = LogInsidenInfrastruktur::tentukanStatusSla(
            $slaTahunan,
            $validated['target_sla']
        );

        $log->update(['status_sla' => $statusSla]);

        return redirect()->route('infrastruktur.index')
            ->with('success', 'Data insiden infrastruktur berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(LogInsidenInfrastruktur $infrastruktur)
    {
        return view('infrastruktur.show', compact('infrastruktur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LogInsidenInfrastruktur $infrastruktur)
    {
        $slaTahunan = LogInsidenInfrastruktur::hitungSlaTahunan();
        $targetSla = 98.00;

        // Get options from model
        $lokasiOptions = LogInsidenInfrastruktur::getLokasiOptions();
        $responderOptions = LogInsidenInfrastruktur::getResponderOptions();
        $tipeInsidenOptions = LogInsidenInfrastruktur::getTipeInsidenOptions();

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
    public function update(LogInfrastrukturRequest $request, LogInsidenInfrastruktur $infrastruktur)
    {
        $validated = $request->validated();

        // =========================
        // HITUNG DOWNTIME (OTOMATIS)
        // =========================
        $waktuMulai = Carbon::parse($validated['waktu_mulai']);
        $waktuSelesai = Carbon::parse($validated['waktu_selesai']);
        $lamaDowntime = $waktuMulai->diffInMinutes($waktuSelesai);
        $downtimeJam = round($lamaDowntime / 60, 2);

        // =========================
        // HITUNG SLA PER KEJADIAN (OTOMATIS)
        // Formula: SLA_persen = 100 - (downtime_jam / 24 * 100)
        // =========================
        $jamPerHari = 24;
        $slaPersen = 100 - (($downtimeJam / $jamPerHari) * 100);
        $slaPersen = round($slaPersen, 6);

        // =========================
        // HITUNG KONTRIBUSI SLA TAHUNAN (OTOMATIS)
        // Formula: 100 - SLA_persen
        // =========================
        $slaTahunan = 100 - $slaPersen;
        $slaTahunan = round($slaTahunan, 6);

        // =========================
        // UPDATE DATA
        // =========================
        $infrastruktur->update([
            'lokasi' => $validated['lokasi'],
            'insiden' => $validated['insiden'],
            'tipe_insiden' => $validated['tipe_insiden'],
            'keterangan' => $validated['keterangan'],
            'akar_penyebab' => $validated['akar_penyebab'],
            'tindak_lanjut' => $validated['tindak_lanjut'],
            'no_ticket' => $validated['no_ticket'],
            'direspon_oleh' => $validated['direspon_oleh'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'lama_downtime' => $lamaDowntime,
            'downtime_jam' => $downtimeJam,
            'sla_persen' => $slaPersen,
            'sla_tahunan' => $slaTahunan,
            'target_sla' => $validated['target_sla'],
        ]);

        // =========================
        // HITUNG STATUS SLA (OTOMATIS)
        // =========================
        $statusSla = LogInsidenInfrastruktur::tentukanStatusSla(
            $slaTahunan,
            $validated['target_sla']
        );

        $infrastruktur->update(['status_sla' => $statusSla]);

        return redirect()->route('infrastruktur.index')
            ->with('success', 'Data insiden infrastruktur berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LogInsidenInfrastruktur $infrastruktur)
    {
        $infrastruktur->delete();

        return redirect()->route('infrastruktur.index')
            ->with('success', 'Data insiden infrastruktur berhasil dihapus');
    }
}
