<?php

namespace App\Http\Controllers;

use App\Models\CatatanSoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CatatanSocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catatans = CatatanSoc::orderBy('hari_tanggal', 'desc')->paginate(10);

        // Statistics
        $totalCatatan = CatatanSoc::count();
        $totalInsiden = CatatanSoc::where('terjadi_insiden', 'ya')->count();
        $catatanBulanIni = CatatanSoc::whereMonth('created_at', now()->month)->count();

        return view('catatan-soc.index', compact(
            'catatans',
            'totalCatatan',
            'totalInsiden',
            'catatanBulanIni'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penanggungJawabOptions = CatatanSoc::getPenanggungJawabOptions();
        $pelaksanaOptions = CatatanSoc::getPelaksanaOptions();

        return view('catatan-soc.create', compact(
            'penanggungJawabOptions',
            'pelaksanaOptions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari_tanggal' => 'required|date',
            'waktu' => 'nullable|string|max:100',
            'penanggung_jawab' => 'required|string|max:255',
            'pelaksana' => 'required|array|min:1',
            'pelaksana.*' => 'string',
            'to_do_list' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'keterangan' => 'nullable|string',
            'terjadi_insiden' => 'required|in:ya,tidak',
            'keterangan_insiden' => 'nullable|string',
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('catatan-soc', $filename, 'public');
            $validated['gambar'] = $path;
        }

        CatatanSoc::create($validated);

        return redirect()->route('catatan-soc.index')
            ->with('success', 'Catatan SOC berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CatatanSoc $catatanSoc)
    {
        $penanggungJawabOptions = CatatanSoc::getPenanggungJawabOptions();
        $pelaksanaOptions = CatatanSoc::getPelaksanaOptions();

        return view('catatan-soc.edit', compact(
            'catatanSoc',
            'penanggungJawabOptions',
            'pelaksanaOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CatatanSoc $catatanSoc)
    {
        $validated = $request->validate([
            'hari_tanggal' => 'required|date',
            'waktu' => 'nullable|string|max:100',
            'penanggung_jawab' => 'required|string|max:255',
            'pelaksana' => 'required|array|min:1',
            'pelaksana.*' => 'string',
            'to_do_list' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'keterangan' => 'nullable|string',
            'terjadi_insiden' => 'required|in:ya,tidak',
            'keterangan_insiden' => 'nullable|string',
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($catatanSoc->gambar && Storage::disk('public')->exists($catatanSoc->gambar)) {
                Storage::disk('public')->delete($catatanSoc->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('catatan-soc', $filename, 'public');
            $validated['gambar'] = $path;
        }

        $catatanSoc->update($validated);

        return redirect()->route('catatan-soc.index')
            ->with('success', 'Catatan SOC berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CatatanSoc $catatanSoc)
    {
        // Delete associated image if exists
        if ($catatanSoc->gambar && Storage::disk('public')->exists($catatanSoc->gambar)) {
            Storage::disk('public')->delete($catatanSoc->gambar);
        }

        $catatanSoc->delete();

        return redirect()->route('catatan-soc.index')
            ->with('success', 'Catatan SOC berhasil dihapus');
    }

    /**
     * Generate PDF for single record
     */
    public function downloadPdf(CatatanSoc $catatanSoc)
    {
        $pdf = Pdf::loadView('catatan-soc.pdf', compact('catatanSoc'));
        
        $filename = 'catatan-soc-' . $catatanSoc->hari_tanggal->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Print view for single record
     */
    public function print(CatatanSoc $catatanSoc)
    {
        return view('catatan-soc.print', compact('catatanSoc'));
    }
}