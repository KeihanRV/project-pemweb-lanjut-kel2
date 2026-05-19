<x-guest-layout :reverse="true">
    <div class="mx-auto w-full max-w-md">
        <div class="rounded-3xl bg-white px-8 py-10 shadow-[0_20px_60px_rgba(15,23,42,0.08)]">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold uppercase tracking-wide text-gray-800">Sign In</h1>
                <p class="mt-3 text-sm text-gray-500">Welcome back! Please sign in to your account.</p>
            </div>

            <div class="space-y-6">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="email" class="mt-2 block w-full border border-gray-300 rounded-xl placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" placeholder="example@gmail.com" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="password" class="mt-2 block w-full border border-gray-300 rounded-xl placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" placeholder="********" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <label for="remember_me" class="inline-flex items-center gap-2">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span>{{ __('Remember me') }}</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-blue-500 hover:underline">{{ __('Forgot your password?') }}</a>
                        @endif
                    </div>

                    <div class="flex justify-center">
                        <x-primary-button class="w-full max-w-xs bg-[#1e293b] text-white rounded-md py-3 hover:bg-gray-900 justify-center">
                            {{ __('Sign In') }}
                        </x-primary-button>
                    </div>
                </form>

                <p class="text-center text-sm text-gray-500">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Sign up</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>