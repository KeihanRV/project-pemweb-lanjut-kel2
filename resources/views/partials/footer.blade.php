<footer class="flex items-center justify-between px-6 py-3 bg-white border-t border-slate-200 shrink-0">

    {{-- Brand & Copyright --}}
    <div class="flex items-center gap-2.5">
        <div class="w-6 h-6 rounded-md bg-transparent flex items-center justify-content-center flex-shrink-0">
            <!-- <svg width="13" height="13" viewBox="0 0 16 16" fill="none">
                <path d="M3 8.5L6.5 12L13 5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg> -->
            <img src="{{ asset('images/android-chrome-192x192.png') }}" alt="Logo" class="w-6 h-6 object-contain">
        </div>
        <div class="leading-tight">
            <span class="text-sm font-medium text-slate-700">{{ config('app.name', 'SIPEKA') }}</span>
            <span class="text-xs text-slate-400 ml-1.5">&copy; {{ date('Y') }} &middot; @lang('All Rights Reserved')</span>
        </div>
    </div>

    {{-- Links --}}
    <!-- <div class="hidden md:flex items-center gap-1">
        <a href="#" class="text-xs text-slate-400 hover:text-slate-600 hover:bg-slate-100 px-2.5 py-1.5 rounded-md transition-colors">
            @lang('Privacy Policy')
        </a>
        <span class="text-slate-300 text-xs">&bull;</span>
        <a href="#" class="text-xs text-slate-400 hover:text-slate-600 hover:bg-slate-100 px-2.5 py-1.5 rounded-md transition-colors">
            @lang('Terms of Service')
        </a>
    </div> -->

</footer>