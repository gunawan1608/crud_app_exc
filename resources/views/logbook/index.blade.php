<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Data Insiden</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola dan monitor seluruh data insiden aplikasi</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('logbook.export') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export
                </a>

                <button onclick="document.getElementById('importModal').classList.remove('hidden')"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Import
                </button>

                <a href="{{ route('logbook.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Insiden
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <!-- SLA Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <!-- SLA Tahunan -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">SLA Tahunan</p>
                            <p class="text-4xl font-semibold text-gray-900">{{ number_format($slaTahunan, 2) }}%</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Akumulasi dari semua insiden</p>
                </div>

                <!-- Target SLA -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Target SLA</p>
                            <p class="text-4xl font-semibold text-gray-900">{{ number_format($targetSla, 2) }}%</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Standar kebijakan kantor</p>
                </div>

                <!-- Status SLA -->
                <div class="bg-white border border-{{ $statusSla === 'TERCAPAI' ? 'green' : 'red' }}-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Status SLA</p>
                            <p class="text-2xl font-semibold text-{{ $statusSla === 'TERCAPAI' ? 'green' : 'red' }}-600">{{ $statusSla }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">
                        {{ $statusSla === 'TERCAPAI' ? 'Memenuhi target yang ditetapkan' : 'Di bawah target yang ditetapkan' }}
                    </p>
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

            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
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
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pelapor</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Metode</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aplikasi</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">IP Server</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipe</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Waktu Mulai</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Waktu Selesai</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Keterangan Waktu</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Downtime</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jam</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">SLA (%)</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kontribusi (%)</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Target (%)</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status SLA</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ket. SLA</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Keterangan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Akar Penyebab</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tindak Lanjut</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Direspon</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($logbooks as $index => $logbook)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-4 text-sm text-gray-900 font-medium whitespace-nowrap">
                                        {{ $logbooks->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        {{ $logbook->pelapor }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            {{ $logbook->metode_pelaporan }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">{{ $logbook->aplikasi ?? '-' }}</td>
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">{{ $logbook->ip_server ?? '-' }}</td>
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">{{ $logbook->tipe_insiden ?? '-' }}</td>
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">
                                        <div class="font-medium">{{ $logbook->waktu_mulai->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $logbook->waktu_mulai->format('H:i') }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">
                                        <div class="font-medium">{{ $logbook->waktu_selesai->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $logbook->waktu_selesai->format('H:i') }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-xs">{{ $logbook->keterangan_waktu_selesai ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-900 font-medium whitespace-nowrap text-right">
                                        {{ number_format($logbook->downtime_menit ?? 0) }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap text-right">
                                        {{ number_format($logbook->konversi_ke_jam ?? 0, 2) }}
                                    </td>
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        <span class="font-semibold text-blue-700">{{ number_format($logbook->sla ?? 0, 4) }}%</span>
                                    </td>
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        <span class="font-semibold text-indigo-700">{{ number_format($logbook->persentase_sla_tahunan ?? 0, 4) }}%</span>
                                    </td>
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        <span class="font-semibold text-gray-700">{{ number_format($logbook->target_sla ?? 98, 2) }}%</span>
                                    </td>
                                    <td class="px-4 py-4 text-center whitespace-nowrap">
                                        @if ($logbook->status_sla)
                                            <span class="px-2.5 py-0.5 inline-flex text-xs font-semibold rounded border {{ $logbook->sla_status_color }}">
                                                {{ $logbook->status_sla }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-xs">{{ $logbook->keterangan_sla ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-sm">{{ Str::limit($logbook->keterangan, 100) }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-xs">{{ $logbook->akar_penyebab ? Str::limit($logbook->akar_penyebab, 80) : '-' }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-xs">{{ $logbook->tindak_lanjut_detail ? Str::limit($logbook->tindak_lanjut_detail, 80) : '-' }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">{{ $logbook->direspon_oleh }}</td>
                                    <td class="px-4 py-4 text-center whitespace-nowrap">
                                        <span class="px-2.5 py-0.5 inline-flex text-xs font-semibold rounded border {{ $logbook->status_color }}">
                                            {{ $logbook->status_insiden }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('logbook.edit', $logbook) }}"
                                                class="p-1 text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('logbook.destroy', $logbook) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data dari {{ $logbook->pelapor }}?');">
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
                                    <td colspan="22" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <p class="text-base font-medium text-gray-900 mb-1">Belum ada data insiden</p>
                                            <p class="text-sm text-gray-500">Klik tombol "Tambah Insiden" untuk menambahkan data baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $logbooks->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <div id="importModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-6 border border-gray-200 w-full max-w-md shadow-lg rounded-lg bg-white">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Import Data Excel</h3>
                <button onclick="document.getElementById('importModal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form action="{{ route('logbook.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel</label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none hover:border-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                    <p class="mt-2 text-xs text-gray-500">Format: .xlsx, .xls, atau .csv (Max 5MB)</p>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-xs text-blue-800 leading-relaxed">
                        <strong class="block mb-2">Catatan Penting:</strong>
                        • SLA akan dihitung otomatis oleh sistem<br>
                        • Format tanggal: dd/mm/yyyy hh:mm<br>
                        • Status: Open / On Progress / Closed
                    </p>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')"
                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                        Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>