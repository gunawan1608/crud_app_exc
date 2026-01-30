<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Catatan SOC</h2>
                <p class="text-sm text-gray-500 mt-1">Report Tim Security Operations Center Badan Standardisasi Nasional</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('catatan-soc.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Catatan
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
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Total Catatan</p>
                            <p class="text-4xl font-semibold text-gray-900">{{ $totalCatatan }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Seluruh catatan SOC</p>
                </div>

                <div class="bg-white border border-red-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Total Insiden</p>
                            <p class="text-4xl font-semibold text-red-600">{{ $totalInsiden }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Insiden/anomali yang terjadi</p>
                </div>

                <div class="bg-white border border-blue-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Bulan Ini</p>
                            <p class="text-4xl font-semibold text-blue-600">{{ $catatanBulanIni }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">{{ now()->locale('id')->isoFormat('MMMM YYYY') }}</p>
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
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jadwal Pelaksanaan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penanggung Jawab</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pelaksana</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">To Do List</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Gambar</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Keterangan</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Terjadi Insiden</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($catatans as $index => $catatan)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-4 text-sm text-gray-900 font-medium whitespace-nowrap">
                                        {{ $catatans->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">
                                        <div class="font-medium">{{ $catatan->hari_tanggal->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $catatan->waktu ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">
                                        {{ $catatan->penanggung_jawab }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-xs">{{ $catatan->getPelaksanaNames() }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-md">{{ Str::limit($catatan->to_do_list, 100) }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-center whitespace-nowrap">
                                        @if($catatan->gambar)
                                            <a href="{{ Storage::url($catatan->gambar) }}" target="_blank"
                                                class="inline-flex items-center px-2.5 py-1 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Lihat
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-xs">{{ $catatan->keterangan ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold border {{ $catatan->insiden_color }}">
                                            {{ strtoupper($catatan->terjadi_insiden) }}
                                        </span>
                                        @if($catatan->terjadi_insiden === 'ya' && $catatan->keterangan_insiden)
                                            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($catatan->keterangan_insiden, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-2">
                                            <!-- Edit -->
                                            <a href="{{ route('catatan-soc.edit', $catatan) }}"
                                                class="p-1 text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            
                                            <!-- Print/Cetak -->
                                            <a href="{{ route('catatan-soc.print', $catatan) }}" target="_blank"
                                                class="p-1 text-purple-600 hover:text-purple-800 transition-colors" title="Cetak">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                </svg>
                                            </a>
                                            
                                            <!-- Download PDF -->
                                            <a href="{{ route('catatan-soc.download-pdf', $catatan) }}"
                                                class="p-1 text-green-600 hover:text-green-800 transition-colors" title="Unduh PDF">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </a>
                                            
                                            <!-- Delete -->
                                            <form action="{{ route('catatan-soc.destroy', $catatan) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus catatan ini?');">
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
                                    <td colspan="9" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <p class="text-base font-medium text-gray-900 mb-1">Belum ada catatan SOC</p>
                                            <p class="text-sm text-gray-500">Klik tombol "Tambah Catatan" untuk menambahkan data baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $catatans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>