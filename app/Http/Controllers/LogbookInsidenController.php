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

        // Hitung SLA tahunan untuk ditampilkan
        $slaTahunan = LogbookInsiden::hitungSlaTahunan();

        // Ambil target SLA terendah sebagai referensi atau gunakan default
        $targetSla = LogbookInsiden::min('target_sla') ?? 98.00;

        // Tentukan status SLA berdasarkan target
        $statusSla = LogbookInsiden::tentukanStatusSla($targetSla);

        return view('logbook.index', compact('logbooks', 'slaTahunan', 'targetSla', 'statusSla'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $slaTahunan = LogbookInsiden::hitungSlaTahunan();
        $targetSla = 98.00; // Default target

        return view('logbook.create', compact('slaTahunan', 'targetSla'));
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
            'keterangan_sla' => 'nullable|string',
            'aplikasi' => 'nullable|string|max:100',
            'ip_server' => 'nullable|ip',
            'tipe_insiden' => 'nullable|string|max:100',
            'keterangan' => 'required|string',
            'akar_penyebab' => 'nullable|string',
            'tindak_lanjut_detail' => 'nullable|string',
            'direspon_oleh' => 'required|string',
            'status_insiden' => 'required|in:Open,On Progress,Closed',
            'target_sla' => 'required|numeric|min:0|max:100', // SATU-SATUNYA INPUT SLA DARI USER
        ]);

        // =========================
        // HITUNG DOWNTIME (OTOMATIS)
        // =========================
        $waktuMulai = Carbon::parse($validated['waktu_mulai']);
        $waktuSelesai = Carbon::parse($validated['waktu_selesai']);
        $lamaDowntime = $waktuMulai->diffInMinutes($waktuSelesai);
        $konversiJam = round($lamaDowntime / 60, 2);

        // =========================
        // HITUNG SLA PER KEJADIAN (OTOMATIS)
        // Formula: SLA_per_kejadian = 100 - (downtime_jam / 8760 * 100)
        // =========================
        $jamTahunan = 8760;
        $slaPerKejadian = 100 - (($konversiJam / $jamTahunan) * 100);
        $slaPerKejadian = round($slaPerKejadian, 6);

        // =========================
        // HITUNG KONTRIBUSI SLA TAHUNAN (OTOMATIS)
        // Formula: 100 - SLA_per_kejadian
        // =========================
        $kontribusiSlaTahunan = 100 - $slaPerKejadian;
        $kontribusiSlaTahunan = round($kontribusiSlaTahunan, 6);

        // =========================
        // SIMPAN DATA
        // =========================
        $logbook = LogbookInsiden::create([
            'pelapor' => $validated['pelapor'],
            'metode_pelaporan' => $validated['metode_pelaporan'],
            'waktu_mulai' => $validated['waktu_mulai'],
            'waktu_selesai' => $validated['waktu_selesai'],
            'keterangan_waktu_selesai' => $validated['keterangan_waktu_selesai'],
            'downtime_menit' => $lamaDowntime,
            'konversi_ke_jam' => $konversiJam,
            'sla' => $slaPerKejadian, // AUTO-CALCULATED
            'persentase_sla_tahunan' => $kontribusiSlaTahunan, // AUTO-CALCULATED
            'target_sla' => $validated['target_sla'], // USER INPUT (satu-satunya)
            'status_sla' => null, // Akan diupdate di bawah
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

        // =========================
        // HITUNG STATUS SLA (OTOMATIS)
        // Bandingkan SLA Tahunan dengan Target SLA
        // =========================
        $statusSla = LogbookInsiden::tentukanStatusSla($validated['target_sla']);
        $logbook->update(['status_sla' => $statusSla]);

        return redirect()->route('logbook.index')
            ->with('success', 'Data insiden berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LogbookInsiden $logbook)
    {
        $slaTahunan = LogbookInsiden::hitungSlaTahunan();
        $targetSla = 98.00; // Default, akan diambil dari data logbook

        return view('logbook.edit', compact('logbook', 'slaTahunan', 'targetSla'));
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
            'keterangan_sla' => 'nullable|string',
            'aplikasi' => 'nullable|string|max:100',
            'ip_server' => 'nullable|ip',
            'tipe_insiden' => 'nullable|string|max:100',
            'keterangan' => 'required|string',
            'akar_penyebab' => 'nullable|string',
            'tindak_lanjut_detail' => 'nullable|string',
            'direspon_oleh' => 'required|string',
            'status_insiden' => 'required|in:Open,On Progress,Closed',
            'target_sla' => 'required|numeric|min:0|max:100', // SATU-SATUNYA INPUT SLA DARI USER
        ]);

        // =========================
        // HITUNG DOWNTIME (OTOMATIS)
        // =========================
        $waktuMulai = Carbon::parse($validated['waktu_mulai']);
        $waktuSelesai = Carbon::parse($validated['waktu_selesai']);
        $lamaDowntime = $waktuMulai->diffInMinutes($waktuSelesai);
        $konversiJam = round($lamaDowntime / 60, 2);

        // =========================
        // HITUNG SLA PER KEJADIAN (OTOMATIS)
        // Formula: SLA_per_kejadian = 100 - (downtime_jam / 8760 * 100)
        // =========================
        $jamTahunan = 8760;
        $slaPerKejadian = 100 - (($konversiJam / $jamTahunan) * 100);
        $slaPerKejadian = round($slaPerKejadian, 6);

        // =========================
        // HITUNG KONTRIBUSI SLA TAHUNAN (OTOMATIS)
        // Formula: 100 - SLA_per_kejadian
        // =========================
        $kontribusiSlaTahunan = 100 - $slaPerKejadian;
        $kontribusiSlaTahunan = round($kontribusiSlaTahunan, 6);

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
            'sla' => $slaPerKejadian, // AUTO-CALCULATED
            'persentase_sla_tahunan' => $kontribusiSlaTahunan, // AUTO-CALCULATED
            'target_sla' => $validated['target_sla'], // USER INPUT (satu-satunya)
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

        // =========================
        // HITUNG STATUS SLA (OTOMATIS)
        // Bandingkan SLA Tahunan dengan Target SLA
        // =========================
        $statusSla = LogbookInsiden::tentukanStatusSla($validated['target_sla']);
        $logbook->update(['status_sla' => $statusSla]);

        return redirect()->route('logbook.index')
            ->with('success', 'Data insiden berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LogbookInsiden $logbook)
    {
        $logbook->delete();

        // Recalculate status SLA setelah delete
        $targetSla = 98;
        $statusSla = LogbookInsiden::tentukanStatusSla($targetSla);

        return redirect()->route('logbook.index')
            ->with('success', 'Data insiden berhasil dihapus');
    }

    /**
     * Import data from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ], [
            'file.required' => 'File Excel wajib dipilih',
            'file.mimes' => 'File harus berformat Excel (.xlsx, .xls, atau .csv)',
            'file.max' => 'Ukuran file maksimal 5MB',
        ]);

        try {
            Excel::import(new LogbookImport, $request->file('file'));

            // Recalculate all SLA after import
            $this->recalculateAllSla();

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

    /**
     * Recalculate all SLA data
     */
    private function recalculateAllSla()
    {
        $logbooks = LogbookInsiden::all();

        foreach ($logbooks as $logbook) {
            $konversiJam = $logbook->konversi_ke_jam;
            $jamTahunan = 8760;

            // Hitung SLA per kejadian
            $slaPerKejadian = 100 - (($konversiJam / $jamTahunan) * 100);
            $slaPerKejadian = round($slaPerKejadian, 6);

            // Hitung kontribusi SLA tahunan
            $kontribusiSlaTahunan = 100 - $slaPerKejadian;
            $kontribusiSlaTahunan = round($kontribusiSlaTahunan, 6);

            $logbook->update([
                'sla' => $slaPerKejadian,
                'persentase_sla_tahunan' => $kontribusiSlaTahunan,
            ]);
        }

        // Update status SLA untuk semua data berdasarkan target minimum
        $targetSla = LogbookInsiden::min('target_sla') ?? 98.00;
        $statusSla = LogbookInsiden::tentukanStatusSla($targetSla);
        LogbookInsiden::query()->update(['status_sla' => $statusSla]);
    }
}
