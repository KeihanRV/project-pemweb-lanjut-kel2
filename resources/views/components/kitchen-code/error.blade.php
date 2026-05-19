<!-- Stage 3: Output (Error) -->
<div id="stage-error" class="stage hidden">
    <div class="text-center space-y-4">
        <div class="flex justify-center">
            <div class="bg-red-100 rounded-full p-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        </div>
        <h2 class="text-xl font-semibold text-red-600">Verifikasi Gagal</h2>
        <p id="error-message" class="text-gray-600"></p>
        <button 
            type="button"
            onclick="resetForm()"
            class="w-full bg-primary text-whitest font-semibold py-2 rounded-lg hover:bg-primary/90 transition duration-200"
        >
            Coba Lagi
        </button>
    </div>
</div>
