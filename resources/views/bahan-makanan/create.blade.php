<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Bahan Makanan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('bahan-makanan.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama -->
                        <div class="mb-4">
                            <x-input-label for="nama" :value="__('Nama Bahan')" />
                            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full"
                                :value="old('nama')" required autofocus />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <!-- Tanggal Masuk -->
                        <div class="mb-4">
                            <x-input-label for="tanggal_masuk" :value="__('Tanggal Masuk')" />
                            <x-text-input id="tanggal_masuk" name="tanggal_masuk" type="date" class="mt-1 block w-full"
                                :value="old('tanggal_masuk')" required />
                            <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-2" />
                        </div>

                        <!-- Kuantitas & Satuan -->
                        <div class="mb-4 grid grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <x-input-label for="kuantitas" :value="__('Kuantitas')" />
                                <x-text-input id="kuantitas" name="kuantitas" type="number" min="1"
                                    class="mt-1 block w-full" :value="old('kuantitas')" required />
                                <x-input-error :messages="$errors->get('kuantitas')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="satuan" :value="__('Satuan')" />
                                <select id="satuan" name="satuan"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Pilih</option>
                                    <option value="kg" {{ old('satuan') === 'kg' ? 'selected' : '' }}>kg</option>
                                    <option value="gram" {{ old('satuan') === 'gram' ? 'selected' : '' }}>gram</option>
                                    <option value="liter" {{ old('satuan') === 'liter' ? 'selected' : '' }}>liter</option>
                                    <option value="ml" {{ old('satuan') === 'ml' ? 'selected' : '' }}>ml</option>
                                    <option value="butir" {{ old('satuan') === 'butir' ? 'selected' : '' }}>butir</option>
                                    <option value="ikat" {{ old('satuan') === 'ikat' ? 'selected' : '' }}>ikat</option>
                                    <option value="buah" {{ old('satuan') === 'buah' ? 'selected' : '' }}>buah</option>
                                    <option value="bungkus" {{ old('satuan') === 'bungkus' ? 'selected' : '' }}>bungkus</option>
                                </select>
                                <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Foto -->
                        <div class="mb-6">
                            <x-input-label for="foto" :value="__('Foto Bahan')" />
                            <input id="foto" name="foto" type="file" accept="image/jpeg,image/jpg,image/png,image/webp"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                required />
                            <p class="mt-1 text-xs text-gray-400">Format: jpeg, jpg, png, webp. Maks: 5MB.</p>
                            <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
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
