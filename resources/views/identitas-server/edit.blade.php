<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('identitas-server.index') }}"
                   class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">Edit Data Server</h2>
                    <p class="text-sm text-gray-500 mt-1">Perbarui informasi server yang telah terdokumentasi</p>
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
                        <p class="text-xs text-gray-600 mb-1">No Urut</p>
                        <p class="text-lg font-semibold text-blue-700">{{ $identitasServer->no }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-blue-100">
                        <p class="text-xs text-gray-600 mb-1">Nama Server</p>
                        <p class="text-sm font-semibold text-blue-700">{{ $identitasServer->nama_server }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-blue-100">
                        <p class="text-xs text-gray-600 mb-1">Lingkungan</p>
                        <p class="text-sm font-semibold text-blue-700">{{ $identitasServer->lingkungan_server }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-blue-100">
                        <p class="text-xs text-gray-600 mb-1">Status</p>
                        <p class="text-sm font-semibold {{ $identitasServer->status === 'Aktif' ? 'text-green-700' : 'text-red-700' }}">
                            {{ $identitasServer->status }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg">
                <form method="POST" action="{{ route('identitas-server.update', $identitasServer) }}">
                    @csrf
                    @method('PUT')

                    <!-- 2-5. SERVER INFO -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">2-5. Informasi Server</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="no" class="block text-sm font-medium text-gray-700 mb-2">
                                    2. No Urut <span class="text-red-500">*</span>
                                </label>
                                <input id="no" type="number" name="no" value="{{ old('no', $identitasServer->no) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('no') border-red-300 @enderror"
                                    required>
                                @error('no')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ip_host_server" class="block text-sm font-medium text-gray-700 mb-2">
                                    3. IP Host Server <span class="text-red-500">*</span>
                                </label>
                                <input id="ip_host_server" type="text" name="ip_host_server" value="{{ old('ip_host_server', $identitasServer->ip_host_server) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('ip_host_server') border-red-300 @enderror"
                                    required>
                                @error('ip_host_server')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nama_server" class="block text-sm font-medium text-gray-700 mb-2">
                                    4. Nama Server <span class="text-red-500">*</span>
                                </label>
                                <input id="nama_server" type="text" name="nama_server" value="{{ old('nama_server', $identitasServer->nama_server) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nama_server') border-red-300 @enderror"
                                    required>
                                @error('nama_server')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="lingkungan_server" class="block text-sm font-medium text-gray-700 mb-2">
                                    5. Lingkungan Server <span class="text-red-500">*</span>
                                </label>
                                <select id="lingkungan_server" name="lingkungan_server"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('lingkungan_server') border-red-300 @enderror"
                                    required>
                                    @foreach($lingkunganOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('lingkungan_server', $identitasServer->lingkungan_server) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lingkungan_server')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- 6-7. IP SERVER -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">6-7. IP Server</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="ip_local" class="block text-sm font-medium text-gray-700 mb-2">
                                    6. IP Local
                                </label>
                                <input id="ip_local" type="text" name="ip_local" value="{{ old('ip_local', $identitasServer->ip_local) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('ip_local') border-red-300 @enderror">
                                @error('ip_local')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ip_public" class="block text-sm font-medium text-gray-700 mb-2">
                                    7. IP Public
                                </label>
                                <input id="ip_public" type="text" name="ip_public" value="{{ old('ip_public', $identitasServer->ip_public) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('ip_public') border-red-300 @enderror">
                                @error('ip_public')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- 8-11. SYSTEM SPECS -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">8-11. Spesifikasi Sistem</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label for="os" class="block text-sm font-medium text-gray-700 mb-2">
                                    8. Operating System
                                </label>
                                <input id="os" type="text" name="os" value="{{ old('os', $identitasServer->os) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label for="ram_gb" class="block text-sm font-medium text-gray-700 mb-2">
                                    9. RAM (GB)
                                </label>
                                <input id="ram_gb" type="number" name="ram_gb" value="{{ old('ram_gb', $identitasServer->ram_gb) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label for="virtual_socket" class="block text-sm font-medium text-gray-700 mb-2">
                                    10. Virtual Socket
                                </label>
                                <input id="virtual_socket" type="number" name="virtual_socket" value="{{ old('virtual_socket', $identitasServer->virtual_socket) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label for="core_per_socket" class="block text-sm font-medium text-gray-700 mb-2">
                                    11. Core per Socket
                                </label>
                                <input id="core_per_socket" type="number" name="core_per_socket" value="{{ old('core_per_socket', $identitasServer->core_per_socket) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            </div>
                        </div>
                    </div>

                    <!-- 12-17. STORAGE & SOFTWARE -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">12-17. Storage & Software</h3>

                        <div class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="harddisk_gb" class="block text-sm font-medium text-gray-700 mb-2">
                                        12. Harddisk (GB)
                                    </label>
                                    <input id="harddisk_gb" type="number" name="harddisk_gb" value="{{ old('harddisk_gb', $identitasServer->harddisk_gb) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                </div>

                                <div>
                                    <label for="versi_php" class="block text-sm font-medium text-gray-700 mb-2">
                                        13. Versi PHP
                                    </label>
                                    <input id="versi_php" type="text" name="versi_php" value="{{ old('versi_php', $identitasServer->versi_php) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                </div>

                                <div>
                                    <label for="av_bitdefender" class="block text-sm font-medium text-gray-700 mb-2">
                                        14. Antivirus BitDefender
                                    </label>
                                    <select id="av_bitdefender" name="av_bitdefender"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        <option value="">Pilih status</option>
                                        @foreach($avOptions as $value => $label)
                                            <option value="{{ $value }}" {{ old('av_bitdefender', $identitasServer->av_bitdefender) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="administrator" class="block text-sm font-medium text-gray-700 mb-2">
                                        15. Administrator
                                    </label>
                                    <input id="administrator" type="text" name="administrator" value="{{ old('administrator', $identitasServer->administrator) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                        16. Status <span class="text-red-500">*</span>
                                    </label>
                                    <select id="status" name="status"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('status') border-red-300 @enderror"
                                        required>
                                        @foreach($statusOptions as $value => $label)
                                            <option value="{{ $value }}" {{ old('status', $identitasServer->status) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    17. Keterangan
                                </label>
                                <textarea id="keterangan" name="keterangan" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ old('keterangan', $identitasServer->keterangan) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="p-6 bg-gray-50">
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('identitas-server.index') }}"
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
