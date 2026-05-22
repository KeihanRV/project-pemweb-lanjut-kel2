<form action="{{ $action }}" method="POST" class="space-y-4">
    @csrf
    @if(isset($method) && strtoupper($method) !== 'POST')
        @method($method)
    @endif

    <div>
        <label class="block text-sm font-medium text-gray-700">Nama</label>
        <input type="text" name="name" value="{{ old('name', optional($user)->name) }}" class="mt-1 block w-full px-3 py-2 border rounded-lg" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', optional($user)->email) }}" class="mt-1 block w-full px-3 py-2 border rounded-lg" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Password {{ isset($user) ? '(kosongkan jika tidak ingin mengubah)' : '' }}</label>
        <input type="password" name="password" class="mt-1 block w-full px-3 py-2 border rounded-lg" {{ isset($user) ? '' : 'required' }}>
    </div>

    <div class="flex items-center gap-2">
        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">Simpan</button>
        <a href="{{ route('pengguna-index') }}" class="px-4 py-2 border rounded-lg text-gray-600">Batal</a>
    </div>
</form>
