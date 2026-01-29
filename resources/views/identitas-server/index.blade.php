<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Identitas Server</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola dan monitor identitas server IT (Urutan sesuai Excel)</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('identitas-server.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Server
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <!-- Statistics Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Servers -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Total Server</p>
                            <p class="text-4xl font-semibold text-gray-900">{{ $totalServers }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Seluruh server terdaftar</p>
                </div>

                <!-- Active Servers -->
                <div class="bg-white border border-green-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Server Aktif</p>
                            <p class="text-4xl font-semibold text-green-600">{{ $activeServers }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Server dalam kondisi aktif</p>
                </div>

                <!-- Production Servers -->
                <div class="bg-white border border-blue-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Production</p>
                            <p class="text-4xl font-semibold text-blue-600">{{ $productionServers }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Server production environment</p>
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

            <!-- Data Table (URUTAN PERSIS SEPERTI EXCEL) -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <!-- 1. ID (Hidden, auto) -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    No
                                </th>
                                <!-- 2. No -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    No Urut
                                </th>
                                <!-- 3. IP HOST SERVER -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    IP Host Server
                                </th>
                                <!-- 4. NAMA SERVER -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Nama Server
                                </th>
                                <!-- 5. LINGKUNGAN SERVER -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Lingkungan
                                </th>
                                <!-- 6. IP SERVER - LOCAL -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    IP Local
                                </th>
                                <!-- 7. IP SERVER - PUBLIC -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    IP Public
                                </th>
                                <!-- 8. OS -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    OS
                                </th>
                                <!-- 9. RAM (GB) -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    RAM (GB)
                                </th>
                                <!-- 10. virtual socket -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    vSocket
                                </th>
                                <!-- 11. Core per Socket -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Core/Socket
                                </th>
                                <!-- 12. HARDDISK (GB) -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    HDD (GB)
                                </th>
                                <!-- 13. Versi PHP -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    PHP
                                </th>
                                <!-- 14. AV BITDEFENDER -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    BitDefender
                                </th>
                                <!-- 15. Administrator -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Admin
                                </th>
                                <!-- 16. Status -->
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status
                                </th>
                                <!-- 17. Keterangan -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Keterangan
                                </th>
                                <!-- Aksi -->
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($servers as $index => $server)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <!-- Table ID -->
                                    <td class="px-4 py-4 text-sm text-gray-900 font-medium whitespace-nowrap">
                                        {{ $servers->firstItem() + $index }}
                                    </td>
                                    <!-- 2. No -->
                                    <td class="px-4 py-4 text-sm font-semibold text-gray-900 whitespace-nowrap">
                                        {{ $server->no }}
                                    </td>
                                    <!-- 3. IP HOST SERVER -->
                                    <td class="px-4 py-4 text-sm font-mono text-gray-700 whitespace-nowrap">
                                        {{ $server->ip_host_server }}
                                    </td>
                                    <!-- 4. NAMA SERVER -->
                                    <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                        {{ $server->nama_server }}
                                    </td>
                                    <!-- 5. LINGKUNGAN SERVER -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold border {{ $server->lingkungan_color }}">
                                            {{ $server->lingkungan_server }}
                                        </span>
                                    </td>
                                    <!-- 6. IP Local -->
                                    <td class="px-4 py-4 text-sm font-mono text-gray-700 whitespace-nowrap">
                                        {{ $server->ip_local ?? '-' }}
                                    </td>
                                    <!-- 7. IP Public -->
                                    <td class="px-4 py-4 text-sm font-mono text-gray-700 whitespace-nowrap">
                                        {{ $server->ip_public ?? '-' }}
                                    </td>
                                    <!-- 8. OS -->
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        {{ $server->os ?? '-' }}
                                    </td>
                                    <!-- 9. RAM (GB) -->
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap text-right">
                                        {{ $server->ram_gb ?? '-' }}
                                    </td>
                                    <!-- 10. virtual socket -->
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap text-right">
                                        {{ $server->virtual_socket ?? '-' }}
                                    </td>
                                    <!-- 11. Core per Socket -->
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap text-right">
                                        {{ $server->core_per_socket ?? '-' }}
                                    </td>
                                    <!-- 12. HARDDISK (GB) -->
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap text-right">
                                        {{ $server->harddisk_gb ?? '-' }}
                                    </td>
                                    <!-- 13. Versi PHP -->
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">
                                        {{ $server->versi_php ?? '-' }}
                                    </td>
                                    <!-- 14. AV BITDEFENDER -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($server->av_bitdefender)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold border {{ $server->av_color }}">
                                                {{ $server->av_bitdefender }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <!-- 15. Administrator -->
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">
                                        {{ $server->administrator ?? '-' }}
                                    </td>
                                    <!-- 16. Status -->
                                    <td class="px-4 py-4 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold border {{ $server->status_color }}">
                                            {{ $server->status }}
                                        </span>
                                    </td>
                                    <!-- 17. Keterangan -->
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-xs">{{ $server->keterangan ?? '-' }}</div>
                                    </td>
                                    <!-- Aksi -->
                                    <td class="px-4 py-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('identitas-server.edit', $server) }}"
                                                class="p-1 text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('identitas-server.destroy', $server) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus server {{ $server->nama_server }}?');">
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
                                    <td colspan="18" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                                                </svg>
                                            </div>
                                            <p class="text-base font-medium text-gray-900 mb-1">Belum ada data server</p>
                                            <p class="text-sm text-gray-500">Klik tombol "Tambah Server" untuk menambahkan data baru</p>
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

            <!-- Info Box -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-blue-900 mb-1">Catatan Penting</p>
                        <ul class="text-xs text-blue-700 space-y-1">
                            <li>• Urutan kolom sudah disesuaikan dengan format Excel standar</li>
                            <li>• Nomor urut (No) harus unik untuk setiap server</li>
                            <li>• IP Host Server wajib diisi dengan format IP yang valid</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
