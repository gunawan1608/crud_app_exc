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

            <!-- Summary Cards - Logbook Insiden -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Logbook Insiden Aplikasi</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Card 1: Total Insiden -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">
                                    Total Insiden
                                </p>
                                <p class="text-3xl font-semibold text-gray-900 mb-1">
                                    {{ $totalInsidenAplikasi }}
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
                                    {{ $bulanIniAplikasi }}
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
                                    $jam = floor($downtimeAplikasi / 60);
                                    $menit = $downtimeAplikasi % 60;
                                @endphp
                                <p class="text-3xl font-semibold text-gray-900 mb-1">
                                    {{ $jam }}<span class="text-xl text-gray-500">j</span> {{ $menit }}<span class="text-xl text-gray-500">m</span>
                                </p>
                                <p class="text-xs text-gray-400">Akumulasi waktu</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Summary Cards - Infrastruktur -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Logbook Insiden Infrastruktur</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Card 1: Total Insiden -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">
                                    Total Insiden
                                </p>
                                <p class="text-3xl font-semibold text-gray-900 mb-1">
                                    {{ $totalInsidenInfrastruktur }}
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
                                    {{ $bulanIniInfrastruktur }}
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
                                    $jamInfra = floor($downtimeInfrastruktur / 60);
                                    $menitInfra = $downtimeInfrastruktur % 60;
                                @endphp
                                <p class="text-3xl font-semibold text-gray-900 mb-1">
                                    {{ $jamInfra }}<span class="text-xl text-gray-500">j</span> {{ $menitInfra }}<span class="text-xl text-gray-500">m</span>
                                </p>
                                <p class="text-xs text-gray-400">Akumulasi waktu</p>
                            </div>
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
                        Platform terpusat untuk dokumentasi dan monitoring insiden aplikasi & infrastruktur
                    </p>
                </div>

                <!-- Quick Actions -->
                <div class="px-8 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Action Card 1 - Logbook Insiden -->
                        <div class="border border-gray-200 rounded-lg p-1 hover:border-green-300 hover:shadow-sm transition-all duration-200">
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-md p-5">
                                <h4 class="text-base font-semibold text-gray-900 mb-3">
                                    📱 Logbook Insiden Aplikasi
                                </h4>
                                <p class="text-sm text-gray-600 mb-4">
                                    Kelola insiden aplikasi dengan tracking SLA dan downtime otomatis
                                </p>
                                <div class="flex gap-3">
                                    <a href="{{ route('logbook.index') }}"
                                       class="flex-1 text-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                        Lihat Data
                                    </a>
                                    <a href="{{ route('logbook.create') }}"
                                       class="flex-1 text-center px-4 py-2 bg-green-600 rounded-lg text-sm font-medium text-white hover:bg-green-700 transition-colors">
                                        + Tambah
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Action Card 2 - Infrastruktur -->
                        <div class="border border-gray-200 rounded-lg p-1 hover:border-blue-300 hover:shadow-sm transition-all duration-200">
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-md p-5">
                                <h4 class="text-base font-semibold text-gray-900 mb-3">
                                    🖥️ Logbook Insiden Infrastruktur
                                </h4>
                                <p class="text-sm text-gray-600 mb-4">
                                    Monitor insiden infrastruktur IT dengan lokasi & multi-responder
                                </p>
                                <div class="flex gap-3">
                                    <a href="{{ route('infrastruktur.index') }}"
                                       class="flex-1 text-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                                        Lihat Data
                                    </a>
                                    <a href="{{ route('infrastruktur.create') }}"
                                       class="flex-1 text-center px-4 py-2 bg-blue-600 rounded-lg text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                                        + Tambah
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Footer Info -->
                <div class="border-t border-gray-200 px-8 py-4 bg-gray-50/50">
                    <p class="text-xs text-gray-500 text-center">
                        Sistem ini dirancang untuk meningkatkan transparansi dan responsivitas dalam penanganan insiden aplikasi & infrastruktur IT
                    </p>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
