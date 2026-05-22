<form method="GET" action="{{ route('pengguna-index') }}" id="user-filter-form" class="flex gap-2">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email..." class="px-3 py-2 border rounded-lg w-1/2" />

    <button type="submit" class="px-4 py-2 bg-secondary text-white rounded-lg">Cari</button>

    <a href="{{ route('pengguna-index') }}" class="ml-auto text-sm text-gray-500 hover:underline">Reset</a>
</form>
