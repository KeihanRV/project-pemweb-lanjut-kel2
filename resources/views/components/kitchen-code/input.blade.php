<!-- Stage 1: Input Code -->
<div id="stage-input" class="stage">
    <form id="kitchen-code-form" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-primary mb-3">
                Kode SPPG
            </label>
            <div class="flex gap-2 justify-center">
                <input 
                    type="text" 
                    id="code-1" 
                    class="code-input w-16 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition uppercase"
                    maxlength="1"
                    required
                    autocomplete="off"
                >
                <input 
                    type="text" 
                    id="code-2" 
                    class="code-input w-16 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition uppercase"
                    maxlength="1"
                    required
                    autocomplete="off"
                >
                <input 
                    type="text" 
                    id="code-3" 
                    class="code-input w-16 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition uppercase"
                    maxlength="1"
                    required
                    autocomplete="off"
                >
                <input 
                    type="text" 
                    id="code-4" 
                    class="code-input w-16 h-16 text-center text-2xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent outline-none transition uppercase"
                    maxlength="1"
                    required
                    autocomplete="off"
                >
            </div>
            <input type="hidden" id="code" name="code">
            @error('code')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button 
            type="submit" 
            class="w-full bg-primary text-whitest font-semibold py-2 rounded-lg hover:bg-primary/90 transition duration-200 active:scale-95"
        >
            Verifikasi
        </button>
    </form>

    <p class="text-center text-gray-600 text-sm mt-4">
        Hubungi admin jika belum memiliki kode SPPG
    </p>
</div>
