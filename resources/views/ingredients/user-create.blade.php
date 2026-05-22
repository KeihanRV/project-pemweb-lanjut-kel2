<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Ingredient Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('ingredients.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Kitchen Info -->
                        <div class="bg-primary/5 rounded-lg p-4 border border-primary/10">
                            <p class="text-sm text-gray-600">Kitchen:</p>
                            <p class="text-lg font-semibold text-primary">{{ $kitchen->nama }}</p>
                            <p class="text-sm text-gray-500">Kode: {{ $kitchen->code }}</p>
                            <input type="hidden" name="kitchen_id" value="{{ $kitchen->id }}">
                        </div>

                        <!-- Nama -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700">
                                Nama Ingredient
                            </label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none"
                                   required>
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Datang -->
                        <div>
                            <label for="tanggal_datang" class="block text-sm font-medium text-gray-700">
                                Tanggal Datang
                            </label>
                            <input type="date" id="tanggal_datang" name="tanggal_datang" value="{{ old('tanggal_datang') }}"
                                   class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none"
                                   required>
                            @error('tanggal_datang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="hidden" name="kadaluarsa" id="kadaluarsa" value="{{ old('kadaluarsa') }}">

                        <!-- Kuantitas & Satuan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="kuantitas" class="block text-sm font-medium text-gray-700">
                                    Kuantitas
                                </label>
                                <input type="number" id="kuantitas" name="kuantitas" value="{{ old('kuantitas') }}" min="1"
                                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none"
                                       required>
                                @error('kuantitas')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="satuan" class="block text-sm font-medium text-gray-700">
                                    Satuan
                                </label>
                                <select id="satuan" name="satuan"
                                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent outline-none"
                                        required>
                                    @foreach (['kg', 'gram', 'liter', 'ml', 'butir', 'ikat', 'buah', 'bungkus'] as $s)
                                        <option value="{{ $s }}" {{ old('satuan') === $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                @error('satuan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Foto -->
                        <div>
                            <label for="foto" class="block text-sm font-medium text-gray-700">
                                Foto Ingredient
                            </label>
                            <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary/50 transition cursor-pointer" id="foto-drop-zone">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-12l-3.172-3.172a4 4 0 00-5.656 0L28 20M9 20l3.172-3.172a4 4 0 015.656 0L28 20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="foto" class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-primary/80">
                                            <span>Upload file</span>
                                            <input id="foto" name="foto" type="file" class="hidden" accept="image/*" required>
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, WebP up to 5MB</p>
                                </div>
                            </div>
                            @error('foto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div id="foto-preview" class="mt-4 hidden">
                                <img id="preview-img" src="" alt="Preview" class="max-w-xs rounded-lg shadow-md">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="flex-1 bg-primary text-whitest font-semibold py-2 rounded-lg hover:bg-primary/90 transition duration-200 active:scale-95">
                                Simpan Ingredient
                            </button>
                            <a href="{{ route('ingredients.index') }}" class="flex-1 bg-gray-200 text-gray-900 font-semibold py-2 rounded-lg hover:bg-gray-300 transition duration-200 text-center">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('tanggal_datang').addEventListener('change', function() {
            document.getElementById('kadaluarsa').value = this.value;
        });

        const fotoInput = document.getElementById('foto');
        const dropZone = document.getElementById('foto-drop-zone');
        const preview = document.getElementById('foto-preview');
        const previewImg = document.getElementById('preview-img');

        // Handle file selection
        fotoInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    previewImg.src = event.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle drag and drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-primary', 'bg-primary/5');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-primary', 'bg-primary/5');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-primary', 'bg-primary/5');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fotoInput.files = files;
                const event = new Event('change', { bubbles: true });
                fotoInput.dispatchEvent(event);
            }
        });
    </script>
</x-app-layout>
