<section class="text-white">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <div class="lg:col-span-4 flex justify-center lg:justify-center pt-4">
            <div class="relative group">
                @if($user->profile_photo_url)
                    <img src="{{ $user->profile_photo_url }}" 
                         alt="{{ $user->name }}" 
                         class="w-64 h-64 sm:w-72 sm:h-72 lg:w-80 lg:h-80 rounded-full object-cover border-4 border-primary shadow-xl" />
                @else
                    <div class="w-64 h-64 sm:w-72 sm:h-72 lg:w-80 lg:h-80 rounded-full bg-whitest border-4 border-primary shadow-xl flex items-center justify-center select-none">
                        <span class="text-6xl sm:text-7xl font-display text-primary tracking-wider">
                            @php
                                $words = explode(' ', $user->name);
                                $initials = '';
                                foreach ($words as $w) {
                                    $initials .= mb_substr($w, 0, 1);
                                    if (strlen($initials) >= 2) break;
                                }
                                echo strtoupper($initials);
                            @endphp
                        </span>
                    </div>
                @endif

                <button type="button" class="absolute bottom-4 right-4 bg-primary text-white p-3 rounded-full shadow-lg hover:bg-opacity-90 transition border border-gray-700" aria-label="Edit avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="lg:col-span-8">
            
            <div class="flex justify-between items-baseline mb-6 border-b border-gray-700/30 pb-4">
                <h2 class="text-3xl md:text-4xl font-sans tracking-tight text-gray-900 dark:text-white">
                    {{ __('Profile') }}
                </h2>
                <div class="text-right text-xs md:text-sm text-gray-400 font-sans">
                    <span class="block text-gray-500 text-[11px] uppercase tracking-wider">{{ __('Join since') }}</span>
                    <span class="font-medium text-gray-300">
                        {{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}
                    </span>
                </div>
            </div>

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                    
                    <div class="bg-whitest p-6 rounded-lg shadow-lg space-y-4">
                        <div>
                            <label for="name" class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1">{{ __('Full Name') }}</label>
                            <x-text-input id="name" name="name" type="text" class="w-full bg-whitest text-primary font-medium px-3 py-2 rounded border border-primary focus:ring-2 focus:ring-primary focus:border-primary" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-1 text-xs text-red-600" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1">{{ __('Email') }}</label>
                            <x-text-input id="email" name="email" type="email" class="w-full bg-whitest text-primary font-medium px-3 py-2 rounded border border-primary focus:ring-2 focus:ring-primary focus:border-primary" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-1 text-xs text-red-600" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <label for="sppg" class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1">{{ __('SPPG') }}</label>
                            <x-text-input id="sppg" name="sppg" type="text" class="w-full bg-whitest text-primary font-medium px-3 py-2 rounded border border-primary focus:ring-2 focus:ring-primary focus:border-primary" :value="old('sppg', $user->sppg ?? 'SPPG Bejong Sari')" autocomplete="off" />
                            <x-input-error class="mt-1 text-xs text-red-600" :messages="$errors->get('sppg')" />
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-whitest p-6 rounded-lg shadow-lg space-y-4">
                            <div>
                                <label for="role" class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1">{{ __('Role') }}</label>
                                <x-text-input id="role" name="role" type="text" class="w-full bg-whitest text-primary font-medium px-3 py-2 rounded border border-primary opacity-80 cursor-not-allowed" :value="old('role', $user->role ?? __('User'))" disabled />
                            </div>

                            <div>
                                <label for="phone" class="block text-xs font-semibold text-primary uppercase tracking-wider mb-1">{{ __('Phone Number') }}</label>
                                <x-text-input id="phone" name="phone" type="text" class="w-full bg-whitest text-primary font-medium px-3 py-2 rounded border border-primary focus:ring-2 focus:ring-primary focus:border-primary" :value="old('phone', $user->phone ?? '+335217239123')" />
                                <x-input-error class="mt-1 text-xs text-red-600" :messages="$errors->get('phone')" />
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-whitest text-sm font-medium rounded-md text-white bg-transparent hover:bg-whitest hover:text-primary transition">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>

                </div>

                @if (session('status') === 'profile-updated')
                    <div class="mt-4 flex justify-end">
                        <p x-data="{ true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-whitest font-medium">{{ __('Saved successfully.') }}</p>
                    </div>
                @endif
            </form>

        </div>
    </div>
</section>