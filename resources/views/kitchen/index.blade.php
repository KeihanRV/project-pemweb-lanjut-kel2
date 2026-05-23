<x-app-layout>
    <div class="p-6">
        @include('kitchen.partial._toolbar')

        <div class="mt-4">
            @include('kitchen.partial._search')
        </div>

        <div class="mt-4">
            @include('kitchen.partial._table')
        </div>

        <div class="mt-4">
            @include('kitchen.partial._pagination')
        </div>

        @include('kitchen.partial._modal-delete')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.querySelector('#kitchen-filter-form input[name="q"]');
            const perPage = document.getElementById('per-page-select');
            const form = document.getElementById('kitchen-filter-form');

            const debounce = (fn, delay) => {
                let timeout;
                return (...args) => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => fn(...args), delay);
                };
            };

            if (input && form) {
                input.addEventListener('input', debounce(() => form.submit(), 400));
            }

            if (perPage && form) {
                perPage.addEventListener('change', () => form.submit());
            }
        });
    </script>
</x-app-layout>
