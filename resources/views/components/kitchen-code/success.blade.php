<!-- Stage 3: Output (Success) -->
<div id="stage-success" class="stage hidden">
    <div class="text-center space-y-4">
        <div class="flex justify-center">
            <div class="bg-green-100 rounded-full p-4 animate-pulse">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
        <h2 class="text-xl font-semibold text-primary">Verifikasi Berhasil!</h2>
        <p class="text-gray-600">Selamat datang di</p>
        <div id="kitchen-display" class="bg-tertiary/30 rounded-lg p-4 mb-4">
            <p class="text-sm text-gray-600">Kitchen:</p>
            <p id="kitchen-nama" class="text-2xl font-bold text-primary"></p>
            <p id="kitchen-code" class="text-sm text-gray-500 mt-1"></p>
        </div>
        <a 
            href="{{ route('dashboard') }}" 
            class="block w-full bg-primary text-whitest font-semibold py-2 rounded-lg hover:bg-primary/90 transition duration-200"
        >
            Lanjut ke Dashboard
        </a>
    </div>
</div>
