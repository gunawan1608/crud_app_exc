<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Logbook Insiden Infrastruktur</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola dan monitor insiden infrastruktur (Urutan sesuai Excel)</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('infrastruktur.create') }}"
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
                <!-- SLA Tahunan Global -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">SLA Tahunan Global</p>
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
                    <p class="text-xs text-gray-500">Standar kebijakan infrastruktur</p>
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

            <!-- Data Table (URUTAN PERSIS SEPERTI EXCEL) -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <!-- 1. No -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    No
                                </th>
                                <!-- 2. Pelapor -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Pelapor
                                </th>
                                <!-- 3. Metode Pelaporan -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Metode Pelaporan
                                </th>
                                <!-- 4. Waktu Mulai -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Waktu Mulai
                                </th>
                                <!-- 5. Waktu Selesai -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Waktu Selesai
                                </th>
                                <!-- 6. Lama Downtime (OTOMATIS) -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">
                                    Lama Downtime (Menit)
                                </th>
                                <!-- 7. Konversi Ke Jam (OTOMATIS) -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">
                                    Konversi Ke Jam
                                </th>
                                <!-- 8. SLA (OTOMATIS) -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">
                                    SLA (%)
                                </th>
                                <!-- 9. % SLA Tahunan (OTOMATIS) -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">
                                    % SLA Tahunan
                                </th>
                                <!-- 10. Keterangan SLA -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Keterangan SLA
                                </th>
                                <!-- 11. Lokasi -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Lokasi
                                </th>
                                <!-- 12. Insiden -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Insiden
                                </th>
                                <!-- 13. Tipe Insiden -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Tipe Insiden
                                </th>
                                <!-- 14. Keterangan -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Keterangan
                                </th>
                                <!-- 15. Akar Penyebab -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Akar Penyebab
                                </th>
                                <!-- 16. Tindak Lanjut (Detail) -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Tindak Lanjut (Detail)
                                </th>
                                <!-- 17. No Ticket (Jika ada) -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    No Ticket
                                </th>
                                <!-- 18. Direspon Oleh -->
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Direspon Oleh
                                </th>
                                <!-- Aksi -->
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($logbooks as $index => $logbook)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <!-- 1. No -->
                                    <td class="px-4 py-4 text-sm text-gray-900 font-medium whitespace-nowrap">
                                        {{ $logbooks->firstItem() + $index }}
                                    </td>
                                    <!-- 2. Pelapor -->
                                    <td class="px-4 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        {{ $logbook->pelapor }}
                                    </td>
                                    <!-- 3. Metode Pelaporan -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                            {{ $logbook->metode_pelaporan }}
                                        </span>
                                    </td>
                                    <!-- 4. Waktu Mulai -->
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">
                                        <div class="font-medium">{{ $logbook->waktu_mulai->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $logbook->waktu_mulai->format('H:i') }}</div>
                                    </td>
                                    <!-- 5. Waktu Selesai -->
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">
                                        <div class="font-medium">{{ $logbook->waktu_selesai->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $logbook->waktu_selesai->format('H:i') }}</div>
                                    </td>
                                    <!-- 6. Lama Downtime (OTOMATIS) -->
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        <span class="font-semibold text-blue-700 bg-blue-50 px-2 py-1 rounded">
                                            {{ number_format($logbook->lama_downtime) }}
                                        </span>
                                    </td>
                                    <!-- 7. Konversi Ke Jam (OTOMATIS) -->
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        <span class="font-semibold text-blue-700 bg-blue-50 px-2 py-1 rounded">
                                            {{ number_format($logbook->konversi_ke_jam, 2) }}
                                        </span>
                                    </td>
                                    <!-- 8. SLA (OTOMATIS) -->
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        <span class="font-semibold text-blue-700 bg-blue-50 px-2 py-1 rounded">
                                            {{ number_format($logbook->sla, 6) }}%
                                        </span>
                                    </td>
                                    <!-- 9. % SLA Tahunan (OTOMATIS) -->
                                    <td class="px-4 py-4 text-sm whitespace-nowrap">
                                        <span class="font-semibold text-indigo-700 bg-indigo-50 px-2 py-1 rounded">
                                            {{ number_format($logbook->persentase_sla_tahunan, 6) }}%
                                        </span>
                                    </td>
                                    <!-- 10. Keterangan SLA -->
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-xs">{{ $logbook->keterangan_sla ?? '-' }}</div>
                                    </td>
                                    <!-- 11. Lokasi -->
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">
                                        {{ $logbook->lokasi }}
                                    </td>
                                    <!-- 12. Insiden -->
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-xs">{{ $logbook->insiden }}</div>
                                    </td>
                                    <!-- 13. Tipe Insiden -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($logbook->tipe_insiden)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">
                                                {{ $logbook->tipe_insiden }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <!-- 14. Keterangan -->
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-sm">{{ Str::limit($logbook->keterangan, 100) }}</div>
                                    </td>
                                    <!-- 15. Akar Penyebab -->
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-xs">{{ $logbook->akar_penyebab ? Str::limit($logbook->akar_penyebab, 80) : '-' }}</div>
                                    </td>
                                    <!-- 16. Tindak Lanjut (Detail) -->
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-xs">{{ $logbook->tindak_lanjut_detail ? Str::limit($logbook->tindak_lanjut_detail, 80) : '-' }}</div>
                                    </td>
                                    <!-- 17. No Ticket (Jika ada) -->
                                    <td class="px-4 py-4 text-sm text-gray-700 whitespace-nowrap">
                                        {{ $logbook->no_ticket ?? '-' }}
                                    </td>
                                    <!-- 18. Direspon Oleh -->
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-xs">{{ $logbook->getResponderNames() }}</div>
                                    </td>
                                    <!-- Aksi -->
                                    <td class="px-4 py-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('infrastruktur.edit', $logbook) }}"
                                                class="p-1 text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('infrastruktur.destroy', $logbook) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data insiden {{ $logbook->insiden }}?');">
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
                                    <td colspan="19" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                            <p class="text-base font-medium text-gray-900 mb-1">Belum ada data insiden infrastruktur</p>
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

            <!-- Info Box -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-blue-900 mb-1">Catatan Penting</p>
                        <ul class="text-xs text-blue-700 space-y-1">
                            <li>• Kolom dengan highlight biru (6-9) dihitung otomatis oleh sistem</li>
                            <li>• Formula SLA: 100 - ((konversi_ke_jam / 8760) * 100)</li>
                            <li>• Formula % SLA Tahunan: 100 - SLA_per_kejadian</li>
                            <li>• Urutan kolom sudah disesuaikan dengan format Excel standar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
