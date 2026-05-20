<aside class="w-64 h-screen bg-white border-r border-gray-100 flex flex-col justify-between p-4 font-sans text-gray-600">
    <div>
        <div class="flex items-center gap-3 px-3 py-4 border-b border-gray-50">
    <img src="{{ asset('images/android-chrome-192x192.png') }}" alt="SIPEKA Logo" class="w-9 h-9 object-contain">
    
    <span class="text-2xl font-bold tracking-wider text-slate-700">SIPEKA</span>
</div>

       <a href="{{ route('dashboard') }}" 
       class="flex items-center gap-4 px-4 py-3 text-sm font-medium transition-all rounded-xl
       {{ request()->routeIs('dashboard') ? 'font-semibold text-slate-800 bg-white shadow-md shadow-gray-100/70 border border-gray-50' : 'text-gray-400 hover:bg-gray-50' }}">
        <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-teal-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('bahan-makanan') }}" 
       class="flex items-center gap-4 px-4 py-3 text-sm font-medium transition-all rounded-xl
       {{ request()->routeIs('bahan-makanan') ? 'font-semibold text-slate-800 bg-white shadow-md shadow-gray-100/70 border border-gray-50' : 'text-gray-400 hover:bg-gray-50' }}">
        <div class="p-2 rounded-xl {{ request()->routeIs('bahan-makanan') ? 'bg-teal-400/20 text-teal-500' : 'bg-gray-50 text-gray-400' }}">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
            </svg>
        </div>
        <span>Bahan Makanan</span>
    </a>

            <div class="pt-4 px-4 text-xs font-bold uppercase tracking-wider text-slate-700">
                Account Pages
            </div>

            <a href="#" class="flex items-center gap-4 px-4 py-3 text-sm font-medium text-gray-400 rounded-xl hover:bg-gray-50 transition-colors">
                <div class="p-2 bg-white shadow-sm rounded-xl border border-gray-50">
                    <svg class="w-4 h-4 text-teal-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <span>Profile</span>
            </a>


        </nav>
    </div>

    <div class="relative bg-teal-400 overflow-hidden rounded-3xl p-5 text-white shadow-lg shadow-teal-100">
        <div class="absolute -right-10 -bottom-10 w-36 h-36 border border-white/20 rounded-full"></div>
        <div class="absolute -right-5 -bottom-5 w-48 h-48 border border-white/10 rounded-full"></div>
        
        <div class="relative z-10 flex flex-col gap-3">
            <div class="w-9 h-9 bg-white text-teal-500 rounded-xl flex items-center justify-center shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-base leading-tight">Need help?</h4>
                <p class="text-xs text-teal-50/80 mt-1">Please check our docs</p>
            </div>
            <a href="#" class="w-full bg-white text-center text-xs font-bold text-slate-700 py-3 rounded-2xl shadow-sm hover:bg-gray-50 transition-colors uppercase tracking-wider">
                Documentation
            </a>
        </div>
    </div>
</aside>