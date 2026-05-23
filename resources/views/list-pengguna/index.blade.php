<x-app-layout>
    <div class="p-6">
        @include('list-pengguna._toolbar')

        <div class="mt-4">
            @include('list-pengguna._search')
        </div>

        <div class="mt-4">            @include('list-pengguna._modal-admin')            @include('list-pengguna._table')
        </div>

        <div class="mt-4">
            @include('list-pengguna._pagination')
        </div>

        @include('list-pengguna._modal-delete')
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.querySelector('#user-filter-form input[name="q"]');
        const perPage = document.getElementById('per-page-select');
        const form = document.getElementById('user-filter-form');

        // Fungsi debounce dihapus karena sudah tidak digunakan lagi untuk performa minimalis

        if (input && form) {
            // Mengganti 'input' dengan 'keypress' untuk mendeteksi tombol Enter
            input.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Mencegah duplikasi submit bawaan browser jika ada
                    form.submit();      // Jalankan submit form
                }
            });
        }

        if (perPage && form) {
            perPage.addEventListener('change', () => form.submit());
        }
    });
</script>
</x-app-layout>
