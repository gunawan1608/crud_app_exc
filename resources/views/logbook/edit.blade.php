<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('logbook.index') }}" 
                   class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">Edit Data Insiden</h2>
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
                        <p class="text-lg font-semibold text-blue-700">{{ number_format($logbook->sla ?? 0, 4) }}%</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-blue-100">
                        <p class="text-xs text-gray-600 mb-1">Downtime</p>
                        <p class="text-lg font-semibold text-blue-700">{{ $logbook->getDowntimeFormatted() }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-blue-100">
                        <p class="text-xs text-gray-600 mb-1">Target SLA</p>
                        <p class="text-lg font-semibold text-blue-700">{{ number_format($logbook->target_sla ?? 98, 2) }}%</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-blue-100">
                        <p class="text-xs text-gray-600 mb-1">Status</p>
                        <p class="text-sm font-semibold {{ $logbook->status_sla === 'TERCAPAI' ? 'text-green-700' : 'text-red-700' }}">
                            {{ $logbook->status_sla ?? 'N/A' }}
                        </p>
                    </div>
                </div>
                <p class="text-xs text-blue-700 mt-3">Nilai akan diperbarui otomatis setelah form disimpan</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg">
                <form method="POST" action="{{ route('logbook.update', $logbook) }}">
                    @csrf
                    @method('PUT')

                    <!-- Informasi Pelapor -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Informasi Pelapor</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="pelapor" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Pelapor <span class="text-red-500">*</span>
                                </label>
                                <input id="pelapor" type="text" name="pelapor" value="{{ old('pelapor', $logbook->pelapor) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('pelapor') border-red-300 @enderror"
                                    required autofocus placeholder="Masukkan nama pelapor">
                                @error('pelapor')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="metode_pelaporan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Metode Pelaporan <span class="text-red-500">*</span>
                                </label>
                                <select id="metode_pelaporan" name="metode_pelaporan"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('metode_pelaporan') border-red-300 @enderror"
                                    required>
                                    <option value="">Pilih metode pelaporan</option>
                                    <option value="Email" {{ old('metode_pelaporan', $logbook->metode_pelaporan) == 'Email' ? 'selected' : '' }}>Email</option>
                                    <option value="Telepon" {{ old('metode_pelaporan', $logbook->metode_pelaporan) == 'Telepon' ? 'selected' : '' }}>Telepon</option>
                                    <option value="WhatsApp" {{ old('metode_pelaporan', $logbook->metode_pelaporan) == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                                    <option value="Langsung" {{ old('metode_pelaporan', $logbook->metode_pelaporan) == 'Langsung' ? 'selected' : '' }}>Langsung</option>
                                    <option value="Sistem" {{ old('metode_pelaporan', $logbook->metode_pelaporan) == 'Sistem' ? 'selected' : '' }}>Sistem</option>
                                </select>
                                @error('metode_pelaporan')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
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
                                    value="{{ old('waktu_mulai', $logbook->waktu_mulai->format('Y-m-d\TH:i')) }}"
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
                                    value="{{ old('waktu_selesai', $logbook->waktu_selesai->format('Y-m-d\TH:i')) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('waktu_selesai') border-red-300 @enderror"
                                    required>
                                @error('waktu_selesai')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="keterangan_waktu_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan Waktu Selesai
                            </label>
                            <textarea id="keterangan_waktu_selesai" name="keterangan_waktu_selesai" rows="2"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                placeholder="Catatan tambahan tentang waktu penyelesaian...">{{ old('keterangan_waktu_selesai', $logbook->keterangan_waktu_selesai) }}</textarea>
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

                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-600 mb-2">Nilai Otomatis (Current):</p>
                                    <ul class="space-y-1 text-gray-700">
                                        <li>• SLA: {{ number_format($logbook->sla ?? 0, 4) }}%</li>
                                        <li>• SLA Tahunan: {{ number_format($slaTahunan, 2) }}%</li>
                                        <li>• Status: {{ $logbook->status_sla ?? 'N/A' }}</li>
                                    </ul>
                                </div>
                                <div>
                                    <p class="text-gray-600 mb-2">Dapat Diubah:</p>
                                    <ul class="space-y-1 text-gray-700">
                                        <li>• Waktu mulai & selesai</li>
                                        <li>• Target SLA</li>
                                        <li>• Keterangan tambahan</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label for="target_sla" class="block text-sm font-medium text-gray-700 mb-2">
                                    Target SLA (%) <span class="text-red-500">*</span>
                                </label>
                                <input id="target_sla" type="number" step="0.01" name="target_sla"
                                    value="{{ old('target_sla', $logbook->target_sla ?? 98.00) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    placeholder="98.00" required>
                                <p class="text-xs text-gray-500 mt-1.5">Standar kebijakan: 98%</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Status SLA
                                </label>
                                <div class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg flex items-center justify-between">
                                    @if($logbook->status_sla)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold border {{ $logbook->sla_status_color }}">
                                            {{ $logbook->status_sla }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-500">Belum dihitung</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 mt-1.5">Akan diperbarui otomatis</p>
                            </div>
                        </div>

                        <div>
                            <label for="keterangan_sla" class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan SLA <span class="text-gray-400">(Opsional)</span>
                            </label>
                            <textarea id="keterangan_sla" name="keterangan_sla" rows="2"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                placeholder="Catatan tambahan tentang SLA...">{{ old('keterangan_sla', $logbook->keterangan_sla) }}</textarea>
                        </div>
                    </div>

                    <!-- Detail Teknis -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Detail Teknis</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label for="aplikasi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Aplikasi
                                </label>
                                <input id="aplikasi" type="text" name="aplikasi" value="{{ old('aplikasi', $logbook->aplikasi) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    placeholder="Nama aplikasi yang terdampak">
                            </div>

                            <div>
                                <label for="ip_server" class="block text-sm font-medium text-gray-700 mb-2">
                                    IP Server
                                </label>
                                <input id="ip_server" type="text" name="ip_server" value="{{ old('ip_server', $logbook->ip_server) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('ip_server') border-red-300 @enderror"
                                    placeholder="192.168.1.1">
                                @error('ip_server')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="tipe_insiden" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipe Insiden
                            </label>
                            <input id="tipe_insiden" type="text" name="tipe_insiden" value="{{ old('tipe_insiden', $logbook->tipe_insiden) }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="Contoh: Hardware, Software, Network">
                        </div>
                    </div>

                    <!-- Deskripsi Insiden -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Deskripsi Insiden</h3>
                        
                        <div class="space-y-5">
                            <div>
                                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Keterangan Insiden <span class="text-red-500">*</span>
                                </label>
                                <textarea id="keterangan" name="keterangan" rows="4"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none @error('keterangan') border-red-300 @enderror"
                                    placeholder="Jelaskan detail insiden yang terjadi..." required>{{ old('keterangan', $logbook->keterangan) }}</textarea>
                                @error('keterangan')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="akar_penyebab" class="block text-sm font-medium text-gray-700 mb-2">
                                    Akar Penyebab
                                </label>
                                <textarea id="akar_penyebab" name="akar_penyebab" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                    placeholder="Root cause analysis...">{{ old('akar_penyebab', $logbook->akar_penyebab) }}</textarea>
                            </div>

                            <div>
                                <label for="tindak_lanjut_detail" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tindak Lanjut Detail
                                </label>
                                <textarea id="tindak_lanjut_detail" name="tindak_lanjut_detail" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                    placeholder="Langkah-langkah tindak lanjut yang dilakukan...">{{ old('tindak_lanjut_detail', $logbook->tindak_lanjut_detail) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Penanganan -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Penanganan</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="direspon_oleh" class="block text-sm font-medium text-gray-700 mb-2">
                                    Direspon Oleh <span class="text-red-500">*</span>
                                </label>
                                <input id="direspon_oleh" type="text" name="direspon_oleh" value="{{ old('direspon_oleh', $logbook->direspon_oleh) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('direspon_oleh') border-red-300 @enderror"
                                    placeholder="Tim IT, Ahmad, Budi" required>
                                <p class="text-xs text-gray-500 mt-1.5">Pisahkan dengan koma untuk beberapa nama</p>
                                @error('direspon_oleh')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status_insiden" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status Insiden <span class="text-red-500">*</span>
                                </label>
                                <select id="status_insiden" name="status_insiden"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('status_insiden') border-red-300 @enderror"
                                    required>
                                    <option value="">Pilih status insiden</option>
                                    <option value="Open" {{ old('status_insiden', $logbook->status_insiden) == 'Open' ? 'selected' : '' }}>Open</option>
                                    <option value="On Progress" {{ old('status_insiden', $logbook->status_insiden) == 'On Progress' ? 'selected' : '' }}>On Progress</option>
                                    <option value="Closed" {{ old('status_insiden', $logbook->status_insiden) == 'Closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                                @error('status_insiden')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="p-6 bg-gray-50">
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('logbook.index') }}"
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