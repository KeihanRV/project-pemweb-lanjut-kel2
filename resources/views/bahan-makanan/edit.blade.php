<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Bahan Makanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('bahan-makanan.update', $bahan) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="mb-4">
                            <x-input-label for="nama" :value="__('Nama Bahan')" />
                            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full"
                                :value="old('nama', $bahan->nama)" required autofocus />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <!-- Tanggal Masuk -->
                        <div class="mb-4">
                            <x-input-label for="tanggal_masuk" :value="__('Tanggal Masuk')" />
                            <x-text-input id="tanggal_masuk" name="tanggal_masuk" type="date" class="mt-1 block w-full"
                                :value="old('tanggal_masuk', $bahan->tanggal_masuk)" required />
                            <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-2" />
                        </div>

                        <!-- Kuantitas & Satuan -->
                        <div class="mb-4 grid grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <x-input-label for="kuantitas" :value="__('Kuantitas')" />
                                <x-text-input id="kuantitas" name="kuantitas" type="number" min="1"
                                    class="mt-1 block w-full" :value="old('kuantitas', $bahan->kuantitas)" required />
                                <x-input-error :messages="$errors->get('kuantitas')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="satuan" :value="__('Satuan')" />
                                <select id="satuan" name="satuan"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Pilih</option>
                                    @foreach (['kg', 'gram', 'liter', 'ml', 'butir', 'ikat', 'buah', 'bungkus'] as $s)
                                        <option value="{{ $s }}" {{ old('satuan', $bahan->satuan) === $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Foto Saat Ini -->
                        @if ($bahan->foto)
                            <div class="mb-4">
                                <x-input-label :value="__('Foto Saat Ini')" />
                                <div class="mt-1 flex items-center gap-4">
                                    <img src="{{ Storage::url($bahan->foto) }}" alt="{{ $bahan->nama }}"
                                         class="h-24 w-24 object-cover rounded border">
                                    <span class="text-sm text-gray-500">
                                        Status:
                                        @if ($bahan->status === 'segar')
                                            <span class="text-green-600 font-medium">Segar</span>
                                        @elseif ($bahan->status === 'tidak segar')
                                            <span class="text-red-600 font-medium">Tidak Segar</span>
                                        @else
                                            <span class="text-gray-600 font-medium">Tidak Diketahui</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endif

                        <!-- Foto Baru -->
                        <div class="mb-6">
                            <x-input-label for="foto" :value="__('Foto Baru (opsional)')" />
                            <input id="foto" name="foto" type="file" accept="image/jpeg,image/jpg,image/png,image/webp"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            <p class="mt-1 text-xs text-gray-400">Kosongkan jika tidak ingin mengubah foto. Format: jpeg, jpg, png, webp. Maks: 5MB.</p>
                            <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Perbarui') }}</x-primary-button>
                            <a href="{{ route('bahan-makanan.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
