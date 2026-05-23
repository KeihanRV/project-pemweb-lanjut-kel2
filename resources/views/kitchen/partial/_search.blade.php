@php
    $currentSortBy = $sortBy ?? request()->query('sort_by');
    $currentSortOrder = $sortOrder ?? request()->query('sort_order', 'desc');
@endphp

<form id="kitchen-filter-form" method="GET" class="bg-white rounded-xl shadow-sm p-6 grid gap-4 md:grid-cols-3 items-end">
    <input type="hidden" name="sort_by" value="{{ $currentSortBy }}" />
    <input type="hidden" name="sort_order" value="{{ $currentSortOrder }}" />

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Cari Kitchen</label>
        <input type="search" name="q" value="{{ $q ?? request()->query('q') }}" placeholder="Cari nama atau lokasi..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" />
    </div>

    <div class="flex items-center">
        <button type="submit" class="inline-flex w-full justify-center items-center px-4 py-2 bg-primary text-white rounded-md font-semibold text-sm hover:bg-primary/90 transition duration-150">
            Terapkan
        </button>
    </div>
</form>
