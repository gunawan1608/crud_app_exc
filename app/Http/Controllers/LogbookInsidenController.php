<?php

namespace App\Http\Controllers;

use App\Models\LogbookInsiden;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LogbookImport;
use App\Exports\LogbookExport;

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
        $validated = $request->validate([
            'pelapor' => 'required|string|max:100',
            'metode_pelaporan' => 'required|string|max:50',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'keterangan_waktu_selesai' => 'nullable|string',
            'sla' => 'nullable|numeric|min:0|max:100', // SLA target (%)
            'keterangan_sla' => 'nullable|string',
            'aplikasi' => 'nullable|string|max:100',
            'ip_server' => 'nullable|ip',
            'tipe_insiden' => 'nullable|string|max:100',
            'keterangan' => 'required|string',
            'akar_penyebab' => 'nullable|string',
            'tindak_lanjut_detail' => 'nullable|string',
            'direspon_oleh' => 'required|string',
            'status_insiden' => 'required|in:Open,On Progress,Closed',
        ]);

        // =========================
        // HITUNG DOWNTIME
        // =========================
        $waktuMulai   = Carbon::parse($validated['waktu_mulai']);
        $waktuSelesai = Carbon::parse($validated['waktu_selesai']);

        $lamaDowntime = $waktuMulai->diffInMinutes($waktuSelesai);
        $konversiJam  = round($lamaDowntime / 60, 2);

        // =========================
        // HITUNG SLA TAHUNAN (AUTO)
        // =========================
        $totalMenitTahunan = 525600; // 365 hari
        $persentaseSlaTahunan = round(
            (($totalMenitTahunan - $lamaDowntime) / $totalMenitTahunan) * 100,
            2
        );

        // =========================
        // LOGIC IF ALA EXCEL
        // =========================
        $slaTarget = $validated['sla']; // misal 98

        $statusSla = $persentaseSlaTahunan >= $slaTarget
            ? 'SLA Tercapai'
            : 'SLA Tidak Tercapai';

        // =========================
        // SIMPAN DATA
        // =========================
        LogbookInsiden::create([
            'pelapor' => $validated['pelapor'],
            'metode_pelaporan' => $validated['metode_pelaporan'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'keterangan_waktu_selesai' => $validated['keterangan_waktu_selesai'],
            'downtime_menit' => $lamaDowntime,
            'konversi_ke_jam' => $konversiJam,

            'sla' => $slaTarget,
            'persentase_sla_tahunan' => $persentaseSlaTahunan,
            'status_sla' => $statusSla,

            'keterangan_sla' => $validated['keterangan_sla'],
            'aplikasi' => $validated['aplikasi'],
            'ip_server' => $validated['ip_server'],
            'tipe_insiden' => $validated['tipe_insiden'],
            'keterangan' => $validated['keterangan'],
            'akar_penyebab' => $validated['akar_penyebab'],
            'tindak_lanjut_detail' => $validated['tindak_lanjut_detail'],
            'direspon_oleh' => $validated['direspon_oleh'],
            'status_insiden' => $validated['status_insiden'],
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
        $validated = $request->validate([
            'pelapor' => 'required|string|max:100',
            'metode_pelaporan' => 'required|string|max:50',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'keterangan_waktu_selesai' => 'nullable|string',
            'sla' => 'nullable|numeric|min:0|max:100',
            'keterangan_sla' => 'nullable|string',
            'aplikasi' => 'nullable|string|max:100',
            'ip_server' => 'nullable|ip',
            'tipe_insiden' => 'nullable|string|max:100',
            'keterangan' => 'required|string',
            'akar_penyebab' => 'nullable|string',
            'tindak_lanjut_detail' => 'nullable|string',
            'direspon_oleh' => 'required|string',
            'status_insiden' => 'required|in:Open,On Progress,Closed',
        ]);

        // =========================
        // HITUNG DOWNTIME
        // =========================
        $waktuMulai   = Carbon::parse($validated['waktu_mulai']);
        $waktuSelesai = Carbon::parse($validated['waktu_selesai']);

        $lamaDowntime = $waktuMulai->diffInMinutes($waktuSelesai);
        $konversiJam  = round($lamaDowntime / 60, 2);

        // =========================
        // HITUNG SLA TAHUNAN
        // =========================
        $totalMenitTahunan = 525600;
        $persentaseSlaTahunan = round(
            (($totalMenitTahunan - $lamaDowntime) / $totalMenitTahunan) * 100,
            2
        );

        // =========================
        // LOGIKA STATUS SLA
        // =========================
        $slaTarget = $validated['sla'];

        $statusSla = $slaTarget !== null
            ? ($persentaseSlaTahunan >= $slaTarget
                ? 'SLA Tercapai'
                : 'SLA Tidak Tercapai')
            : null;

        // =========================
        // UPDATE DATA
        // =========================
        $logbook->update([
            'pelapor' => $validated['pelapor'],
            'metode_pelaporan' => $validated['metode_pelaporan'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'keterangan_waktu_selesai' => $validated['keterangan_waktu_selesai'],
            'downtime_menit' => $lamaDowntime,
            'konversi_ke_jam' => $konversiJam,

            'sla' => $slaTarget,
            'persentase_sla_tahunan' => $persentaseSlaTahunan,
            'status_sla' => $statusSla,

            'keterangan_sla' => $validated['keterangan_sla'],
            'aplikasi' => $validated['aplikasi'],
            'ip_server' => $validated['ip_server'],
            'tipe_insiden' => $validated['tipe_insiden'],
            'keterangan' => $validated['keterangan'],
            'akar_penyebab' => $validated['akar_penyebab'],
            'tindak_lanjut_detail' => $validated['tindak_lanjut_detail'],
            'direspon_oleh' => $validated['direspon_oleh'],
            'status_insiden' => $validated['status_insiden'],
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

    /**
     * Import data from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120', // Max 5MB
        ], [
            'file.required' => 'File Excel wajib dipilih',
            'file.mimes' => 'File harus berformat Excel (.xlsx, .xls, atau .csv)',
            'file.max' => 'Ukuran file maksimal 5MB',
        ]);

        try {
            Excel::import(new LogbookImport, $request->file('file'));

            return redirect()->route('logbook.index')
                ->with('success', 'Data berhasil diimport dari Excel');
        } catch (\Exception $e) {
            return redirect()->route('logbook.index')
                ->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Export data to Excel
     */
    public function export()
    {
        return Excel::download(new LogbookExport, 'logbook-insiden-' . date('Y-m-d') . '.xlsx');
    }
}
