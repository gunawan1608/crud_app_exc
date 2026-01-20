<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('logbook.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Data Insiden
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('logbook.update', $logbook) }}">
                        @csrf
                        @method('PUT')

                        <!-- Pelapor -->
                        <div class="mb-4">
                            <label for="pelapor" class="block font-medium text-sm text-gray-700">
                                Nama Pelapor <span class="text-red-500">*</span>
                            </label>
                            <input id="pelapor" type="text" name="pelapor" value="{{ old('pelapor', $logbook->pelapor) }}"
                                class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm mt-1 block w-full @error('pelapor') border-red-500 @enderror"
                                required autofocus>
                            @error('pelapor')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Metode Pelaporan -->
                        <div class="mb-4">
                            <label for="metode_pelaporan" class="block font-medium text-sm text-gray-700">
                                Metode Pelaporan <span class="text-red-500">*</span>
                            </label>
                            <select id="metode_pelaporan" name="metode_pelaporan"
                                class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm mt-1 block w-full @error('metode_pelaporan') border-red-500 @enderror"
                                required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="Email" {{ old('metode_pelaporan', $logbook->metode_pelaporan) == 'Email' ? 'selected' : '' }}>Email</option>
                                <option value="Telepon" {{ old('metode_pelaporan', $logbook->metode_pelaporan) == 'Telepon' ? 'selected' : '' }}>Telepon</option>
                                <option value="WhatsApp" {{ old('metode_pelaporan', $logbook->metode_pelaporan) == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                                <option value="Langsung" {{ old('metode_pelaporan', $logbook->metode_pelaporan) == 'Langsung' ? 'selected' : '' }}>Langsung</option>
                                <option value="Sistem" {{ old('metode_pelaporan', $logbook->metode_pelaporan) == 'Sistem' ? 'selected' : '' }}>Sistem</option>
                            </select>
                            @error('metode_pelaporan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Waktu Mulai dan Selesai -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="waktu_mulai" class="block font-medium text-sm text-gray-700">
                                    Waktu Mulai <span class="text-red-500">*</span>
                                </label>
                                <input id="waktu_mulai" type="datetime-local" name="waktu_mulai"
                                    value="{{ old('waktu_mulai', $logbook->waktu_mulai->format('Y-m-d\TH:i')) }}"
                                    class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm mt-1 block w-full @error('waktu_mulai') border-red-500 @enderror"
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
                                    value="{{ old('waktu_selesai', $logbook->waktu_selesai->format('Y-m-d\TH:i')) }}"
                                    class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm mt-1 block w-full @error('waktu_selesai') border-red-500 @enderror"
                                    required>
                                @error('waktu_selesai')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Downtime Info -->
                        <div class="mb-4 bg-primary-50 border-l-4 border-primary-500 p-4">
                            <div class="flex">
                                <svg class="h-5 w-5 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm text-primary-700 font-medium">Downtime saat ini: {{ $logbook->getDowntimeFormatted() }}</p>
                                    <p class="text-xs text-primary-600 mt-1">Akan dihitung ulang otomatis setelah update</p>
                                </div>
                            </div>
                        </div>

                        <!-- No Ticket -->
                        <div class="mb-4">
                            <label for="no_ticket" class="block font-medium text-sm text-gray-700">
                                No Ticket <span class="text-gray-400 text-xs">(Opsional)</span>
                            </label>
                            <input id="no_ticket" type="text" name="no_ticket" value="{{ old('no_ticket', $logbook->no_ticket) }}"
                                class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm mt-1 block w-full"
                                placeholder="Contoh: TKT-2026-001">
                        </div>

                        <!-- Direspon Oleh -->
                        <div class="mb-4">
                            <label for="direspon_oleh" class="block font-medium text-sm text-gray-700">
                                Direspon Oleh <span class="text-red-500">*</span>
                            </label>
                            <input id="direspon_oleh" type="text" name="direspon_oleh" value="{{ old('direspon_oleh', $logbook->direspon_oleh) }}"
                                class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm mt-1 block w-full @error('direspon_oleh') border-red-500 @enderror"
                                placeholder="Contoh: Tim IT, Ahmad, Budi"
                                required>
                            <p class="text-gray-500 text-xs mt-1">Pisahkan dengan koma jika lebih dari satu</p>
                            @error('direspon_oleh')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-6">
                            <label for="keterangan" class="block font-medium text-sm text-gray-700">
                                Keterangan Insiden <span class="text-red-500">*</span>
                            </label>
                            <textarea id="keterangan" name="keterangan" rows="4"
                                class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm mt-1 block w-full @error('keterangan') border-red-500 @enderror"
                                placeholder="Jelaskan detail insiden..."
                                required>{{ old('keterangan', $logbook->keterangan) }}</textarea>
                            @error('keterangan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('logbook.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
