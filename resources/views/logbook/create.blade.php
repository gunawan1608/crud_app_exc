<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('logbook.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tambah Insiden Baru
                </h2>
            </div>

            <!-- Info SLA Tahunan -->
            <div class="bg-blue-50 px-4 py-2 rounded-lg border border-blue-200">
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-medium text-blue-700">SLA Tahunan Saat Ini:</span>
                    <span class="text-lg font-bold text-blue-900">{{ number_format($slaTahunan, 2) }}%</span>
                    <span class="text-xs text-blue-600">(Target: {{ $targetSla }}%)</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('logbook.store') }}">
                        @csrf

                        <!-- Informasi Pelapor -->
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-green-700 mb-4">Informasi Pelapor</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="pelapor" class="block font-medium text-sm text-gray-700">
                                        Nama Pelapor <span class="text-red-500">*</span>
                                    </label>
                                    <input id="pelapor" type="text" name="pelapor" value="{{ old('pelapor') }}"
                                        class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full @error('pelapor') border-red-500 @enderror"
                                        required autofocus>
                                    @error('pelapor')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="metode_pelaporan" class="block font-medium text-sm text-gray-700">
                                        Metode Pelaporan <span class="text-red-500">*</span>
                                    </label>
                                    <select id="metode_pelaporan" name="metode_pelaporan"
                                        class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full @error('metode_pelaporan') border-red-500 @enderror"
                                        required>
                                        <option value="">-- Pilih Metode --</option>
                                        <option value="Email" {{ old('metode_pelaporan') == 'Email' ? 'selected' : '' }}>Email</option>
                                        <option value="Telepon" {{ old('metode_pelaporan') == 'Telepon' ? 'selected' : '' }}>Telepon</option>
                                        <option value="WhatsApp" {{ old('metode_pelaporan') == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                                        <option value="Langsung" {{ old('metode_pelaporan') == 'Langsung' ? 'selected' : '' }}>Langsung</option>
                                        <option value="Sistem" {{ old('metode_pelaporan') == 'Sistem' ? 'selected' : '' }}>Sistem</option>
                                    </select>
                                    @error('metode_pelaporan')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Waktu & Downtime -->
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-green-700 mb-4">Waktu & Downtime</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="waktu_mulai" class="block font-medium text-sm text-gray-700">
                                        Waktu Mulai <span class="text-red-500">*</span>
                                    </label>
                                    <input id="waktu_mulai" type="datetime-local" name="waktu_mulai"
                                        value="{{ old('waktu_mulai') }}"
                                        class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full @error('waktu_mulai') border-red-500 @enderror"
                                        required>
                                    @error('waktu_mulai')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="waktu_selesai" class="block font-medium text-sm text-gray-700">
                                        Waktu Selesai <span class="text-red-500">*</span>
                                    </label>
                                    <input id="waktu_selesai" type="datetime-local" name="waktu_selesai"
                                        value="{{ old('waktu_selesai') }}"
                                        class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full @error('waktu_selesai') border-red-500 @enderror"
                                        required>
                                    @error('waktu_selesai')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="keterangan_waktu_selesai" class="block font-medium text-sm text-gray-700">
                                    Keterangan Waktu Selesai
                                </label>
                                <textarea id="keterangan_waktu_selesai" name="keterangan_waktu_selesai" rows="2"
                                    class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full"
                                    placeholder="Catatan tambahan tentang waktu penyelesaian...">{{ old('keterangan_waktu_selesai') }}</textarea>
                            </div>

                            <div class="bg-green-50 border-l-4 border-green-500 p-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-sm text-green-700 font-medium">Downtime dan SLA akan dihitung otomatis</p>
                                        <p class="text-xs text-green-600 mt-1">Sistem akan menghitung: Downtime (menit & jam), SLA Biasa, dan kontribusi ke SLA Tahunan</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SLA Configuration -->
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-green-700 mb-4">Konfigurasi SLA</h3>

                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                <h4 class="font-semibold text-blue-900 mb-3">📋 Informasi SLA (Auto-Calculate)</h4>
                                <div class="space-y-2 text-sm text-blue-800">
                                    <p>✓ <strong>SLA Per Kejadian</strong> = Dihitung otomatis dari downtime (rumus Excel)</p>
                                    <p>✓ <strong>SLA Tahunan</strong> = Akumulasi dari semua SLA per kejadian</p>
                                    <p>✓ <strong>Status SLA</strong> = Otomatis berdasarkan Target SLA yang Anda input</p>
                                    <p class="text-xs text-blue-600 mt-2 font-medium">⚠️ User HANYA menginput: Downtime dan Target SLA</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="target_sla" class="block font-medium text-sm text-gray-700">
                                        Target SLA (%) <span class="text-red-500">*</span>
                                    </label>
                                    <input id="target_sla" type="number" step="0.01" name="target_sla"
                                        value="{{ old('target_sla', 98.00) }}"
                                        class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full"
                                        placeholder="98.00" required>
                                    <p class="text-xs text-gray-500 mt-1">Target SLA sebagai pembanding (standar: 98%)</p>
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700 mb-1">
                                        Status SLA (Otomatis)
                                    </label>
                                    <div class="bg-gray-100 border border-gray-300 rounded-md px-4 py-3 text-sm text-gray-500">
                                        Akan dihitung otomatis oleh sistem
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Berdasarkan perbandingan SLA Tahunan dengan Target</p>
                                </div>
                            </div>

                            <div>
                                <label for="keterangan_sla" class="block font-medium text-sm text-gray-700">
                                    Keterangan SLA (Opsional)
                                </label>
                                <textarea id="keterangan_sla" name="keterangan_sla" rows="2"
                                    class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full"
                                    placeholder="Catatan tambahan tentang SLA...">{{ old('keterangan_sla') }}</textarea>
                            </div>
                        </div>

                        <!-- Detail Teknis -->
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-green-700 mb-4">Detail Teknis</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="aplikasi" class="block font-medium text-sm text-gray-700">
                                        Aplikasi
                                    </label>
                                    <input id="aplikasi" type="text" name="aplikasi"
                                        value="{{ old('aplikasi') }}"
                                        class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full"
                                        placeholder="Nama aplikasi yang terdampak">
                                </div>

                                <div>
                                    <label for="ip_server" class="block font-medium text-sm text-gray-700">
                                        IP Server
                                    </label>
                                    <input id="ip_server" type="text" name="ip_server"
                                        value="{{ old('ip_server') }}"
                                        class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full"
                                        placeholder="192.168.1.1">
                                    @error('ip_server')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="tipe_insiden" class="block font-medium text-sm text-gray-700">
                                    Tipe Insiden
                                </label>
                                <input id="tipe_insiden" type="text" name="tipe_insiden"
                                    value="{{ old('tipe_insiden') }}"
                                    class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full"
                                    placeholder="Contoh: Hardware, Software, Network">
                            </div>
                        </div>

                        <!-- Deskripsi Insiden -->
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-green-700 mb-4">Deskripsi Insiden</h3>

                            <div class="mb-4">
                                <label for="keterangan" class="block font-medium text-sm text-gray-700">
                                    Keterangan Insiden <span class="text-red-500">*</span>
                                </label>
                                <textarea id="keterangan" name="keterangan" rows="4"
                                    class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full @error('keterangan') border-red-500 @enderror"
                                    placeholder="Jelaskan detail insiden yang terjadi..." required>{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="akar_penyebab" class="block font-medium text-sm text-gray-700">
                                    Akar Penyebab
                                </label>
                                <textarea id="akar_penyebab" name="akar_penyebab" rows="3"
                                    class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full"
                                    placeholder="Root cause analysis...">{{ old('akar_penyebab') }}</textarea>
                            </div>

                            <div>
                                <label for="tindak_lanjut_detail" class="block font-medium text-sm text-gray-700">
                                    Tindak Lanjut Detail
                                </label>
                                <textarea id="tindak_lanjut_detail" name="tindak_lanjut_detail" rows="3"
                                    class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full"
                                    placeholder="Langkah-langkah tindak lanjut yang dilakukan...">{{ old('tindak_lanjut_detail') }}</textarea>
                            </div>
                        </div>

                        <!-- Penanganan -->
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-green-700 mb-4">Penanganan</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="direspon_oleh" class="block font-medium text-sm text-gray-700">
                                        Direspon Oleh <span class="text-red-500">*</span>
                                    </label>
                                    <input id="direspon_oleh" type="text" name="direspon_oleh"
                                        value="{{ old('direspon_oleh') }}"
                                        class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full @error('direspon_oleh') border-red-500 @enderror"
                                        placeholder="Tim IT, Ahmad, Budi" required>
                                    <p class="text-gray-500 text-xs mt-1">Pisahkan dengan koma jika lebih dari satu</p>
                                    @error('direspon_oleh')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status_insiden" class="block font-medium text-sm text-gray-700">
                                        Status Insiden <span class="text-red-500">*</span>
                                    </label>
                                    <select id="status_insiden" name="status_insiden"
                                        class="border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm mt-1 block w-full @error('status_insiden') border-red-500 @enderror"
                                        required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Open" {{ old('status_insiden') == 'Open' ? 'selected' : '' }}>Open</option>
                                        <option value="On Progress" {{ old('status_insiden') == 'On Progress' ? 'selected' : '' }}>On Progress</option>
                                        <option value="Closed" {{ old('status_insiden') == 'Closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    @error('status_insiden')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('logbook.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
