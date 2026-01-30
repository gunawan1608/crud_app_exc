<?php

namespace App\Http\Controllers;

use App\Models\HakAksesServer;
use Illuminate\Http\Request;

class HakAksesServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servers = HakAksesServer::orderBy('id', 'desc')->paginate(10);

        // Statistics
        $totalServers = HakAksesServer::count();
        $activeServers = HakAksesServer::where('status', 'Aktif')->count();
        $productionServers = HakAksesServer::where('lingkungan_server', 'Production')->count();

        return view('hak-akses-server.index', compact(
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
        $ipHostOptions = HakAksesServer::getIpHostServerOptions();
        $lingkunganOptions = HakAksesServer::getLingkunganOptions();
        $kategoriOptions = HakAksesServer::getKategoriSistemOptions();
        $roleOptions = HakAksesServer::getRoleHakAksesOptions();
        $statusOptions = HakAksesServer::getStatusOptions();

        return view('hak-akses-server.create', compact(
            'ipHostOptions',
            'lingkunganOptions',
            'kategoriOptions',
            'roleOptions',
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
            'aplikasi' => 'required|string|max:255',
            'kategori_sistem_elektronik' => 'required|string|max:100',
            'role_hak_akses' => 'required|string|max:100',
            'akun' => 'required|string|max:255',
            'pemilik_hak_akses' => 'required|string|max:255',
            'hak_akses' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'keterangan' => 'nullable|string',
        ]);

        HakAksesServer::create($validated);

        return redirect()->route('hak-akses-server.index')
            ->with('success', 'Data hak akses server berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HakAksesServer $hakAksesServer)
    {
        $ipHostOptions = HakAksesServer::getIpHostServerOptions();
        $lingkunganOptions = HakAksesServer::getLingkunganOptions();
        $kategoriOptions = HakAksesServer::getKategoriSistemOptions();
        $roleOptions = HakAksesServer::getRoleHakAksesOptions();
        $statusOptions = HakAksesServer::getStatusOptions();

        return view('hak-akses-server.edit', compact(
            'hakAksesServer',
            'ipHostOptions',
            'lingkunganOptions',
            'kategoriOptions',
            'roleOptions',
            'statusOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HakAksesServer $hakAksesServer)
    {
        $validated = $request->validate([
            'ip_host_server' => 'required|in:192.168.10.21,192.168.10.22,192.168.10.24,202.43.168.180',
            'nama_server' => 'required|string|max:255',
            'lingkungan_server' => 'required|in:Production,Development,Staging',
            'ip_local' => 'nullable|ip',
            'ip_public' => 'nullable|ip',
            'aplikasi' => 'required|string|max:255',
            'kategori_sistem_elektronik' => 'required|string|max:100',
            'role_hak_akses' => 'required|string|max:100',
            'akun' => 'required|string|max:255',
            'pemilik_hak_akses' => 'required|string|max:255',
            'hak_akses' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'keterangan' => 'nullable|string',
        ]);

        $hakAksesServer->update($validated);

        return redirect()->route('hak-akses-server.index')
            ->with('success', 'Data hak akses server berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HakAksesServer $hakAksesServer)
    {
        $hakAksesServer->delete();

        return redirect()->route('hak-akses-server.index')
            ->with('success', 'Data hak akses server berhasil dihapus');
    }
}
