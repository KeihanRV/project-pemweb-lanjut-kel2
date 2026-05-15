<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Penyimpanan Ingredients') }}
            </h2>
            <a href="{{ route('ingredients.create', ['kitchen' => optional($selectedKitchen)->id, 'per_page' => $perPage]) }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Input Ingredient Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($kitchens->isNotEmpty())
                        <form method="GET" class="mb-6 grid gap-4 md:grid-cols-3 items-end">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pilih Kitchen</label>
                                <select name="kitchen" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @foreach ($kitchens as $kitchen)
                                        <option value="{{ $kitchen->id }}" @selected(optional($selectedKitchen)->id == $kitchen->id)>
                                            {{ $kitchen->nama }} ({{ $kitchen->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Per halaman</label>
                                <select name="per_page" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="10" @selected($perPage === 10)>10</option>
                                    <option value="25" @selected($perPage === 25)>25</option>
                                    <option value="100" @selected($perPage === 100)>100</option>
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="inline-flex w-full justify-center items-center px-4 py-2 bg-indigo-600 text-white rounded-md font-semibold text-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Tampilkan
                                </button>
                            </div>
                        </form>
                    @endif

                    @if ($ingredients->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            Belum ada ingredients. Klik "Input Ingredient Baru" untuk memulai.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Datang</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kadaluarsa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kuantitas</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($ingredients as $item)
                                        <tr class="hover:bg-gray-50">
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
                                                @if ($item->status_kesegaran === 'segar')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Segar
                                                    </span>
                                                @elseif ($item->status_kesegaran === 'tidak segar')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Tidak Segar
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Tidak Diketahui
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if ($item->foto)
                                                    <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->nama }}"
                                                         class="h-12 w-12 object-cover rounded">
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center gap-4">
                                                    <a href="{{ route('ingredients.edit', [$item, 'kitchen' => optional($selectedKitchen)->id, 'per_page' => $perPage]) }}"
                                                       class="text-indigo-600 hover:text-indigo-900">
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('ingredients.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ingredient ini dari kitchen saat ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        @if(optional($selectedKitchen)->id)
                                                            <input type="hidden" name="kitchen_id" value="{{ $selectedKitchen->id }}">
                                                        @endif
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
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
                            {{ $ingredients->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
