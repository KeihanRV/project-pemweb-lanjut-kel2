<x-app-layout>
    <div class="p-6 max-w-3xl mx-auto">
        <h2 class="text-xl font-semibold mb-4">Edit Kitchen</h2>

        <form method="POST" action="{{ route('kitchens-update', $kitchen->id) }}" class="bg-white p-6 rounded-lg shadow-sm">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" value="{{ old('nama', $kitchen->nama) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $kitchen->lokasi) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm" required />
            </div>

            <div class="flex gap-2 justify-end">
                <a href="{{ route('kitchens-index') }}" class="px-4 py-2 border rounded-lg">Batal</a>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
