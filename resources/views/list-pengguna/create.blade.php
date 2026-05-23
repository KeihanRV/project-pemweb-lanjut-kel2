<x-app-layout>
    <div class="p-6">
        <h2 class="text-xl font-semibold">Tambah Pengguna</h2>

        <div class="mt-4 max-w-lg">
            @include('list-pengguna._form', ['action' => route('pengguna-store'), 'method' => 'POST', 'user' => null])
        </div>
    </div>
</x-app-layout>
