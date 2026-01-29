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
                    <h2 class="text-2xl font-semibold text-gray-800">Tambah Insiden Infrastruktur</h2>
                    <p class="text-sm text-gray-500 mt-1">Dokumentasikan insiden infrastruktur dengan lengkap dan terstruktur</p>
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
            <div class="bg-white border border-gray-200 rounded-lg">
                <form method="POST" action="{{ route('infrastruktur.store') }}">
                    @csrf

                    <!-- 2-3. Informasi Pelapor -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">2-3. Informasi Pelapor</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="pelapor" class="block text-sm font-medium text-gray-700 mb-2">
                                    2. Pelapor <span class="text-red-500">*</span>
                                </label>
                                <input id="pelapor" type="text" name="pelapor" value="{{ old('pelapor') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('pelapor') border-red-300 @enderror"
                                    required autofocus placeholder="Nama pelapor">
                                @error('pelapor')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="metode_pelaporan" class="block text-sm font-medium text-gray-700 mb-2">
                                    3. Metode Pelaporan <span class="text-red-500">*</span>
                                </label>
                                <select id="metode_pelaporan" name="metode_pelaporan"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('metode_pelaporan') border-red-300 @enderror"
                                    required>
                                    <option value="">Pilih metode</option>
                                    <option value="Email" {{ old('metode_pelaporan') == 'Email' ? 'selected' : '' }}>Email</option>
                                    <option value="Telepon" {{ old('metode_pelaporan') == 'Telepon' ? 'selected' : '' }}>Telepon</option>
                                    <option value="WhatsApp" {{ old('metode_pelaporan') == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                                    <option value="Langsung" {{ old('metode_pelaporan') == 'Langsung' ? 'selected' : '' }}>Langsung</option>
                                    <option value="Sistem" {{ old('metode_pelaporan') == 'Sistem' ? 'selected' : '' }}>Sistem</option>
                                </select>
                                @error('metode_pelaporan')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- 4-5. Waktu & Downtime -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">4-5. Waktu Insiden</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label for="waktu_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                                    4. Waktu Mulai <span class="text-red-500">*</span>
                                </label>
                                <input id="waktu_mulai" type="datetime-local" name="waktu_mulai" value="{{ old('waktu_mulai') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('waktu_mulai') border-red-300 @enderror"
                                    required>
                                @error('waktu_mulai')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="waktu_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                    5. Waktu Selesai <span class="text-red-500">*</span>
                                </label>
                                <input id="waktu_selesai" type="datetime-local" name="waktu_selesai" value="{{ old('waktu_selesai') }}"
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
                                    <p class="text-sm font-medium text-blue-900">Perhitungan Otomatis (6-9)</p>
                                    <p class="text-xs text-blue-700 mt-1">
                                        • <strong>6. Lama Downtime (menit)</strong><br>
                                        • <strong>7. Konversi ke Jam</strong><br>
                                        • <strong>8. SLA (%)</strong> = 100 - ((jam / 8760) * 100)<br>
                                        • <strong>9. % SLA Tahunan</strong> = 100 - SLA
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 10. Keterangan SLA -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">10. Keterangan SLA</h3>

                        <div>
                            <label for="keterangan_sla" class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan SLA <span class="text-gray-400">(Opsional)</span>
                            </label>
                            <textarea id="keterangan_sla" name="keterangan_sla" rows="2"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                placeholder="Catatan tambahan tentang SLA...">{{ old('keterangan_sla') }}</textarea>
                        </div>
                    </div>

                    <!-- 11-13. Informasi Lokasi & Insiden -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">11-13. Informasi Lokasi & Insiden</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                                    11. Lokasi <span class="text-red-500">*</span>
                                </label>
                                <select id="lokasi" name="lokasi"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('lokasi') border-red-300 @enderror"
                                    required>
                                    <option value="">Pilih lokasi</option>
                                    @foreach($lokasiOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('lokasi') == $value ? 'selected' : '' }}>
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
                                    13. Tipe Insiden
                                </label>
                                <select id="tipe_insiden" name="tipe_insiden"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                    <option value="">Pilih tipe insiden</option>
                                    @foreach($tipeInsidenOptions as $tipe)
                                        <option value="{{ $tipe }}" {{ old('tipe_insiden') == $tipe ? 'selected' : '' }}>
                                            {{ $tipe }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="insiden" class="block text-sm font-medium text-gray-700 mb-2">
                                12. Nama Insiden <span class="text-red-500">*</span>
                            </label>
                            <input id="insiden" type="text" name="insiden" value="{{ old('insiden') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('insiden') border-red-300 @enderror"
                                required placeholder="Contoh: Gangguan Listrik, Kerusakan AC, dll.">
                            @error('insiden')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="no_ticket" class="block text-sm font-medium text-gray-700 mb-2">
                                17. No Ticket <span class="text-gray-400">(Jika ada)</span>
                            </label>
                            <input id="no_ticket" type="text" name="no_ticket" value="{{ old('no_ticket') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                placeholder="TKT-2026-001">
                        </div>
                    </div>

                    <!-- 14-16. Deskripsi Insiden -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">14-16. Deskripsi Insiden</h3>

                        <div class="space-y-5">
                            <div>
                                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    14. Keterangan Insiden <span class="text-red-500">*</span>
                                </label>
                                <textarea id="keterangan" name="keterangan" rows="4"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none @error('keterangan') border-red-300 @enderror"
                                    placeholder="Jelaskan detail insiden yang terjadi..." required>{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="akar_penyebab" class="block text-sm font-medium text-gray-700 mb-2">
                                    15. Akar Penyebab
                                </label>
                                <textarea id="akar_penyebab" name="akar_penyebab" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                    placeholder="Root cause analysis...">{{ old('akar_penyebab') }}</textarea>
                            </div>

                            <div>
                                <label for="tindak_lanjut_detail" class="block text-sm font-medium text-gray-700 mb-2">
                                    16. Tindak Lanjut (Detail)
                                </label>
                                <textarea id="tindak_lanjut_detail" name="tindak_lanjut_detail" rows="3"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                    placeholder="Langkah-langkah tindak lanjut yang dilakukan...">{{ old('tindak_lanjut_detail') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- 18. Penanganan (Multi-select dengan UI modern) -->
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-base font-semibold text-gray-900 mb-4">18. Penanganan</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Direspon Oleh <span class="text-red-500">*</span>
                            </label>

                            <!-- Hidden inputs for selected values -->
                            <div id="selected-responders-container"></div>

                            <!-- Custom Multi-Select UI -->
                            <div class="border border-gray-300 rounded-lg p-3 bg-white">
                                <!-- Selected Items Display -->
                                <div id="selected-items" class="flex flex-wrap gap-2 mb-3 min-h-[32px]">
                                    <span class="text-sm text-gray-400 italic" id="placeholder-text">Pilih responder...</span>
                                </div>

                                <!-- Dropdown Toggle Button -->
                                <button type="button" id="dropdown-toggle"
                                    class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm text-left hover:bg-gray-100 transition-colors flex items-center justify-between">
                                    <span class="text-gray-700">Tambah Responder</span>
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <!-- Dropdown List -->
                                <div id="responders-dropdown" class="hidden mt-2 max-h-60 overflow-y-auto border border-gray-200 rounded-lg bg-white shadow-lg">
                                    @foreach($responderOptions as $responder)
                                        <label class="flex items-center px-3 py-2.5 hover:bg-gray-50 cursor-pointer transition-colors border-b border-gray-100 last:border-b-0">
                                            <input type="checkbox" name="direspon_oleh[]" value="{{ $responder }}"
                                                class="responder-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                {{ in_array($responder, old('direspon_oleh', [])) ? 'checked' : '' }}>
                                            <span class="ml-3 text-sm text-gray-700">{{ $responder }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            @error('direspon_oleh')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1.5">Pilih satu atau lebih responder</p>
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
                                Simpan Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Multi-Select -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggle = document.getElementById('dropdown-toggle');
            const dropdown = document.getElementById('responders-dropdown');
            const selectedItemsContainer = document.getElementById('selected-items');
            const placeholderText = document.getElementById('placeholder-text');
            const checkboxes = document.querySelectorAll('.responder-checkbox');
            const hiddenContainer = document.getElementById('selected-responders-container');

            // Toggle dropdown
            dropdownToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target) && e.target !== dropdownToggle) {
                    dropdown.classList.add('hidden');
                }
            });

            // Handle checkbox changes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedItems);
            });

            // Initialize on page load (for old() values)
            updateSelectedItems();

            function updateSelectedItems() {
                const selected = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                // Clear current display
                selectedItemsContainer.innerHTML = '';

                if (selected.length === 0) {
                    placeholderText.classList.remove('hidden');
                } else {
                    placeholderText.classList.add('hidden');

                    // Create badge for each selected item
                    selected.forEach(name => {
                        const badge = document.createElement('span');
                        badge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 border border-blue-200';
                        badge.innerHTML = `
                            ${name}
                            <button type="button" class="ml-2 text-blue-600 hover:text-blue-800" onclick="removeResponder('${name}')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        `;
                        selectedItemsContainer.appendChild(badge);
                    });
                }
            }

            // Global function to remove responder
            window.removeResponder = function(name) {
                const checkbox = Array.from(checkboxes).find(cb => cb.value === name);
                if (checkbox) {
                    checkbox.checked = false;
                    updateSelectedItems();
                }
            };
        });
    </script>
</x-app-layout>
