<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Penyimpanan Ingredients') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Kitchen: <span class="font-semibold">{{ $kitchen->nama }}</span> ({{ $kitchen->code }})
                </p>
            </div>
            <a href="{{ route('ingredients.create') }}"
               class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-whitest uppercase tracking-widest hover:bg-primary/90 focus:bg-primary/90 active:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                + Input Ingredient Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm sm:rounded-lg mb-6">
                @php
                    $currentSortBy = $sortBy ?? request()->query('sort_by');
                    $currentSortOrder = $sortOrder ?? request()->query('sort_order', 'desc');
                @endphp
                <form id="ingredient-filter-form" method="GET" class="p-6 grid gap-4 md:grid-cols-3 items-end">
                    <input type="hidden" name="sort_by" value="{{ $currentSortBy }}" />
                    <input type="hidden" name="sort_order" value="{{ $currentSortOrder }}" />
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Cari Ingredient</label>
                        <input id="user-search-input" type="search" name="search" value="{{ $search ?? request()->query('search') }}" placeholder="Cari nama ingredient..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Filter Status</label>
                        <select id="user-status-select" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm">
                            <option value="all" @selected(($status ?? request()->query('status')) === 'all' || empty($status ?? request()->query('status')))>Semua Status</option>
                            <option value="Segar" @selected(($status ?? request()->query('status')) === 'Segar')>Segar</option>
                            <option value="Busuk" @selected(($status ?? request()->query('status')) === 'Busuk')>Busuk</option>
                            <option value="Unknown" @selected(($status ?? request()->query('status')) === 'Unknown')>Unknown</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <button type="submit" class="inline-flex w-full justify-center items-center px-4 py-2 bg-primary text-whitest rounded-md font-semibold text-sm hover:bg-primary/90 transition duration-150">
                            Terapkan
                        </button>
                    </div>
                </form>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($ingredients->isEmpty())
                        <div class="text-center py-12">
                            <div class="mb-4">
                                <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada ingredients</h3>
                            <p class="text-gray-600 mb-4">Mulai dengan menambahkan ingredient pertama Anda</p>
                            <a href="{{ route('ingredients.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-whitest rounded-md font-semibold text-sm hover:bg-primary/90 transition duration-200">
                                + Tambah Ingredient Pertama
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama', 'sort_order' => $currentSortBy === 'nama' && $currentSortOrder === 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-1">
                                                Nama <span class="text-xs">{{ $currentSortBy === 'nama' ? ($currentSortOrder === 'asc' ? '↑' : '↓') : '↕' }}</span>
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'tanggal_datang', 'sort_order' => $currentSortBy === 'tanggal_datang' && $currentSortOrder === 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-1">
                                                Tanggal Datang <span class="text-xs">{{ $currentSortBy === 'tanggal_datang' ? ($currentSortOrder === 'asc' ? '↑' : '↓') : '↕' }}</span>
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'kadaluarsa', 'sort_order' => $currentSortBy === 'kadaluarsa' && $currentSortOrder === 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-1">
                                                Kadaluarsa <span class="text-xs">{{ $currentSortBy === 'kadaluarsa' ? ($currentSortOrder === 'asc' ? '↑' : '↓') : '↕' }}</span>
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'kuantitas', 'sort_order' => $currentSortBy === 'kuantitas' && $currentSortOrder === 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-1">
                                                Kuantitas <span class="text-xs">{{ $currentSortBy === 'kuantitas' ? ($currentSortOrder === 'asc' ? '↑' : '↓') : '↕' }}</span>
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'status_kesegaran', 'sort_order' => $currentSortBy === 'status_kesegaran' && $currentSortOrder === 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-1">
                                                Status <span class="text-xs">{{ $currentSortBy === 'status_kesegaran' ? ($currentSortOrder === 'asc' ? '↑' : '↓') : '↕' }}</span>
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($ingredients as $item)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $item->nama }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($item->tanggal_datang)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($item->kadaluarsa)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->kuantitas }} {{ $item->satuan }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <x-freshness-badge :status="$item->status_kesegaran" />
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if ($item->foto)
                                                    <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama }}"
                                                         class="h-12 w-12 object-cover rounded-lg shadow-sm hover:shadow-md transition">
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center gap-4">
                                                    <a href="{{ route('ingredients.edit', $item) }}"
                                                       class="text-primary hover:text-primary/80 font-medium transition">
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('ingredients.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ingredient ini?');" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $ingredients->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('user-search-input');
            const statusSelect = document.getElementById('user-status-select');
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
                searchInput.addEventListener('input', debounce(submitFilter, 400));
            }

            if (statusSelect) {
                statusSelect.addEventListener('change', submitFilter);
            }
        });
    </script>
</x-app-layout>
