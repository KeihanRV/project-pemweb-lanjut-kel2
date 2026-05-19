@extends('layouts.landing')

@section('content')
    <main class="relative min-h-screen flex items-center justify-center px-4 py-8" style="background-image: url('https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-tertiary/70"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-tertiary/70 via-tertiary/50 to-tertiary/80"></div>

        <section class="relative z-10 flex w-full max-w-2xl flex-col items-center text-center gap-8 px-6 py-16">
            <header>
                <p class="text-sm font-display font-semibold uppercase tracking-[0.3em] text-primary opacity-95">
                    SELAMAT DATANG DI,
                </p>
            </header>

            @include('components.landing-brand')
            @include('components.landing-tagline')
            @include('components.landing-cta')
        </section>
    </main>
@endsection
