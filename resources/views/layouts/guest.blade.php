<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
      <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased bg-gradient-to-br from-slate-50 via-white to-slate-100">
        <div class="min-h-screen flex">
            <!-- Left Side - Branding -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-teal-300 via-teal-600 to-emerald-600 p-12 flex-col justify-between relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-slate-700/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-slate-600/20 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center space-x-3">
                        <span class="text-black text-2xl font-bold">{{ config('app.name', 'YourApp') }}</span>
                    </div>
                </div>
                
                <div class="relative z-10 space-y-6">
                    <h1 class="text-4xl font-bold text-slate-800 leading-tight">
                        Selamat Datang Kembali
                    </h1>
                    <p class="text-slate-800 text-lg leading-relaxed">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae perspiciatis recusandae reiciendis asperiores dolorem ullam aut eius. Aperiam similique non facilis temporibus vero aliquid, nobis sunt. Sunt nisi esse iure?
                    </p>
                </div>
                
                <div class="relative z-10 flex items-center space-x-8 text-slate-700 text-sm">
                    <span>© 2025 All rights reserved</span>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="flex-1 flex items-center justify-center p-8">
                <div class="w-full max-w-md">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden mb-8 text-center">
                        <div class="inline-flex items-center space-x-3">
                            <span class="text-black text-2xl font-bold">{{ config('app.name', 'YourApp') }}</span>
                        </div>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>