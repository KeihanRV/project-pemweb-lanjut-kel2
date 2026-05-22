<x-app-layout>
    <div class="p-6">
        @include('list-pengguna._toolbar')

        <div class="mt-4">
            @include('list-pengguna._search')
        </div>

        <div class="mt-4">
            @include('list-pengguna._table')
        </div>

        <div class="mt-4">
            @include('list-pengguna._pagination')
        </div>

        @include('list-pengguna._modal-delete')
    </div>
</x-app-layout>
