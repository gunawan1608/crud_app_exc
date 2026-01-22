<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Insiden
            </h2>
            <div class="flex space-x-3">
                <!-- Tombol Export -->
                <a href="{{ route('logbook.export') }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel
                </a>

                <!-- Tombol Import -->
                <button onclick="document.getElementById('importModal').classList.remove('hidden')"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Import Excel
                </button>

                <!-- Tombol Tambah -->
                <a href="{{ route('logbook.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Insiden
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <!-- Alert Success -->
            @if (session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4">
                    <div class="flex">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Alert Error -->
            @if (session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Card Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-bold text-green-800 uppercase w-12">No</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-bold text-green-800 uppercase min-w-[140px]">
                                    Pelapor</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-bold text-green-800 uppercase min-w-[120px]">
                                    Aplikasi</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-bold text-green-800 uppercase min-w-[100px]">
                                    IP Server</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-bold text-green-800 uppercase min-w-[150px]">
                                    Tipe Insiden</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-bold text-green-800 uppercase min-w-[130px]">
                                    Waktu Mulai</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-bold text-green-800 uppercase min-w-[130px]">
                                    Waktu Selesai</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-bold text-green-800 uppercase min-w-[110px]">
                                    Downtime</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-green-800 uppercase min-w-[80px]">
                                    SLA</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-bold text-green-800 uppercase min-w-[120px]">
                                    SLA Tahunan
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-bold text-green-800 uppercase min-w-[140px]">
                                    Status SLA
                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-bold text-green-800 uppercase min-w-[200px]">
                                    Keterangan</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-bold text-green-800 uppercase min-w-[140px]">
                                    Direspon Oleh</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-bold text-green-800 uppercase min-w-[100px]">
                                    Status</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-green-800 uppercase w-24">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($logbooks as $index => $logbook)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-3 py-4 text-sm text-gray-900 font-medium text-center">
                                        {{ $logbooks->firstItem() + $index }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $logbook->pelapor }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $logbook->metode_pelaporan }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        {{ $logbook->aplikasi ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 font-mono">
                                        {{ $logbook->ip_server ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        {{ $logbook->tipe_insiden ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="font-medium">{{ $logbook->waktu_mulai->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $logbook->waktu_mulai->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="font-medium">{{ $logbook->waktu_selesai->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $logbook->waktu_selesai->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm">
                                        <div class="font-bold text-green-700">{{ $logbook->getDowntimeFormatted() }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $logbook->konversi_ke_jam }} jam</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        {{ $logbook->sla ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        {{ $logbook->persentase_sla_tahunan ?? '-' }} %
                                    </td>

                                    <td class="px-4 py-4">
                                        @if ($logbook->status_sla === 'SLA Tercapai')
                                            <span
                                                class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                SLA Tercapai
                                            </span>
                                        @elseif ($logbook->status_sla === 'SLA Tidak Tercapai')
                                            <span
                                                class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                SLA Tidak Tercapai
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-xs">
                                            <p class="line-clamp-2" title="{{ $logbook->keterangan }}">
                                                {{ Str::limit($logbook->keterangan, 80) }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        {{ $logbook->direspon_oleh }}
                                    </td>
                                    <td class="px-4 py-4">
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $logbook->status_color }}">
                                            {{ $logbook->status_insiden }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('logbook.edit', $logbook) }}"
                                                class="text-green-600 hover:text-green-900 transition-colors"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('logbook.destroy', $logbook) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data dari {{ $logbook->pelapor }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition-colors"
                                                    title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="px-6 py-12 text-center text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="mt-2 text-sm font-medium">Belum ada data insiden</p>
                                        <p class="mt-1 text-xs text-gray-400">Klik tombol "Tambah Insiden" untuk
                                            menambahkan data</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $logbooks->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <div id="importModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Import Data dari Excel</h3>

                <form action="{{ route('logbook.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih File Excel <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        <p class="mt-1 text-xs text-gray-500">Format: .xlsx, .xls, atau .csv (Maks 5MB)</p>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-3 mb-4">
                        <p class="text-xs text-blue-700">
                            <strong>Pastikan:</strong><br>
                            • Header Excel sesuai dengan kolom database<br>
                            • Format tanggal: dd/mm/yyyy hh:mm<br>
                            • Status: Open / On Progress / Closed
                        </p>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button"
                            onclick="document.getElementById('importModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 text-sm font-medium">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm font-medium">
                            Upload & Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
