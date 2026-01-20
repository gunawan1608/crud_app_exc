<x-guest-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center lg:text-left">
            <h2 class="text-3xl font-bold text-slate-900">Masuk</h2>
            <p class="mt-2 text-slate-600">Masukkan kredensial Anda untuk melanjutkan</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-medium mb-2" />
                <x-text-input 
                    id="email" 
                    class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="nama@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-medium mb-2" />
                <x-text-input 
                    id="password" 
                    class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                    placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        class="w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer" 
                        name="remember">
                    <span class="ms-2 text-sm text-slate-600 select-none">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-slate-900 hover:text-slate-700 transition-colors" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <x-primary-button class="w-full justify-center px-4 py-3 bg-slate-900 hover:bg-slate-800 focus:bg-slate-800 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900">
                    {{ __('Masuk ke Akun') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-slate-500">Atau</span>
            </div>
        </div>

        <!-- Alternative Actions -->
        <div class="text-center">
            <p class="text-sm text-slate-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-medium text-slate-900 hover:text-slate-700 transition-colors">
                    Daftar sekarang
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>