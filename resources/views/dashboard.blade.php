<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800">
                Dashboard
            </h2>
            <span class="text-sm text-gray-500">
                {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <!-- Card 1: Total Insiden -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">
                                Total Insiden
                            </p>
                            <p class="text-3xl font-semibold text-gray-900 mb-1">
                                {{ \App\Models\LogbookInsiden::count() }}
                            </p>
                            <p class="text-xs text-gray-400">Keseluruhan data</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Bulan Ini -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">
                                Bulan Ini
                            </p>
                            <p class="text-3xl font-semibold text-gray-900 mb-1">
                                {{ \App\Models\LogbookInsiden::whereMonth('created_at', now()->month)->count() }}
                            </p>
                            <p class="text-xs text-gray-400">{{ now()->locale('id')->isoFormat('MMMM YYYY') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Total Downtime -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">
                                Total Downtime
                            </p>
                            @php
                                $totalMenit = \App\Models\LogbookInsiden::sum('downtime_menit');
                                $jam = floor($totalMenit / 60);
                                $menit = $totalMenit % 60;
                            @endphp
                            <p class="text-3xl font-semibold text-gray-900 mb-1">
                                {{ $jam }}<span class="text-xl text-gray-500">j</span> {{ $menit }}<span class="text-xl text-gray-500">m</span>
                            </p>
                            <p class="text-xs text-gray-400">Akumulasi waktu</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Main Content Area -->
            <div class="bg-white border border-gray-200 rounded-lg">
                
                <!-- Header Section -->
                <div class="border-b border-gray-200 px-8 py-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                        Sistem Manajemen Logbook Insiden
                    </h3>
                    <p class="text-sm text-gray-500">
                        Platform terpusat untuk dokumentasi dan monitoring insiden aplikasi
                    </p>
                </div>

                <!-- Quick Actions -->
                <div class="px-8 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Action Card 1 -->
                        <a href="{{ route('logbook.index') }}" 
                           class="group block p-6 border border-gray-200 rounded-lg hover:border-green-300 hover:shadow-sm transition-all duration-200">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                    <span class="text-gray-600 font-semibold">≡</span>
                                </div>
                                <span class="text-gray-400 group-hover:text-green-600 transition-colors">→</span>
                            </div>
                            <h4 class="text-base font-semibold text-gray-900 mb-2">
                                Lihat Data Insiden
                            </h4>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                Akses daftar lengkap insiden yang telah terdokumentasi dengan filter dan pencarian lanjutan
                            </p>
                        </a>

                        <!-- Action Card 2 -->
                        <a href="{{ route('logbook.create') }}" 
                           class="group block p-6 border border-gray-200 rounded-lg hover:border-blue-300 hover:shadow-sm transition-all duration-200 bg-gradient-to-br from-white to-blue-50/30">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                    <span class="text-blue-600 font-semibold text-lg">+</span>
                                </div>
                                <span class="text-blue-400 group-hover:text-blue-600 transition-colors">→</span>
                            </div>
                            <h4 class="text-base font-semibold text-gray-900 mb-2">
                                Tambah Insiden Baru
                            </h4>
                            <p class="text-sm text-gray-500 leading-relaxed">
                                Dokumentasikan insiden baru dengan formulir terstruktur untuk tracking yang lebih efektif
                            </p>
                        </a>

                    </div>
                </div>

                <!-- Footer Info -->
                <div class="border-t border-gray-200 px-8 py-4 bg-gray-50/50">
                    <p class="text-xs text-gray-500 text-center">
                        Sistem ini dirancang untuk meningkatkan transparansi dan responsivitas dalam penanganan insiden aplikasi
                    </p>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>