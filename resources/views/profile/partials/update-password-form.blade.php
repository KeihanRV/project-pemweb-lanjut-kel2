<section>
    <header>
        <h2 class="text-3xl font-medium text-whitest">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-tertiary">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        <div class="bg-primary p-6 rounded-lg space-y-4">
            <div>
                <label for="update_password_current_password" class="block text-sm font-medium text-white">{{ __('Current Password') }}</label>
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full bg-whitest text-primary rounded-md" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-sm text-red-400" />
            </div>

            <div>
                <label for="update_password_password" class="block text-sm font-medium text-white">{{ __('New Password') }}</label>
                <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full bg-whitest text-primary rounded-md" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-sm text-red-400" />
            </div>

            <div>
                <label for="update_password_password_confirmation" class="block text-sm font-medium text-white">{{ __('Confirm Password') }}</label>
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-whitest text-primary rounded-md" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-sm text-red-400" />
            </div>

            <div class="flex items-center justify-end gap-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-whitest text-sm font-medium rounded-md text-white bg-transparent hover:bg-whitest hover:text-primary transition">{{ __('Save') }}</button>

                @if (session('status') === 'password-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-300">{{ __('Saved.') }}</p>
                @endif
            </div>
        </div>
    </form>
</section>
