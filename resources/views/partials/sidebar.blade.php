<aside class="w-64 h-screen bg-white border-r border-gray-100 flex flex-col justify-between p-4 font-sans text-gray-600">
    <div>
        <div class="flex items-center gap-3 px-3 py-4 border-b border-gray-50">
            <img src="{{ asset('images/android-chrome-192x192.png') }}" alt="SIPEKA Logo" class="w-9 h-9 object-contain">
            <span class="text-2xl font-bold tracking-wider text-slate-700">SIPEKA</span>
        </div>

        <nav class="mt-4 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-all rounded-xl
               {{ request()->routeIs('dashboard') ? 'font-semibold text-primary bg-white shadow-md shadow-gray-100/70 border border-gray-50' : 'text-gray-400 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('dashboard') ? 'text-secondary' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('bahan-makanan') }}"
               class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-all rounded-xl
               {{ request()->routeIs('bahan-makanan') ? 'font-semibold text-primary bg-white shadow-md shadow-gray-100/70 border border-gray-50' : 'text-gray-400 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('bahan-makanan') ? 'text-secondary' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                </svg>
                <span>Bahan Makanan</span>
            </a>

            @if (auth()->user()->is_admin)
            <a href="{{ route('pengguna-index') }}"
               class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-all rounded-xl
               {{ request()->routeIs('pengguna-index') ? 'font-semibold text-primary bg-white shadow-md shadow-gray-100/70 border border-gray-50' : 'text-gray-400 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('pengguna-index') ? 'text-secondary' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                <span>User List</span>
            </a>
            <a href="{{ route('kitchens-index') }}"
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-all rounded-xl
            {{ request()->routeIs('kitchens-index') ? 'font-semibold text-primary bg-white shadow-md shadow-gray-100/70 border border-gray-50' : 'text-gray-400 hover:bg-gray-50' }}">
                
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('kitchens.index') ? 'text-secondary' : '' }}" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.25285 4.25547C8.09403 2.47951 9.90263 1.25 12 1.25C14.0974 1.25 15.906 2.47951 16.7471 4.25547C16.831 4.25184 16.9153 4.25 17 4.25C20.1756 4.25 22.75 6.82436 22.75 10C22.75 12.1806 21.5363 14.0762 19.75 15.0508L19.75 18.052C19.75 18.9505 19.7501 19.6997 19.6701 20.2945C19.5857 20.9223 19.4 21.4891 18.9445 21.9445C18.4891 22.4 17.9223 22.5857 17.2945 22.6701C16.6997 22.7501 15.9505 22.75 15.052 22.75H8.94801C8.04952 22.75 7.3003 22.7501 6.70552 22.6701C6.07773 22.5857 5.51093 22.4 5.05546 21.9445C4.59999 21.4891 4.41432 20.9223 4.32991 20.2945C4.24994 19.6997 4.24997 18.9505 4.25 18.052L4.25 15.0508C2.46371 14.0762 1.25 12.1806 1.25 10C1.25 6.82436 3.82436 4.25 7 4.25C7.08469 4.25 7.16899 4.25184 7.25285 4.25547ZM6.80262 5.7545C4.54704 5.85762 2.75 7.71895 2.75 10C2.75 11.7416 3.79769 13.2402 5.30028 13.8967C5.57345 14.016 5.75 14.2859 5.75 14.584V18C5.75 18.964 5.75159 19.6116 5.81654 20.0946C5.87858 20.5561 5.9858 20.7536 6.11612 20.8839C6.24643 21.0142 6.44393 21.1214 6.90539 21.1835C7.38843 21.2484 8.03599 21.25 9 21.25H15C15.964 21.25 16.6116 21.2484 17.0946 21.1835C17.5561 21.1214 17.7536 21.0142 17.8839 20.8839C18.0142 20.7536 18.1214 20.5561 18.1835 20.0946C18.2484 19.6116 18.25 18.964 18.25 18L18.25 14.584C18.25 14.2859 18.4265 14.016 18.6997 13.8967C20.2023 13.2402 21.25 11.7416 21.25 10C21.25 7.71895 19.453 5.85761 17.1974 5.7545C17.2321 5.99825 17.25 6.24718 17.25 6.5V7C17.25 7.41421 16.9142 7.75 16.5 7.75C16.0858 7.75 15.75 7.41421 15.75 7V6.5C15.75 6.07715 15.6803 5.67212 15.5524 5.29486C15.0502 3.81402 13.6484 2.75 12 2.75C10.3516 2.75 8.94981 3.81402 8.44763 5.29486C8.3197 5.67212 8.25 6.07715 8.25 6.5V7C8.25 7.41421 7.91421 7.75 7.5 7.75C7.08579 7.75 6.75 7.41421 6.75 7V6.5C6.75 6.24717 6.76792 5.99825 6.80262 5.7545ZM8.25 18C8.25 17.5858 8.58579 17.25 9 17.25H15C15.4142 17.25 15.75 17.5858 15.75 18C15.75 18.4142 15.4142 18.75 15 18.75H9C8.58579 18.75 8.25 18.4142 8.25 18Z"/>
                </svg>
                <span>Kitchen List</span>
            </a>
            @endif

            <div class="pt-4 px-4 text-xs font-bold uppercase tracking-wider text-slate-700">
                Account Pages
            </div>

            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-all rounded-xl
               {{ request()->routeIs('profile.edit') ? 'font-semibold text-primary bg-white shadow-md shadow-gray-100/70 border border-gray-50' : 'text-gray-400 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('profile.edit') ? 'text-secondary' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                <span>Profile</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-400 rounded-xl hover:bg-red-50 hover:text-red-500 transition-colors">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </div>

    <div class="relative bg-tertiary overflow-hidden rounded-3xl p-5 text-white shadow-lg shadow-teal-100">
        <div class="absolute -right-10 -bottom-10 w-36 h-36 border border-white/20 rounded-full"></div>
        <div class="absolute -right-5 -bottom-5 w-48 h-48 border border-white/10 rounded-full"></div>

        <div class="relative z-10 flex flex-col gap-3">
            <div class="w-9 h-9 bg-transparent text-secondary rounded-xl flex items-center justify-center shadow-md">
                <!-- <svg fill="#000000" viewBox="0 -0.5 25 25" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="m12.301 0h.093c2.242 0 4.34.613 6.137 1.68l-.055-.031c1.871 1.094 3.386 2.609 4.449 4.422l.031.058c1.04 1.769 1.654 3.896 1.654 6.166 0 5.406-3.483 10-8.327 11.658l-.087.026c-.063.02-.135.031-.209.031-.162 0-.312-.054-.433-.144l.002.001c-.128-.115-.208-.281-.208-.466 0-.005 0-.01 0-.014v.001q0-.048.008-1.226t.008-2.154c.007-.075.011-.161.011-.249 0-.792-.323-1.508-.844-2.025.618-.061 1.176-.163 1.718-.305l-.076.017c.573-.16 1.073-.373 1.537-.642l-.031.017c.508-.28.938-.636 1.292-1.058l.006-.007c.372-.476.663-1.036.84-1.645l.009-.035c.209-.683.329-1.468.329-2.281 0-.045 0-.091-.001-.136v.007c0-.022.001-.047.001-.072 0-1.248-.482-2.383-1.269-3.23l.003.003c.168-.44.265-.948.265-1.479 0-.649-.145-1.263-.404-1.814l.011.026c-.115-.022-.246-.035-.381-.035-.334 0-.649.078-.929.216l.012-.005c-.568.21-1.054.448-1.512.726l.038-.022-.609.384c-.922-.264-1.981-.416-3.075-.416s-2.153.152-3.157.436l.081-.02q-.256-.176-.681-.433c-.373-.214-.814-.421-1.272-.595l-.066-.022c-.293-.154-.64-.244-1.009-.244-.124 0-.246.01-.364.03l.013-.002c-.248.524-.393 1.139-.393 1.788 0 .531.097 1.04.275 1.509l-.01-.029c-.785.844-1.266 1.979-1.266 3.227 0 .025 0 .051.001.076v-.004c-.001.039-.001.084-.001.13 0 .809.12 1.591.344 2.327l-.015-.057c.189.643.476 1.202.85 1.693l-.009-.013c.354.435.782.793 1.267 1.062l.022.011c.432.252.933.465 1.46.614l.046.011c.466.125 1.024.227 1.595.284l.046.004c-.431.428-.718 1-.784 1.638l-.001.012c-.207.101-.448.183-.699.236l-.021.004c-.256.051-.549.08-.85.08-.022 0-.044 0-.066 0h.003c-.394-.008-.756-.136-1.055-.348l.006.004c-.371-.259-.671-.595-.881-.986l-.007-.015c-.198-.336-.459-.614-.768-.827l-.009-.006c-.225-.169-.49-.301-.776-.38l-.016-.004-.32-.048c-.023-.002-.05-.003-.077-.003-.14 0-.273.028-.394.077l.007-.003q-.128.072-.08.184c.039.086.087.16.145.225l-.001-.001c.061.072.13.135.205.19l.003.002.112.08c.283.148.516.354.693.603l.004.006c.191.237.359.505.494.792l.01.024.16.368c.135.402.38.738.7.981l.005.004c.3.234.662.402 1.057.478l.016.002c.33.064.714.104 1.106.112h.007c.045.002.097.002.15.002.261 0 .517-.021.767-.062l-.027.004.368-.064q0 .609.008 1.418t.008.873v.014c0 .185-.08.351-.208.466h-.001c-.119.089-.268.143-.431.143-.075 0-.147-.011-.214-.032l.005.001c-4.929-1.689-8.409-6.283-8.409-11.69 0-2.268.612-4.393 1.681-6.219l-.032.058c1.094-1.871 2.609-3.386 4.422-4.449l.058-.031c1.739-1.034 3.835-1.645 6.073-1.645h.098-.005zm-7.64 17.666q.048-.112-.112-.192-.16-.048-.208.032-.048.112.112.192.144.096.208-.032zm.497.545q.112-.08-.032-.256-.16-.144-.256-.048-.112.08.032.256.159.157.256.047zm.48.72q.144-.112 0-.304-.128-.208-.272-.096-.144.08 0 .288t.272.112zm.672.673q.128-.128-.064-.304-.192-.192-.32-.048-.144.128.064.304.192.192.32.044zm.913.4q.048-.176-.208-.256-.24-.064-.304.112t.208.24q.24.097.304-.096zm1.009.08q0-.208-.272-.176-.256 0-.256.176 0 .208.272.176.256.001.256-.175zm.929-.16q-.032-.176-.288-.144-.256.048-.224.24t.288.128.225-.224z">
                        </path>
                    </g>
                </svg> -->

                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M12 0a12 12 0 1 0 0 24 12 12 0 0 0 0-24zm3.163 21.783h-.093a.513.513 0 0 1-.382-.14.513.513 0 0 1-.14-.372v-1.406c.006-.467.01-.94.01-1.416a3.693 3.693 0 0 0-.151-1.028 1.832 1.832 0 0 0-.542-.875 8.014 8.014 0 0 0 2.038-.471 4.051 4.051 0 0 0 1.466-.964c.407-.427.71-.943.885-1.506a6.77 6.77 0 0 0 .3-2.13 4.138 4.138 0 0 0-.26-1.476 3.892 3.892 0 0 0-.795-1.284 2.81 2.81 0 0 0 .162-.582c.033-.2.05-.402.05-.604 0-.26-.03-.52-.09-.773a5.309 5.309 0 0 0-.221-.763.293.293 0 0 0-.111-.02h-.11c-.23.002-.456.04-.674.111a5.34 5.34 0 0 0-.703.26 6.503 6.503 0 0 0-.661.343c-.215.127-.405.249-.573.362a9.578 9.578 0 0 0-5.143 0 13.507 13.507 0 0 0-.572-.362 6.022 6.022 0 0 0-.672-.342 4.516 4.516 0 0 0-.705-.261 2.203 2.203 0 0 0-.662-.111h-.11a.29.29 0 0 0-.11.02 5.844 5.844 0 0 0-.23.763c-.054.254-.08.513-.081.773 0 .202.017.404.051.604.033.199.086.394.16.582A3.888 3.888 0 0 0 5.702 10a4.142 4.142 0 0 0-.263 1.476 6.871 6.871 0 0 0 .292 2.12c.181.563.483 1.08.884 1.516.415.422.915.75 1.466.964.653.25 1.337.41 2.033.476a1.828 1.828 0 0 0-.452.633 2.99 2.99 0 0 0-.2.744 2.754 2.754 0 0 1-1.175.27 1.788 1.788 0 0 1-1.065-.3 2.904 2.904 0 0 1-.752-.824 3.1 3.1 0 0 0-.292-.382 2.693 2.693 0 0 0-.372-.343 1.841 1.841 0 0 0-.432-.24 1.2 1.2 0 0 0-.481-.101c-.04.001-.08.005-.12.01a.649.649 0 0 0-.162.02.408.408 0 0 0-.13.06.116.116 0 0 0-.06.1.33.33 0 0 0 .14.242c.093.074.17.131.232.171l.03.021c.133.103.261.214.382.333.112.098.213.209.3.33.09.119.168.246.231.381.073.134.15.288.231.463.188.474.522.875.954 1.145.453.243.961.364 1.476.351.174 0 .349-.01.522-.03.172-.028.343-.057.515-.091v1.743a.5.5 0 0 1-.533.521h-.062a10.286 10.286 0 1 1 6.324 0v.005z"></path></g></svg>
            </div>
            <div>
                <h4 class="font-bold text-primary leading-tight">Need help?</h4>
                <p class="text-xs text-primary mt-1">Please check our Github</p>
            </div>
            <a href="https://github.com/KeihanRV/project-pemweb-lanjut-kel2" class="w-full bg-white text-center text-xs font-bold text-slate-700 py-3 rounded-2xl shadow-sm hover:bg-gray-50 transition-colors uppercase tracking-wider">
                Documentation
            </a>
        </div>
    </div>
</aside>
