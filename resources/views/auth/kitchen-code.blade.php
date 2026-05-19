<x-guest-layout :reverse="true">
    <div class="mx-auto w-full max-w-md">
        <div class="rounded-3xl bg-white px-8 py-10 shadow-[0_20px_60px_rgba(15,23,42,0.08)]">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold uppercase tracking-wide text-gray-800">SPPG Code</h1>
                <p class="mt-3 text-sm text-gray-500">Please, enter your SPPG Unit Code</p>
            </div>

            @php
                $oldCode = old('code', '');
                $codeChars = str_split($oldCode);
                $hasSuccess = session('success') || isset($successMessage);
                $hasError = $errors->has('code');
            @endphp

            <div class="space-y-8">
                <form id="kitchen-code-form" method="POST" action="{{ route('kitchen-code.validate') }}" class="space-y-8 {{ $hasSuccess ? 'hidden' : '' }}">
                    @csrf
                    <input type="hidden" id="code" name="code" value="{{ old('code') }}" />

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-4">Enter code</label>
                        <div class="flex justify-center gap-3">
                            <input id="code-1" type="text" maxlength="1" name="code_1" value="{{ $codeChars[0] ?? '' }}" class="code-input w-14 h-14 text-center text-2xl font-bold text-gray-800 rounded-xl border border-gray-300 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none" autocomplete="off" />
                            <input id="code-2" type="text" maxlength="1" name="code_2" value="{{ $codeChars[1] ?? '' }}" class="code-input w-14 h-14 text-center text-2xl font-bold text-gray-800 rounded-xl border border-gray-300 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none" autocomplete="off" />
                            <input id="code-3" type="text" maxlength="1" name="code_3" value="{{ $codeChars[2] ?? '' }}" class="code-input w-14 h-14 text-center text-2xl font-bold text-gray-800 rounded-xl border border-gray-300 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none" autocomplete="off" />
                            <input id="code-4" type="text" maxlength="1" name="code_4" value="{{ $codeChars[3] ?? '' }}" class="code-input w-14 h-14 text-center text-2xl font-bold text-gray-800 rounded-xl border border-gray-300 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none" autocomplete="off" />
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <button id="submit-code-button" type="submit" class="w-full max-w-xs rounded-md bg-[#1e293b] px-6 py-3 text-white font-semibold hover:bg-gray-900">Submit Code</button>
                    </div>
                </form>

                <div id="loader" class="hidden justify-center items-center gap-2 text-sm text-slate-600">
                    <svg class="h-5 w-5 animate-spin text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span>Memeriksa kode SPPG...</span>
                </div>

                <div id="result-panel" class="space-y-4 {{ $hasSuccess || $hasError ? 'block' : 'hidden' }}">
                    <div id="success-message" class="{{ $hasSuccess ? 'block' : 'hidden' }} rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">
                        {{ session('success') ?? $successMessage ?? '' }}
                    </div>
                    <div id="error-message" class="{{ $hasError ? 'block' : 'hidden' }} rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                        {{ $errors->first('code') }}
                    </div>
                    <div id="dashboard-button-container" class="{{ $hasSuccess ? 'flex' : 'hidden' }} justify-center">
                        <a id="dashboard-button" href="{{ route('dashboard') }}" class="rounded-md bg-[#1e293b] px-6 py-3 text-white font-semibold hover:bg-gray-900">Ke Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('kitchen-code-form');
        const codeInputs = Array.from(document.querySelectorAll('.code-input'));
        const codeHidden = document.getElementById('code');
        const errorMessage = document.getElementById('error-message');
        const loader = document.getElementById('loader');
        const submitButton = document.getElementById('submit-code-button');

        const showError = (message) => {
            errorMessage.textContent = message;
            errorMessage.classList.remove('hidden');
            errorMessage.classList.add('block');
        };

        // 1. Handle input text (Auto-focus & Filter karakter)
        codeInputs.forEach((input, index) => {
            input.addEventListener('input', (event) => {
                event.target.value = event.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                if (event.target.value.length === 1 && index < codeInputs.length - 1) {
                    codeInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (event) => {
                if (event.key === 'Backspace' && event.target.value === '' && index > 0) {
                    codeInputs[index - 1].focus();
                }
                // Cegah tombol 'Enter' memicu submit GET bawaan browser di dalam input field
                if (event.key === 'Enter') {
                    event.preventDefault();
                    form.requestSubmit(); // Memicu event submit form secara resmi
                }
            });
        });

        // 2. Handle pengiriman Form secara Aman
        form.addEventListener('submit', (event) => {
            // HENTIKAN submit bawaan HTML browser agar tidak terjadi 'stuck GET'
            event.preventDefault(); 

            const fullCode = codeInputs.map((input) => input.value).join('');
            
            if (fullCode.length !== 4) {
                showError('Silakan lengkapi keempat karakter kode SPPG.');
                return;
            }

            // Sembunyikan error lama jika ada
            errorMessage.classList.add('hidden');
            
            // Masukkan kode gabungan ke input hidden
            codeHidden.value = fullCode;

            // Beri efek visual "Loading/Kunci" tanpa mematikan element (menghindari bug browser)
            codeInputs.forEach(input => {
                input.readOnly = true;
                input.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
            });
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            
            // Tampilkan loader
            loader.classList.remove('hidden');
            loader.classList.add('flex');

            // PAKSA kirim data via POST secara murni lewat JavaScript setelah manipulasi DOM selesai
            Object.getPrototypeOf(form).submit.call(form);
        });

        // Fokuskan ke kotak pertama saat halaman terbuka
        if(codeInputs[0]) {
            codeInputs[0].focus();
        }
    </script>
</x-guest-layout>
