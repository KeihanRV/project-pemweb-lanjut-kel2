@if(method_exists($users, 'links'))
<div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 mt-6 border-t">
    <div class="flex items-center gap-2">
        <label for="per-page-select" class="text-sm font-medium">Per halaman:</label>
        <select name="per_page" id="per-page-select" form="user-filter-form" class="block rounded-md border px-3 py-1 bg-white">
            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
        </select>
    </div>

    <div class="custom-pagination">
        {{ $users->withQueryString()->links() }}
    </div>
</div>
@endif
