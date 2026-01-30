<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('catatan-soc.index') }}"
                   class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">Tambah Catatan SOC</h2>
                    <p class="text-sm text-gray-500 mt-1">Dokumentasikan kegiatan Security Operations Center</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200 rounded-lg">
                <form method="POST" action="{{ route('catatan-soc.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Jadwal Pelaksanaan -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Jadwal Pelaksanaan</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="hari_tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                                    Hari, Tanggal <span class="text-red-500">*</span>
                                </label>
                                <input id="hari_tanggal" type="date" name="hari_tanggal" value="{{ old('hari_tanggal') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('hari_tanggal') border-red-300 @enderror"
                                    required>
                                @error('hari_tanggal')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="waktu" class="block text-sm font-medium text-gray-700 mb-2">
                                    Waktu
                                </label>
                                <input id="waktu" type="text" name="waktu" value="{{ old('waktu') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    placeholder="Contoh: 7.30 s/d 16.00">
                            </div>
                        </div>
                    </div>

                    <!-- Penanggung Jawab & Pelaksana -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Penanggung Jawab & Pelaksana</h3>

                        <div class="mb-5">
                            <label for="penanggung_jawab" class="block text-sm font-medium text-gray-700 mb-2">
                                Penanggung Jawab <span class="text-red-500">*</span>
                            </label>
                            <select id="penanggung_jawab" name="penanggung_jawab"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('penanggung_jawab') border-red-300 @enderror"
                                required>
                                <option value="">Pilih penanggung jawab</option>
                                @foreach($penanggungJawabOptions as $pj)
                                    <option value="{{ $pj }}" {{ old('penanggung_jawab') == $pj ? 'selected' : '' }}>
                                        {{ $pj }}
                                    </option>
                                @endforeach
                            </select>
                            @error('penanggung_jawab')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pelaksana <span class="text-red-500">*</span>
                            </label>

                            <!-- Custom Multi-Select UI -->
                            <div class="border border-gray-300 rounded-lg p-3 bg-white">
                                <!-- Selected Items Display -->
                                <div id="selected-items" class="flex flex-wrap gap-2 mb-3 min-h-[32px]">
                                    <span class="text-sm text-gray-400 italic" id="placeholder-text">Pilih pelaksana...</span>
                                </div>

                                <!-- Dropdown Toggle Button -->
                                <button type="button" id="dropdown-toggle"
                                    class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm text-left hover:bg-gray-100 transition-colors flex items-center justify-between">
                                    <span class="text-gray-700">Tambah Pelaksana</span>
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <!-- Dropdown List -->
                                <div id="pelaksana-dropdown" class="hidden mt-2 max-h-60 overflow-y-auto border border-gray-200 rounded-lg bg-white shadow-lg">
                                    @foreach($pelaksanaOptions as $pelaksana)
                                        <label class="flex items-center px-3 py-2.5 hover:bg-gray-50 cursor-pointer transition-colors border-b border-gray-100 last:border-b-0">
                                            <input type="checkbox" name="pelaksana[]" value="{{ $pelaksana }}"
                                                class="pelaksana-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                {{ in_array($pelaksana, old('pelaksana', [])) ? 'checked' : '' }}>
                                            <span class="ml-3 text-sm text-gray-700">{{ $pelaksana }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            @error('pelaksana')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1.5">Pilih satu atau lebih pelaksana</p>
                        </div>
                    </div>

                    <!-- To Do List -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">To Do List</h3>

                        <div class="space-y-5">
                            <div>
                                <label for="to_do_list" class="block text-sm font-medium text-gray-700 mb-2">
                                    Daftar Kegiatan <span class="text-red-500">*</span>
                                </label>
                                <textarea id="to_do_list" name="to_do_list" rows="6"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none @error('to_do_list') border-red-300 @enderror"
                                    placeholder="Contoh:&#10;- Melakukan pengecekan WLC Mampang&#10;- Melakukan pengecekan SNSU 1&#10;- Melakukan pengecekan Sophos SNSU 1" required>{{ old('to_do_list') }}</textarea>
                                @error('to_do_list')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                                    Upload Gambar <span class="text-gray-400">(Opsional)</span>
                                </label>
                                <input id="gambar" type="file" name="gambar" accept="image/*"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-xs text-gray-500 mt-1.5">Format: JPG, PNG, GIF (Max 5MB)</p>
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

                    <!-- Terjadi Insiden -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">Terjadi Insiden</h3>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Apakah terjadi insiden/anomali hari ini? <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-6">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="terjadi_insiden" value="ya" 
                                            class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                            {{ old('terjadi_insiden') == 'ya' ? 'checked' : '' }}
                                            onchange="toggleKeteranganInsiden(true)">
                                        <span class="ml-2 text-sm text-gray-700">Ya</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer">
                                        <input type="radio" name="terjadi_insiden" value="tidak" 
                                            class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                            {{ old('terjadi_insiden', 'tidak') == 'tidak' ? 'checked' : '' }}
                                            onchange="toggleKeteranganInsiden(false)">
                                        <span class="ml-2 text-sm text-gray-700">Tidak</span>
                                    </label>
                                </div>
                            </div>

                            <div id="keterangan-insiden-container" class="hidden">
                                <label for="keterangan_insiden" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jika ya, jelaskan
                                </label>
                                <textarea id="keterangan_insiden" name="keterangan_insiden" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                    placeholder="Jelaskan detail insiden yang terjadi...">{{ old('keterangan_insiden') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="p-6 bg-gray-50">
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('catatan-soc.index') }}"
                                class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Multi-Select and Insiden Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Multi-select functionality
            const dropdownToggle = document.getElementById('dropdown-toggle');
            const dropdown = document.getElementById('pelaksana-dropdown');
            const selectedItemsContainer = document.getElementById('selected-items');
            const placeholderText = document.getElementById('placeholder-text');
            const checkboxes = document.querySelectorAll('.pelaksana-checkbox');

            dropdownToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target) && e.target !== dropdownToggle) {
                    dropdown.classList.add('hidden');
                }
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedItems);
            });

            updateSelectedItems();

            function updateSelectedItems() {
                const selected = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                selectedItemsContainer.innerHTML = '';

                if (selected.length === 0) {
                    placeholderText.classList.remove('hidden');
                } else {
                    placeholderText.classList.add('hidden');

                    selected.forEach(name => {
                        const badge = document.createElement('span');
                        badge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 border border-blue-200';
                        badge.innerHTML = `
                            ${name}
                            <button type="button" class="ml-2 text-blue-600 hover:text-blue-800" onclick="removePelaksana('${name}')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        `;
                        selectedItemsContainer.appendChild(badge);
                    });
                }
            }

            window.removePelaksana = function(name) {
                const checkbox = Array.from(checkboxes).find(cb => cb.value === name);
                if (checkbox) {
                    checkbox.checked = false;
                    updateSelectedItems();
                }
            };

            // Toggle keterangan insiden
            window.toggleKeteranganInsiden = function(show) {
                const container = document.getElementById('keterangan-insiden-container');
                if (show) {
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            };

            // Initialize on load
            const insidenYa = document.querySelector('input[name="terjadi_insiden"][value="ya"]');
            if (insidenYa && insidenYa.checked) {
                toggleKeteranganInsiden(true);
            }
        });
    </script>
</x-app-layout>