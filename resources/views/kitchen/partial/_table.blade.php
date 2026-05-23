<div class="overflow-x-auto bg-white rounded-lg shadow">
    @php
        $currentSortBy = $sortBy ?? request()->query('sort_by');
        $currentSortOrder = $sortOrder ?? request()->query('sort_order', 'desc');
    @endphp

    <table class="min-w-full table-fixed divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="w-1/4 px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama', 'sort_order' => $currentSortBy === 'nama' && $currentSortOrder === 'asc' ? 'desc' : 'asc']) }}">Nama <span class="ml-1">{{ $currentSortBy === 'nama' ? ($currentSortOrder === 'asc' ? '↑' : '↓') : '↕' }}</span></a>
                </th>
                <th class="w-1/2 px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'lokasi', 'sort_order' => $currentSortBy === 'lokasi' && $currentSortOrder === 'asc' ? 'desc' : 'asc']) }}">Lokasi <span class="ml-1">{{ $currentSortBy === 'lokasi' ? ($currentSortOrder === 'asc' ? '↑' : '↓') : '↕' }}</span></a>
                </th>
                <th class="w-1/8 px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'code', 'sort_order' => $currentSortBy === 'code' && $currentSortOrder === 'asc' ? 'desc' : 'asc']) }}">Code <span class="ml-1">{{ $currentSortBy === 'code' ? ($currentSortOrder === 'asc' ? '↑' : '↓') : '↕' }}</span></a>
                </th>
                <th class="w-1/8 px-5 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($kitchens as $kitchen)
                <tr>
                    <td class="px-5 py-4 text-sm font-medium text-gray-900 break-words">
                        {{ $kitchen->nama }}
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-500 break-words">
                        {{ $kitchen->lokasi }}
                    </td>
                    <td class="px-5 py-4 text-sm font-mono font-bold text-slate-800 break-words">
                        {{ $kitchen->code }}
                    </td>
                    <td class="px-5 py-4 text-center text-sm font-medium">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('kitchens-edit', $kitchen->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <span class="text-gray-300">|</span>
                            <button type="button" class="text-red-600 hover:text-red-900" data-id="{{ $kitchen->id }}" data-name="{{ $kitchen->nama }}" onclick="openKitchenDeleteModal(this)">Hapus</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-5 py-4 text-center text-sm text-gray-500">Belum ada kitchen.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>