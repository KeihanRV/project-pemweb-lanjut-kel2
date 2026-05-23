<div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 mt-6 border-t border-[#B2C3C4]">
    <div class="flex items-center gap-2">
        <label for="per-page-select" class="text-sm font-medium text-[#242D2D] whitespace-nowrap">Per halaman:</label>
        <select name="per_page" id="per-page-select" form="kitchen-filter-form" class="block rounded-md border-[#B2C3C4] shadow-sm focus:border-[#7EC9CE] focus:ring-[#7EC9CE] sm:text-sm py-1 px-3 bg-white">
            <option value="10" @selected($perPage === 10)>10</option>
            <option value="25" @selected($perPage === 25)>25</option>
            <option value="100" @selected($perPage === 100)>100</option>
        </select>
    </div>

    <div class="mt-6">
        {{ $kitchens->withQueryString()->links() }}
    </div>
</div>
