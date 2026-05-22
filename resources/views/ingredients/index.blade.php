<x-app-layout>
    <div class="p-8">

        @php
            $currentSortBy = $sortBy ?? request()->query('sort_by');
            $currentSortOrder = $sortOrder ?? request()->query('sort_order', 'desc');
            $toggleOrder = fn ($field) => $currentSortBy === $field && $currentSortOrder === 'asc' ? 'desc' : 'asc';
            $sortArrow = fn ($field) => $currentSortBy === $field ? ($currentSortOrder === 'asc' ? '↑' : '↓') : '↕';
        @endphp

        <!-- Form Utama Filter, Pencarian, dan State Sorting -->
        <form method="GET" id="ingredient-filter-form" action="{{ url()->current() }}">
            <!-- Kunci parameter sorting aktif agar tidak hilang saat filter atau search berubah -->
            <input type="hidden" name="sort_by" value="{{ $currentSortBy }}" />
            <input type="hidden" name="sort_order" value="{{ $currentSortOrder }}" />

            <!-- DIV ATAS: Dropdown Pilih Kitchen & Tombol Tambah Produk (Sejajar) -->
            <div class="bg-white p-6 rounded-xl border border-[#B2C3C4] shadow-sm mb-6 max-w-[1200px] mx-auto">
                <div class="flex flex-col sm:flex-row items-end justify-between gap-4">
                    @if (auth()->user()->is_admin && $kitchens->isNotEmpty())
                        <div class="w-full sm:w-72">
                            <label class="block text-sm font-medium text-[#242D2D]">Pilih Kitchen</label>
                            <select name="kitchen" id="kitchen-select" class="mt-1 block w-full rounded-md border-[#B2C3C4] shadow-sm focus:border-[#7EC9CE] focus:ring-[#7EC9CE] sm:text-sm">
                                @foreach ($kitchens as $kitchen)
                                    <option value="{{ $kitchen->id }}" @selected(optional($selectedKitchen)->id == $kitchen->id)>
                                        {{ $kitchen->nama }} ({{ $kitchen->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div></div> <!-- Spacer penyeimbang layout jika bukan admin -->
                    @endif

                    <!-- Pindahan Tombol Tambah Produk (Sekarang di Div Atas) -->
                    <div class="w-full sm:w-auto">
                        <a href="{{ route('ingredients.create', ['kitchen' => optional($selectedKitchen)->id, 'per_page' => $perPage]) }}"
                           class="inline-flex w-full sm:w-auto justify-center items-center bg-[#242D2D] text-[#FFFFFF] px-6 py-2 rounded-lg text-sm font-semibold hover:bg-opacity-90 transition duration-150 whitespace-nowrap">
                            Tambah Produk
                        </a>
                    </div>
                </div>
            </div>

            <!-- DIV BAWAH DIV ATAS: Search Bar & Filter Status Kesegaran Bahan Makanan -->
            <div class="bg-white p-6 rounded-xl border border-[#B2C3C4] shadow-sm mb-6 max-w-[1200px] mx-auto grid gap-4 md:grid-cols-3 items-end">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-[#242D2D]">Cari Ingredient</label>
                    <input type="search" id="search-input" name="search" value="{{ $search ?? request()->query('search') }}" placeholder="Cari nama ingredient..." class="mt-1 block w-full rounded-md border-[#B2C3C4] shadow-sm focus:border-[#7EC9CE] focus:ring-[#7EC9CE] sm:text-sm" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-[#242D2D]">Filter Status</label>
                    <select name="status" id="status-select" class="mt-1 block w-full rounded-md border-[#B2C3C4] shadow-sm focus:border-[#7EC9CE] focus:ring-[#7EC9CE] sm:text-sm">
                        <option value="all" @selected(($status ?? request()->query('status')) === 'all' || empty($status ?? request()->query('status')))>Semua Status</option>
                        <option value="Segar" @selected(($status ?? request()->query('status')) === 'Segar')>Segar</option>
                        <option value="Busuk" @selected(($status ?? request()->query('status')) === 'Busuk')>Busuk</option>
                        <option value="Unknown" @selected(($status ?? request()->query('status')) === 'Unknown')>Unknown</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- Tempat Tabel Konten Utama -->
        <div class="bg-[#FFFFFF] border-2 border-[#7EC9CE] rounded-xl shadow-md p-6 max-w-[1200px] mx-auto font-sans">

            @if ($ingredients->isEmpty())
                <div class="text-center py-12 text-[#242D2D]/60">
                    Belum ada ingredients yang sesuai dengan filter pencarian.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-[#242D2D]">
                        <thead class="bg-[#7EC9CE] text-[#242D2D] text-base font-semibold">
                            <tr>
                                <!-- Perbaikan Tautan Urutan (ditambahkan 'page' => 1 agar sorting tidak merusak pagination) -->
                                <th scope="col" class="px-6 py-4 rounded-tl-lg">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama', 'sort_order' => $toggleOrder('nama'), 'page' => 1]) }}" class="flex items-center gap-2">
                                        Nama <span class="text-xs">{{ $sortArrow('nama') }}</span>
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'tanggal_datang', 'sort_order' => $toggleOrder('tanggal_datang'), 'page' => 1]) }}" class="flex items-center gap-2">
                                        Tanggal Masuk <span class="text-xs">{{ $sortArrow('tanggal_datang') }}</span>
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'kuantitas', 'sort_order' => $toggleOrder('kuantitas'), 'page' => 1]) }}" class="flex items-center gap-2">
                                        Kuantitas <span class="text-xs">{{ $sortArrow('kuantitas') }}</span>
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-4">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'status_kesegaran', 'sort_order' => $toggleOrder('status_kesegaran'), 'page' => 1]) }}" class="flex items-center gap-2">
                                        Status <span class="text-xs">{{ $sortArrow('status_kesegaran') }}</span>
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-4">Foto</th>
                                <th scope="col" class="px-6 py-4 rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#B2C3C4]">
                            @foreach ($ingredients as $item)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4 font-medium">{{ $item->nama }}</td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($item->tanggal_datang)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">{{ $item->kuantitas }} {{ $item->satuan }}</td>
                                    <td class="px-6 py-4">
                                        <x-freshness-badge :status="$item->status_kesegaran" />
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($item->foto)
                                            <a href="{{ Storage::url($item->foto) }}" target="_blank">
                                                <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama }}"
                                                     class="h-10 w-10 object-cover rounded-lg shadow-sm hover:shadow-md transition">
                                            </a>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-row items-center gap-4 text-sm font-medium">
                                            <a href="{{ route('ingredients.edit', [$item, 'kitchen' => optional($selectedKitchen)->id, 'per_page' => $perPage]) }}"
                                               class="text-[#7EC9CE] hover:underline">Edit</a>

                                            <form action="{{ route('ingredients.destroy', $item) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus ingredient ini?');"
                                                  class="m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                @if(optional($selectedKitchen)->id)
                                                    <input type="hidden" name="kitchen_id" value="{{ $selectedKitchen->id }}">
                                                @endif
                                                <button type="submit" class="text-[#EC221F] hover:underline">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- DIV BAWAH: Dropdown Per Halaman dipindah sejajar dengan Tombol Pagination -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 mt-6 border-t border-[#B2C3C4]">
                <div class="flex items-center gap-2">
                    <label for="per-page-select" class="text-sm font-medium text-[#242D2D] whitespace-nowrap">Per halaman:</label>
                    <!-- Ditambahkan atribut form="ingredient-filter-form" agar terikat dengan form filter utama di atas -->
                    <select name="per_page" id="per-page-select" form="ingredient-filter-form" class="block rounded-md border-[#B2C3C4] shadow-sm focus:border-[#7EC9CE] focus:ring-[#7EC9CE] sm:text-sm py-1 px-3 bg-white">
                        <option value="10" @selected($perPage === 10)>10</option>
                        <option value="25" @selected($perPage === 25)>25</option>
                        <option value="100" @selected($perPage === 100)>100</option>
                    </select>
                </div>

                <div class="custom-pagination">
                    {{ $ingredients->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Script Pemicu Otomatis Form -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const kitchenSelect = document.getElementById('kitchen-select');
            const statusSelect = document.getElementById('status-select');
            const perPageSelect = document.getElementById('per-page-select');
            const form = document.getElementById('ingredient-filter-form');

            const debounce = (fn, delay) => {
                let timeout;
                return (...args) => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => fn(...args), delay);
                };
            };

            const submitFilter = () => form.submit();

            if (searchInput) {
                // Input pencarian akan men-submit form setelah user selesai mengetik (delay 400ms)
                searchInput.addEventListener('input', debounce(submitFilter, 400));
            }

            // Dropdown kitchen, status kesegaran, dan per halaman memicu reload submit langsung
            [kitchenSelect, statusSelect, perPageSelect].forEach((element) => {
                if (element) {
                    element.addEventListener('change', submitFilter);
                }
            });
        });
    </script>
</x-app-layout>