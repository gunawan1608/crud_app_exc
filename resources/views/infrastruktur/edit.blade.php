<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('infrastruktur.index') }}"
                   class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">Edit Data Insiden Infrastruktur</h2>
                    <p class="text-sm text-gray-500 mt-1">Perbarui informasi insiden yang telah terdokumentasi</p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 px-4 py-3 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">SLA Tahunan</p>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($slaTahunan, 2) }}%</p>
                    </div>
                    <div class="h-10 w-px bg-gray-300"></div>
                    <div class="text-right">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Target</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $targetSla }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Current Data Preview -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-5 mb-6">
                <h3 class="text-sm font-semibold text-blue-900 mb-3">Data Saat Ini</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white rounded-lg p-3 border border-blue-100">
                        <p class="text-xs text-gray-600 mb-1">SLA Kejadian</p>
                        <p class="text-lg font-semibold text-blue-700">{{ number_format($infrastruktur->sla_persen ?? 0, 2) }}%</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-blue-100">
                        <p class="text-xs text-gray-600 mb-1">Downtime</p>
                        <p class="text-lg font-semibold text-blue-700">{{ $infrastruktur->getDowntimeFormatted() }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-blue-100">
                        <p class="text-xs text-gray-600 mb-1">Target SLA</p>
                        <p class="text-lg font-semibold text-blue-700">{{ number_format($infrastruktur->target_sla ?? 98, 2) }}%</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-blue-100">
                        <p class="text-xs text-gray-600 mb-1">Status</p>
                        <p class="text-sm font-semibold {{ $infrastruktur->status_sla === 'SLA TERCAPAI' ? 'text-green-700' : 'text-red-700' }}">
                            {{ $infrastruktur->status_sla ?? 'N/A' }}
                        </p>
                    </div>
                </div>
                <p class="text-xs text-blue-700 mt-3">Nilai akan diperbarui otomatis setelah form disimpan</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg">
                <form method="POST" action="{{ route('infrastruktur.update', $infrastruktur) }}">
                    @csrf
                    @method('PUT')

                    <!-- Informasi Lokasi & Insiden -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Informasi Lokasi & Insiden</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Lokasi <span class="text-red-500">*</span>
                                </label>
                                <select id="lokasi" name="lokasi"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('lokasi') border-red-300 @enderror"
                                    required autofocus>
                                    <option value="">Pilih lokasi</option>
                                    @foreach($lokasiOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('lokasi', $infrastruktur->lokasi) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lokasi')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tipe_insiden" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tipe Insiden
                                </label>
                                <select id="tipe_insiden" name="tipe_insiden"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    <option value="">Pilih tipe insiden</option>
                                    @foreach($tipeInsidenOptions as $tipe)
                                        <option value="{{ $tipe }}" {{ old('tipe_insiden', $infrastruktur->tipe_insiden) == $tipe ? 'selected' : '' }}>
                                            {{ $tipe }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="insiden" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Insiden <span class="text-red-500">*</span>
                            </label>
                            <input id="insiden" type="text" name="insiden" value="{{ old('insiden', $infrastruktur->insiden) }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('insiden') border-red-300 @enderror"
                                required placeholder="Contoh: Gangguan Listrik, Kerusakan AC, dll.">
                            @error('insiden')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="no_ticket" class="block text-sm font-medium text-gray-700 mb-2">
                                No Ticket
                            </label>
                            <input id="no_ticket" type="text" name="no_ticket" value="{{ old('no_ticket', $infrastruktur->no_ticket) }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="TKT-2026-001">
                        </div>
                    </div>

                    <!-- Waktu & Downtime -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Waktu & Downtime</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label for="waktu_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                    Waktu Mulai <span class="text-red-500">*</span>
                                </label>
                                <input id="waktu_mulai" type="datetime-local" name="waktu_mulai"
                                    value="{{ old('waktu_mulai', $infrastruktur->waktu_mulai->format('Y-m-d\TH:i')) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('waktu_mulai') border-red-300 @enderror"
                                    required>
                                @error('waktu_mulai')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="waktu_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                    Waktu Selesai <span class="text-red-500">*</span>
                                </label>
                                <input id="waktu_selesai" type="datetime-local" name="waktu_selesai"
                                    value="{{ old('waktu_selesai', $infrastruktur->waktu_selesai->format('Y-m-d\TH:i')) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('waktu_selesai') border-red-300 @enderror"
                                    required>
                                @error('waktu_selesai')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-blue-900">Perhitungan Ulang Otomatis</p>
                                    <p class="text-xs text-blue-700 mt-1">Sistem akan menghitung ulang downtime, SLA per kejadian, dan SLA tahunan setelah data diperbarui</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Konfigurasi SLA -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Konfigurasi SLA</h3>

                        <div>
                            <label for="target_sla" class="block text-sm font-medium text-gray-700 mb-2">
                                Target SLA (%) <span class="text-red-500">*</span>
                            </label>
                            <input id="target_sla" type="number" step="0.01" name="target_sla"
                                value="{{ old('target_sla', $infrastruktur->target_sla ?? 98.00) }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="98.00" required>
                            <p class="text-xs text-gray-500 mt-1.5">Standar kebijakan: 98%</p>
                        </div>
                    </div>

                    <!-- Deskripsi Insiden -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Deskripsi Insiden</h3>

                        <div class="space-y-5">
                            <div>
                                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Keterangan Insiden
                                </label>
                                <textarea id="keterangan" name="keterangan" rows="4"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                    placeholder="Jelaskan detail insiden yang terjadi...">{{ old('keterangan', $infrastruktur->keterangan) }}</textarea>
                            </div>

                            <div>
                                <label for="akar_penyebab" class="block text-sm font-medium text-gray-700 mb-2">
                                    Akar Penyebab
                                </label>
                                <textarea id="akar_penyebab" name="akar_penyebab" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                    placeholder="Root cause analysis...">{{ old('akar_penyebab', $infrastruktur->akar_penyebab) }}</textarea>
                            </div>

                            <div>
                                <label for="tindak_lanjut" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tindak Lanjut
                                </label>
                                <textarea id="tindak_lanjut" name="tindak_lanjut" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                    placeholder="Langkah-langkah tindak lanjut yang dilakukan...">{{ old('tindak_lanjut', $infrastruktur->tindak_lanjut) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Penanganan -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Penanganan</h3>

                        <div>
                            <label for="direspon_oleh" class="block text-sm font-medium text-gray-700 mb-2">
                                Direspon Oleh <span class="text-red-500">*</span>
                            </label>
                            <select id="direspon_oleh" name="direspon_oleh[]" multiple
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('direspon_oleh') border-red-300 @enderror"
                                required size="6">
                                @foreach($responderOptions as $responder)
                                    <option value="{{ $responder }}"
                                        {{ in_array($responder, old('direspon_oleh', $infrastruktur->direspon_oleh ?? [])) ? 'selected' : '' }}>
                                        {{ $responder }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1.5">Tekan Ctrl (Windows) atau Cmd (Mac) untuk memilih lebih dari satu</p>
                            @error('direspon_oleh')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="p-6 bg-gray-50">
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('infrastruktur.index') }}"
                                class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
