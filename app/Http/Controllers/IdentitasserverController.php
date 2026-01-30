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
        $servers = IdentitasServer::orderBy('id', 'asc')->paginate(10);

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
        $ipHostOptions = IdentitasServer::getIpHostServerOptions();
        $lingkunganOptions = IdentitasServer::getLingkunganOptions();
        $avOptions = IdentitasServer::getAvBitdefenderOptions();
        $statusOptions = IdentitasServer::getStatusOptions();

        return view('identitas-server.create', compact(
            'ipHostOptions',
            'lingkunganOptions',
            'avOptions',
            'statusOptions'
        ));
    }

    public function edit(IdentitasServer $identitasServer)
    {
        $ipHostOptions = IdentitasServer::getIpHostServerOptions();
        $lingkunganOptions = IdentitasServer::getLingkunganOptions();
        $avOptions = IdentitasServer::getAvBitdefenderOptions();
        $statusOptions = IdentitasServer::getStatusOptions();

        return view('identitas-server.edit', compact(
            'identitasServer',
            'ipHostOptions',
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
            'ip_host_server' => 'required|in:192.168.10.21,192.168.10.22,192.168.10.24,202.43.168.180',
            'nama_server' => 'required|string|max:255',
            'lingkungan_server' => 'required|in:Production,Development,Staging',
            'ip_local' => 'nullable|ip',
            'ip_public' => 'nullable|ip',
            'os' => 'nullable|string|max:100',
            'ram_gb' => 'nullable|integer|min:1',
            'virtual_socket' => 'nullable|integer|min:1',
            'core_per_socket' => 'nullable|integer|min:1',
            'harddisk_gb' => 'nullable|integer|min:1',
            'versi_php' => 'nullable|string|max:50',
            'av_bitdefender' => 'nullable|in:ADA,TIDAK ADA',
            'administrator' => 'nullable|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'keterangan' => 'nullable|string',
        ]);

        IdentitasServer::create($validated);

        return redirect()->route('identitas-server.index')
            ->with('success', 'Data server berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IdentitasServer $identitasServer)
    {
        $validated = $request->validate([
            'ip_host_server' => 'required|in:192.168.10.21,192.168.10.22,192.168.10.24,202.43.168.180',
            'nama_server' => 'required|string|max:255',
            'lingkungan_server' => 'required|in:Production,Development,Staging',
            'ip_local' => 'nullable|ip',
            'ip_public' => 'nullable|ip',
            'os' => 'nullable|string|max:100',
            'ram_gb' => 'nullable|integer|min:1',
            'virtual_socket' => 'nullable|integer|min:1',
            'core_per_socket' => 'nullable|integer|min:1',
            'harddisk_gb' => 'nullable|integer|min:1',
            'versi_php' => 'nullable|string|max:50',
            'av_bitdefender' => 'nullable|in:ADA,TIDAK ADA',
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
