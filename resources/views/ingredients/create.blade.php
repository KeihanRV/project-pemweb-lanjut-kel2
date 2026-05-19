<x-app-layout>
    <x-slot name="header">
        <div class="text-xs text-gray-500 mb-1">Pages / <span class="text-[#242D2D]">Dashboard</span></div>
        <h2 class="font-bold text-xl text-[#242D2D] leading-tight">
            {{ __('Input Ingredient Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen font-sans">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-[#B2C3C4]/60 rounded-3xl shadow-sm p-10">
                
                <form method="POST" action="{{ route('ingredients.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <input type="hidden" name="kitchen_id" value="{{ $selectedKitchen ? $selectedKitchen->id : ($kitchens->first() ? $kitchens->first()->id : '') }}">
                    <div>
                        <label for="nama" class="block text-sm font-bold text-[#242D2D] mb-2">Nama Bahan</label>
                        <input id="nama" name="nama" type="text" 
                               class="w-full bg-[#F8FAFA] border border-[#242D2D] rounded-2xl p-4 text-[#242D2D] placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#7EC9CE] focus:border-[#7EC9CE] transition"
                               placeholder="Bawang Putih" :value="old('nama')" required autofocus />
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <div>
                        <label for="tanggal_datang" class="block text-sm font-bold text-[#242D2D] mb-2">Tanggal Masuk</label>
                        <input id="tanggal_datang" name="tanggal_datang" type="date" 
                               class="w-full bg-[#F8FAFA] border border-[#242D2D] rounded-2xl p-4 text-[#242D2D] focus:outline-none focus:ring-1 focus:ring-[#7EC9CE] focus:border-[#7EC9CE] transition"
                               :value="old('tanggal_datang')" required />
                        <input type="hidden" name="kadaluarsa" id="kadaluarsa" :value="old('kadaluarsa')">
                        <x-input-error :messages="$errors->get('tanggal_datang')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <div class="md:col-span-7">
                            <label for="kuantitas" class="block text-sm font-bold text-[#242D2D] mb-2">Kuantitas</label>
                            <input id="kuantitas" name="kuantitas" type="number" min="1"
                                   class="w-full bg-[#F8FAFA] border border-[#242D2D] rounded-2xl p-4 text-[#242D2D] focus:outline-none focus:ring-1 focus:ring-[#7EC9CE] focus:border-[#7EC9CE] transition"
                                   placeholder="100" :value="old('kuantitas')" required />
                            <x-input-error :messages="$errors->get('kuantitas')" class="mt-2" />
                        </div>
                        
                        <div class="md:col-span-5">
                            <label for="satuan" class="block text-sm font-bold text-[#242D2D] mb-2">Satuan</label>
                            <div class="relative">
                                <select id="satuan" name="satuan"
                                        class="w-full bg-[#F8FAFA] border border-[#242D2D] rounded-2xl p-4 text-[#242D2D] focus:outline-none focus:ring-1 focus:ring-[#7EC9CE] focus:border-[#7EC9CE] transition appearance-none cursor-pointer" required>
                                    <option value="" class="text-gray-400">Kg</option>
                                    @foreach (['kg', 'gram', 'liter', 'ml', 'butir', 'ikat', 'buah', 'bungkus'] as $s)
                                        <option value="{{ $s }}" {{ old('satuan') === $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-[#242D2D]">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#242D2D] mb-2">Foto Bahan (opsional)</label>
                        <div class="flex items-center gap-4 mt-2">
                            <label for="foto" class="cursor-pointer bg-[#D8E8E9] text-[#242D2D] font-bold px-6 py-3.5 rounded-2xl border border-[#242D2D]/30 hover:bg-opacity-80 transition shadow-sm text-sm">
                                Pilih Gambar
                            </label>
                            <input id="foto" name="foto" type="file" accept="image/jpeg,image/jpg,image/png,image/webp" class="hidden" />
                            <span id="file-name" class="text-sm text-gray-400 font-medium">Tidak Ada Gambar Yang Dipilih</span>
                        </div>
                        <p class="mt-2 text-xs text-gray-400">Format target: jpeg, jpg, png, webp. Maksimal asset: 5MB.</p>
                        <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4 pt-6">
                        <button type="submit" class="bg-[#242D2D] text-white px-12 py-3.5 rounded-2xl font-bold uppercase text-sm tracking-wider shadow-sm hover:bg-opacity-90 transition">
                            SIMPAN
                        </button>
                        
                        <a href="{{ route('ingredients.index') }}"
                           class="bg-white text-[#242D2D] px-12 py-3.5 rounded-2xl font-bold uppercase text-sm tracking-wider border border-[#242D2D] shadow-sm hover:bg-gray-50 transition text-center">
                            BATAL
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        // Intercept native changes on hidden native upload files nodes to modify visually presented naming elements
        document.getElementById('foto').addEventListener('change', function() {
            const fileNameSpan = document.getElementById('file-name');
            fileNameSpan.textContent = this.files.length > 0 ? this.files[0].name : "Tidak Ada Gambar Yang Dipilih";
        });

        // Mirror structural dependencies to clear backend logic parsing requirements silently
        document.getElementById('tanggal_datang').addEventListener('change', function() {
            document.getElementById('kadaluarsa').value = this.value;
        });
    </script>
</x-app-layout>