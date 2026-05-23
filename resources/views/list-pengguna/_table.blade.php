<div class="overflow-x-auto bg-white rounded-lg shadow">
    @php
        $currentSort = request('sort');
        $toggleOrder = function ($field) use ($currentSort) {
            return $currentSort === $field . '_asc' ? $field . '_desc' : $field . '_asc';
        };
        $sortArrow = function ($field) use ($currentSort) {
            if ($currentSort === $field . '_asc') return '↑';
            if ($currentSort === $field . '_desc') return '↓';
            return '↕';
        };
    @endphp

    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => $toggleOrder('name'), 'page' => 1]) }}">Nama <span class="ml-1">{{ $sortArrow('name') }}</span></a>
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => $toggleOrder('email'), 'page' => 1]) }}">Email <span class="ml-1">{{ $sortArrow('email') }}</span></a>
                </th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Admin</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if(method_exists($user, 'isSystemUser') && $user->isSystemUser())
                            <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">System</span>
                        @else
                            @if($user->is_admin)
                                <button type="button"
                                        class="inline-flex items-center gap-2 rounded-lg bg-danger hover:bg-red-700 px-3 py-2 text-xs font-semibold text-white transition duration-150"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-admin="1"
                                        onclick="openAdminModal(this)">
                                    Revoke
                                </button>
                            @else
                                <button type="button"
                                        class="inline-flex items-center gap-2 rounded-lg bg-success hover:bg-green-700 px-3 py-2 text-xs font-semibold text-white transition duration-150"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-admin="0"
                                        onclick="openAdminModal(this)">
                                    Grant
                                </button>
                            @endif
                        @endif
                    
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        @if(method_exists($user, 'isSystemUser') && $user->isSystemUser())
                            <span class="text-gray-400 mr-2">Edit</span>
                            <span class="text-gray-400">Hapus</span>
                        @else
                            <a href="{{ route('pengguna-edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                            <button type="button" class="text-red-600 hover:text-red-900" data-id="{{ $user->id }}" data-name="{{ $user->name }}" onclick="openDeleteModal(this)">Hapus</button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada pengguna.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
