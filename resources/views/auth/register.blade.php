<x-guest-layout :reverse="false">
    <div class="mx-auto w-full max-w-md">
        <div class="rounded-3xl bg-white px-8 py-10 shadow-[0_20px_60px_rgba(15,23,42,0.08)]">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold uppercase tracking-wide text-gray-800">Sign Up</h1>
                <p class="mt-3 text-sm text-gray-500">Create your account and start managing your kitchen.</p>
            </div>

            <div class="space-y-6">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="name" class="mt-2 block w-full border border-gray-300 rounded-xl placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" type="text" name="name" :value="old('name')" placeholder="Your name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="email" class="mt-2 block w-full border border-gray-300 rounded-xl placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" placeholder="example@gmail.com" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="password" class="mt-2 block w-full border border-gray-300 rounded-xl placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" placeholder="********" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="password_confirmation" class="mt-2 block w-full border border-gray-300 rounded-xl placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password_confirmation" placeholder="********" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex justify-center">
                        <x-primary-button class="w-full max-w-xs bg-[#1e293b] text-white rounded-md py-3 hover:bg-gray-900 justify-center">
                            {{ __('Sign Up') }}
                        </x-primary-button>
                    </div>
                </form>

                <p class="text-center text-sm text-gray-500">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>