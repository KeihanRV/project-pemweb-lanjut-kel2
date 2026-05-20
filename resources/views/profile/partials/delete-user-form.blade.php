<section class="space-y-6">
    <header>
        <h2 class="text-3xl font-medium text-whitest">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-tertiary">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="bg-transparent border border-whitest text-white hover:bg-whitest hover:text-primary">{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6 space-y-4">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4 bg-whitest text-primary rounded-md" placeholder="{{ __('Password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-sm text-red-400" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-transparent border border-whitest text-primary hover:bg-whitest hover:text-primary">
                    {{ __('Cancel') }}
                </x-secondary-button>

            <x-danger-button class="ms-3 !bg-whitest border !border-danger !text-danger hover:!bg-danger hover:!text-white uppercase tracking-widest">
                {{ __('Delete Account') }}
            </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
