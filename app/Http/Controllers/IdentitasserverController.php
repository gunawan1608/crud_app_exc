<?php

namespace App\Http\Controllers;

use App\Models\IdentitasServer;
use Illuminate\Http\Request;

class IdentitasServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servers = IdentitasServer::orderBy('no', 'asc')->paginate(10);

        // Statistics
        $totalServers = IdentitasServer::count();
        $activeServers = IdentitasServer::where('status', 'Aktif')->count();
        $productionServers = IdentitasServer::where('lingkungan_server', 'Production')->count();

        return view('identitas-server.index', compact(
            'servers',
            'totalServers',
            'activeServers',
            'productionServers'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get next no
        $nextNo = IdentitasServer::max('no') + 1;

        $lingkunganOptions = IdentitasServer::getLingkunganOptions();
        $avOptions = IdentitasServer::getAvBitdefenderOptions();
        $statusOptions = IdentitasServer::getStatusOptions();

        return view('identitas-server.create', compact(
            'nextNo',
            'lingkunganOptions',
            'avOptions',
            'statusOptions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // 2-5. SERVER INFO
            'no' => 'required|integer|min:1|unique:identitas_server,no',
            'ip_host_server' => 'required|ip',
            'nama_server' => 'required|string|max:255',
            'lingkungan_server' => 'required|in:Development,Staging,Production',

            // 6-7. IP SERVER
            'ip_local' => 'nullable|ip',
            'ip_public' => 'nullable|ip',

            // 8-11. SYSTEM SPECS
            'os' => 'nullable|string|max:100',
            'ram_gb' => 'nullable|integer|min:1',
            'virtual_socket' => 'nullable|integer|min:1',
            'core_per_socket' => 'nullable|integer|min:1',

            // 12-17. STORAGE & SOFTWARE
            'harddisk_gb' => 'nullable|integer|min:1',
            'versi_php' => 'nullable|string|max:50',
            'av_bitdefender' => 'nullable|in:Ada,Tidak Ada,TIDAK ADA',
            'administrator' => 'nullable|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'keterangan' => 'nullable|string',
        ]);

        IdentitasServer::create($validated);

        return redirect()->route('identitas-server.index')
            ->with('success', 'Data server berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IdentitasServer $identitasServer)
    {
        $lingkunganOptions = IdentitasServer::getLingkunganOptions();
        $avOptions = IdentitasServer::getAvBitdefenderOptions();
        $statusOptions = IdentitasServer::getStatusOptions();

        return view('identitas-server.edit', compact(
            'identitasServer',
            'lingkunganOptions',
            'avOptions',
            'statusOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IdentitasServer $identitasServer)
    {
        $validated = $request->validate([
            // 2-5. SERVER INFO
            'no' => 'required|integer|min:1|unique:identitas_server,no,' . $identitasServer->id,
            'ip_host_server' => 'required|ip',
            'nama_server' => 'required|string|max:255',
            'lingkungan_server' => 'required|in:Development,Staging,Production',

            // 6-7. IP SERVER
            'ip_local' => 'nullable|ip',
            'ip_public' => 'nullable|ip',

            // 8-11. SYSTEM SPECS
            'os' => 'nullable|string|max:100',
            'ram_gb' => 'nullable|integer|min:1',
            'virtual_socket' => 'nullable|integer|min:1',
            'core_per_socket' => 'nullable|integer|min:1',

            // 12-17. STORAGE & SOFTWARE
            'harddisk_gb' => 'nullable|integer|min:1',
            'versi_php' => 'nullable|string|max:50',
            'av_bitdefender' => 'nullable|in:Ada,Tidak Ada,TIDAK ADA',
            'administrator' => 'nullable|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'keterangan' => 'nullable|string',
        ]);

        $identitasServer->update($validated);

        return redirect()->route('identitas-server.index')
            ->with('success', 'Data server berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IdentitasServer $identitasServer)
    {
        $identitasServer->delete();

        return redirect()->route('identitas-server.index')
            ->with('success', 'Data server berhasil dihapus');
    }
}
