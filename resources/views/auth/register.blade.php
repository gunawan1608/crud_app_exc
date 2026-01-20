<x-guest-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center lg:text-left">
            <h2 class="text-3xl font-bold text-slate-900">Buat Akun</h2>
            <p class="mt-2 text-slate-600">Daftar untuk memulai perjalanan Anda</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-medium mb-2" />
                <x-text-input 
                    id="name" 
                    class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all" 
                    type="text" 
                    name="name" 
                    :value="old('name')" 
                    required 
                    autofocus 
                    autocomplete="name"
                    placeholder="John Doe" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

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
                    autocomplete="new-password"
                    placeholder="Minimal 8 karakter" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-slate-700 font-medium mb-2" />
                <x-text-input 
                    id="password_confirmation" 
                    class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all"
                    type="password"
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password"
                    placeholder="Ulangi password Anda" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Terms & Conditions (Optional) -->
            <div class="pt-2">
                <label class="flex items-start cursor-pointer">
                    <input 
                        type="checkbox" 
                        class="w-4 h-4 mt-1 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer" 
                        required>
                    <span class="ms-2 text-sm text-slate-600 select-none">
                        Saya setuju dengan 
                        <a href="#" class="font-medium text-slate-900 hover:text-slate-700 transition-colors">Syarat & Ketentuan</a> 
                        dan 
                        <a href="#" class="font-medium text-slate-900 hover:text-slate-700 transition-colors">Kebijakan Privasi</a>
                    </span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <x-primary-button class="w-full justify-center px-4 py-3 bg-slate-900 hover:bg-slate-800 focus:bg-slate-800 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900">
                    {{ __('Daftar Sekarang') }}
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
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-medium text-slate-900 hover:text-slate-700 transition-colors">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>