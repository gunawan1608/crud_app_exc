<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('hak-akses-server.index') }}"
                    class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">Tambah Hak Akses Server</h2>
                    <p class="text-sm text-gray-500 mt-1">Dokumentasikan hak akses server dengan lengkap</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-lg">
                <form method="POST" action="{{ route('hak-akses-server.store') }}">
                    @csrf

                    <!-- SERVER INFO -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Informasi Server</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="ip_host_server" class="block text-sm font-medium text-gray-700 mb-2">
                                    IP Host Server <span class="text-red-500">*</span>
                                </label>
                                <select id="ip_host_server" name="ip_host_server"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('ip_host_server') border-red-300 @enderror"
                                    required>
                                    <option value="">Pilih IP Host Server</option>
                                    @foreach ($ipHostOptions as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('ip_host_server') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ip_host_server')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="lingkungan_server" class="block text-sm font-medium text-gray-700 mb-2">
                                    Lingkungan Server <span class="text-red-500">*</span>
                                </label>
                                <select id="lingkungan_server" name="lingkungan_server"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('lingkungan_server') border-red-300 @enderror"
                                    required>
                                    <option value="">Pilih lingkungan</option>
                                    @foreach ($lingkunganOptions as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('lingkungan_server') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lingkungan_server')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="nama_server" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Server <span class="text-red-500">*</span>
                                </label>
                                <input id="nama_server" type="text" name="nama_server"
                                    value="{{ old('nama_server') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nama_server') border-red-300 @enderror"
                                    required placeholder="BSN-UBUNTU-PROD-ESIGN">
                                @error('nama_server')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- IP SERVER -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">IP Server</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="ip_local" class="block text-sm font-medium text-gray-700 mb-2">
                                    IP Local
                                </label>
                                <input id="ip_local" type="text" name="ip_local" value="{{ old('ip_local') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('ip_local') border-red-300 @enderror"
                                    placeholder="10.10.3.15">
                                @error('ip_local')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="ip_public" class="block text-sm font-medium text-gray-700 mb-2">
                                    IP Public
                                </label>
                                <input id="ip_public" type="text" name="ip_public" value="{{ old('ip_public') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-mono focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('ip_public') border-red-300 @enderror"
                                    placeholder="202.43.168.180">
                                @error('ip_public')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- APLIKASI & KATEGORI -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Aplikasi & Kategori</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="aplikasi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Aplikasi <span class="text-red-500">*</span>
                                </label>
                                <input id="aplikasi" type="text" name="aplikasi" value="{{ old('aplikasi') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('aplikasi') border-red-300 @enderror"
                                    required placeholder="hadir.bsn.go.id">
                                @error('aplikasi')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kategori_sistem_elektronik" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kategori Sistem Elektronik <span class="text-red-500">*</span>
                                </label>
                                <select id="kategori_sistem_elektronik" name="kategori_sistem_elektronik"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('kategori_sistem_elektronik') border-red-300 @enderror"
                                    required>
                                    <option value="">Pilih kategori</option>
                                    @foreach ($kategoriOptions as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('kategori_sistem_elektronik') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_sistem_elektronik')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="role_hak_akses" class="block text-sm font-medium text-gray-700 mb-2">
                                    Role Hak Akses <span class="text-red-500">*</span>
                                </label>
                                <select id="role_hak_akses" name="role_hak_akses"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('role_hak_akses') border-red-300 @enderror"
                                    required>
                                    <option value="">Pilih role</option>
                                    @foreach ($roleOptions as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('role_hak_akses') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_hak_akses')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- HAK AKSES DETAIL -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Detail Hak Akses</h3>

                        <div class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="akun" class="block text-sm font-medium text-gray-700 mb-2">
                                        Akun <span class="text-red-500">*</span>
                                    </label>
                                    <input id="akun" type="text" name="akun" value="{{ old('akun') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('akun') border-red-300 @enderror"
                                        required placeholder="Adlin">
                                    @error('akun')
                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="pemilik_hak_akses" class="block text-sm font-medium text-gray-700 mb-2">
                                        Pemilik Hak Akses <span class="text-red-500">*</span>
                                    </label>
                                    <input id="pemilik_hak_akses" type="text" name="pemilik_hak_akses"
                                        value="{{ old('pemilik_hak_akses') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('pemilik_hak_akses') border-red-300 @enderror"
                                        required placeholder="TIM SI">
                                    @error('pemilik_hak_akses')
                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="hak_akses" class="block text-sm font-medium text-gray-700 mb-2">
                                    Hak Akses <span class="text-red-500">*</span>
                                </label>
                                <input id="hak_akses" type="text" name="hak_akses" value="{{ old('hak_akses') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('hak_akses') border-red-300 @enderror"
                                    required placeholder="/var/www/html/hadir">
                                @error('hak_akses')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select id="status" name="status"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('status') border-red-300 @enderror"
                                        required>
                                        @foreach ($statusOptions as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ old('status', 'Aktif') == $value ? 'selected' : '' }}>
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
                                    Keterangan
                                </label>
                                <textarea id="keterangan" name="keterangan" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                    placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="p-6 bg-gray-50">
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('hak-akses-server.index') }}"
                                class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
