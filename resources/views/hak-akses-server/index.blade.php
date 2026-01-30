<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Hak Akses Server</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola dan monitor hak akses server</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('hak-akses-server.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Hak Akses
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <!-- Statistics Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Total Hak Akses</p>
                            <p class="text-4xl font-semibold text-gray-900">{{ $totalServers }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Seluruh hak akses terdaftar</p>
                </div>

                <div class="bg-white border border-green-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Akses Aktif</p>
                            <p class="text-4xl font-semibold text-green-600">{{ $activeServers }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Hak akses dalam kondisi aktif</p>
                </div>

                <div class="bg-white border border-blue-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Production</p>
                            <p class="text-4xl font-semibold text-blue-600">{{ $productionServers }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Hak akses production environment</p>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Data Table -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">IP Host Server</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Server</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lingkungan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">IP Local</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">IP Public</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aplikasi</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori Sistem</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Role Hak Akses</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Akun</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pemilik</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hak Akses</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Keterangan</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($servers as $index => $server)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-4 text-sm text-gray-900 font-medium whitespace-nowrap">
                                        {{ $servers->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-4 text-sm font-mono text-gray-700 whitespace-nowrap">
                                        {{ $server->ip_host_server }}
                                    </td>
                                    <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                        {{ $server->nama_server }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold border {{ $server->lingkungan_color }}">
                                            {{ $server->lingkungan_server }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm font-mono text-gray-700 whitespace-nowrap">
                                        {{ $server->ip_local ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-sm font-mono text-gray-700 whitespace-nowrap">
                                        {{ $server->ip_public ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        {{ $server->aplikasi }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold border {{ $server->kategori_color }}">
                                            {{ $server->kategori_sistem_elektronik }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold border {{ $server->role_color }}">
                                            {{ $server->role_hak_akses }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">
                                        {{ $server->akun }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">
                                        {{ $server->pemilik_hak_akses }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        {{ $server->hak_akses }}
                                    </td>
                                    <td class="px-4 py-4 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold border {{ $server->status_color }}">
                                            {{ $server->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-xs">{{ $server->keterangan ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('hak-akses-server.edit', $server) }}"
                                                class="p-1 text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('hak-akses-server.destroy', $server) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus hak akses {{ $server->aplikasi }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 text-red-600 hover:text-red-800 transition-colors" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="15" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                            <p class="text-base font-medium text-gray-900 mb-1">Belum ada data hak akses server</p>
                                            <p class="text-sm text-gray-500">Klik tombol "Tambah Hak Akses" untuk menambahkan data baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $servers->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
