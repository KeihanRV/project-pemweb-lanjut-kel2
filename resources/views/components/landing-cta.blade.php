<nav class="flex flex-col items-center justify-center gap-4 sm:flex-row sm:gap-4">
    @if (Route::has('login'))
        @auth
            <a href="{{ route('dashboard') }}" class="inline-flex w-full max-w-xs items-center justify-center rounded-full bg-primary px-12 py-3 text-sm font-semibold text-whitest shadow-[0_18px_50px_-25px_rgba(36,45,45,0.8)] transition duration-200 hover:bg-primary/95 hover:-translate-y-0.5 active:scale-95">
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="inline-flex w-full max-w-xs items-center justify-center rounded-full bg-primary px-12 py-3 text-sm font-semibold text-whitest shadow-[0_18px_50px_-25px_rgba(36,45,45,0.8)] transition duration-200 hover:bg-primary/95 hover:-translate-y-0.5 active:scale-95">
                Sign In
            </a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="inline-flex w-full max-w-xs items-center justify-center whitespace-nowrap rounded-full bg-whitest px-12 py-3 text-sm font-semibold text-primary shadow-[0_18px_40px_-30px_rgba(36,45,45,0.25)] border border-primary/10 transition duration-200 hover:bg-whitest/95 hover:-translate-y-0.5 active:scale-95">
                    Sign Up
                </a>
            @endif
        @endauth
    @endif
</nav>
