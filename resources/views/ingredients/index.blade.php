
<<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPEKA List</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 antialiased h-full overflow-hidden">

    <div class="flex h-screen w-screen overflow-hidden">
        
        @include('partials.sidebar') 
    
        <main class="flex-1 h-full overflow-y-auto p-8">
            <div class="py-6 bg-gray-50">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if ($kitchens->isNotEmpty())
                <div class="bg-white p-6 rounded-xl border border-[#B2C3C4] shadow-sm mb-6 max-w-[1200px] mx-auto">
                    <form method="GET" class="grid gap-4 md:grid-cols-3 items-end">
                        <div>
                            <label class="block text-sm font-medium text-[#242D2D]">Pilih Kitchen</label>
                            <select name="kitchen" class="mt-1 block w-full rounded-md border-[#B2C3C4] shadow-sm focus:border-[#7EC9CE] focus:ring-[#7EC9CE] sm:text-sm">
                                @foreach ($kitchens as $kitchen)
                                    <option value="{{ $kitchen->id }}" @selected(optional($selectedKitchen)->id == $kitchen->id)>
                                        {{ $kitchen->nama }} ({{ $kitchen->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#242D2D]">Per halaman</label>
                            <select name="per_page" class="mt-1 block w-full rounded-md border-[#B2C3C4] shadow-sm focus:border-[#7EC9CE] focus:ring-[#7EC9CE] sm:text-sm">
                                <option value="10" @selected($perPage === 10)>10</option>
                                <option value="25" @selected($perPage === 25)>25</option>
                                <option value="100" @selected($perPage === 100)>100</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="inline-flex w-full justify-center items-center px-4 py-2 bg-[#7EC9CE] text-[#242D2D] rounded-md font-semibold text-sm hover:bg-opacity-90 shadow-sm transition">
                                Tampilkan
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="bg-[#FFFFFF] border-2 border-[#7EC9CE] rounded-xl shadow-md p-6 max-w-[1200px] mx-auto font-sans">
                
                @if ($ingredients->isEmpty())
                    <div class="text-center py-12 text-[#242D2D]/60">
                        Belum ada ingredients. Klik <strong class="text-[#242D2D]">Tambah Produk</strong> di bawah untuk memulai.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-[#242D2D]">
                            
                            <thead class="bg-[#7EC9CE] text-[#242D2D] text-base font-semibold">
                                <tr>
                                    <th scope="col" class="px-6 py-4 rounded-tl-lg">Nama</th>
                                    <th scope="col" class="px-6 py-4">Tanggal Masuk</th>
                                    <th scope="col" class="px-6 py-4">Kuantitas</th>
                                    <th scope="col" class="px-6 py-4">Status</th>
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
                                            @if ($item->status_kesegaran === 'segar')
                                                <span class="bg-[#B2C3C4] text-[#242D2D] px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider">Segar</span>
                                            @elseif ($item->status_kesegaran === 'tidak segar' || $item->status_kesegaran === 'busuk')
                                                <span class="bg-[#EC221F] text-[#FFFFFF] px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider">Busuk</span>
                                            @else
                                                <span class="bg-[#E5A000] text-[#FFFFFF] px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider">Rawan</span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4">
                                            @if ($item->foto)
                                                <a href="{{ Storage::url($item->foto) }}" target="_blank" class="text-[#7EC9CE] hover:underline font-medium">
                                                    View_Image.png
                                                </a>
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4 text-sm font-medium">
                                                <a href="{{ route('ingredients.edit', [$item, 'kitchen' => optional($selectedKitchen)->id, 'per_page' => $perPage]) }}"
                                                   class="text-[#7EC9CE] hover:underline">
                                                    Edit
                                                </a>

                                                <form action="{{ route('ingredients.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ingredient ini?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    @if(optional($selectedKitchen)->id)
                                                        <input type="hidden" name="kitchen_id" value="{{ $selectedKitchen->id }}">
                                                    @endif
                                                    <button type="submit" class="text-[#EC221F] hover:underline">
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
                @endif

                <div class="flex items-center justify-between pt-6 mt-6 border-t border-[#B2C3C4]">
                    
                    <a href="{{ route('ingredients.create', ['kitchen' => optional($selectedKitchen)->id, 'per_page' => $perPage]) }}"
                       class="inline-block bg-[#242D2D] text-[#FFFFFF] px-6 py-2 rounded-lg text-sm font-semibold hover:bg-opacity-90 transition duration-150">
                        Tambah Produk
                    </a>
                    
                    <div class="custom-pagination">
                        {{ $ingredients->withQueryString()->links() }}
                    </div>
                </div>

            </div>
        </div>
   