<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-8 px-4 sm:px-6 lg:px-8 space-y-6 font-sans">

        {{-- Stat cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white border-2 border-[#B2C3C4]/40 rounded-3xl p-6 flex flex-col items-center justify-center text-center shadow-sm">
                <span class="text-5xl font-black text-[#242D2D]">{{ $totalIngredients }}</span>
                <span class="mt-2 text-sm font-medium text-gray-500">Total Bahan</span>
            </div>
            <div class="bg-white border-2 border-[#B2C3C4]/40 rounded-3xl p-6 flex flex-col items-center justify-center text-center shadow-sm">
                <span class="text-5xl font-black text-[#242D2D]">{{ $totalKitchens }}</span>
                <span class="mt-2 text-sm font-medium text-gray-500">Total Dapur</span>
            </div>
            <div class="bg-white border-2 border-[#B2C3C4]/40 rounded-3xl p-6 flex flex-col items-center justify-center text-center shadow-sm">
                <span class="text-5xl font-black text-[#242D2D]">{{ $totalUsers }}</span>
                <span class="mt-2 text-sm font-medium text-gray-500">Total Pengguna</span>
            </div>
        </div>

        {{-- Donut chart + per-kitchen table --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <div class="lg:col-span-4 bg-white border-2 border-[#B2C3C4]/40 rounded-3xl shadow-sm p-6 flex flex-col justify-between">
                <h3 class="font-bold text-lg text-[#242D2D] mb-4">Grafik Kesegaran (Semua Dapur)</h3>

                <div class="relative w-52 h-52 mx-auto flex items-center justify-center">
                    <canvas id="donutChart"></canvas>
                </div>

                <div class="mt-6 space-y-3 max-w-[200px] mx-auto w-full">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full bg-[#EC221F]"></span>
                            <span class="text-gray-700 font-medium">Busuk</span>
                        </div>
                        <span class="text-gray-500 text-sm">{{ $donutData['tidak segar'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full bg-gray-400"></span>
                            <span class="text-gray-700 font-medium">Unknown</span>
                        </div>
                        <span class="text-gray-500 text-sm">{{ $donutData['tidak diketahui'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full bg-[#22C55E]"></span>
                            <span class="text-gray-700 font-medium">Segar</span>
                        </div>
                        <span class="text-gray-500 text-sm">{{ $donutData['segar'] }}</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 bg-white border-2 border-[#B2C3C4]/40 rounded-3xl shadow-sm p-6">
                <h3 class="font-bold text-lg text-[#242D2D] mb-4">Ringkasan Per Dapur</h3>
                <div class="overflow-x-auto rounded-xl">
                    <table class="w-full text-left text-sm text-[#242D2D]">
                        <thead class="bg-[#7EC9CE] text-[#242D2D] text-sm font-semibold">
                            <tr>
                                <th class="px-5 py-3 rounded-tl-xl">Nama Dapur</th>
                                <th class="px-5 py-3">Lokasi</th>
                                <th class="px-5 py-3 rounded-tr-xl text-right">Jumlah Bahan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#B2C3C4]/40 font-medium">
                            @forelse ($kitchens as $kitchen)
                                <tr class="hover:bg-gray-50/40 transition">
                                    <td class="px-5 py-3">{{ $kitchen->nama }}</td>
                                    <td class="px-5 py-3 text-gray-500">{{ $kitchen->lokasi ?? '-' }}</td>
                                    <td class="px-5 py-3 text-right font-bold text-[#242D2D]">{{ $kitchen->ingredients_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-6 text-center text-gray-400">Belum ada dapur terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Recent ingredients across all kitchens --}}
        <div class="bg-white border-2 border-[#7EC9CE] rounded-3xl shadow-sm p-6">
            <h3 class="font-bold text-lg text-[#242D2D] mb-4">Bahan Terbaru (Semua Dapur)</h3>
            <div class="overflow-x-auto rounded-xl">
                <table class="w-full text-left text-sm text-[#242D2D]">
                    <thead class="bg-[#7EC9CE] text-[#242D2D] text-sm font-semibold">
                        <tr>
                            <th class="px-6 py-4 rounded-tl-xl">Nama</th>
                            <th class="px-6 py-4">Dapur</th>
                            <th class="px-6 py-4">Tanggal Masuk</th>
                            <th class="px-6 py-4">Kuantitas</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 rounded-tr-xl">Foto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#B2C3C4]/40 font-medium">
                        @forelse ($recentIngredients as $ingredient)
                            @php
                                $label = match($ingredient->status_kesegaran) {
                                    'segar'           => ['text' => 'Segar', 'class' => 'bg-[#22C55E]/20 text-[#22C55E]'],
                                    'tidak segar'     => ['text' => 'Busuk', 'class' => 'bg-[#EC221F] text-white'],
                                    'tidak diketahui' => ['text' => 'Unknown', 'class' => 'bg-gray-200 text-gray-600'],
                                    default           => ['text' => '-',     'class' => 'bg-gray-100 text-gray-500'],
                                };
                            @endphp
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="px-6 py-4">{{ $ingredient->nama }}</td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $ingredient->kitchens->pluck('nama')->join(', ') ?: '-' }}
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ \Carbon\Carbon::parse($ingredient->tanggal_datang)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $ingredient->kuantitas }} {{ $ingredient->satuan }}</td>
                                <td class="px-6 py-4">
                                    <span class="{{ $label['class'] }} px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wide">
                                        {{ $label['text'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($ingredient->foto)
                                        <a href="{{ asset('storage/' . $ingredient->foto) }}" target="_blank" class="text-[#7EC9CE] hover:underline">Lihat</a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada bahan tersimpan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($recentIngredients->hasPages())
                <div class="flex items-center justify-end pt-4 mt-4">
                    <div class="flex items-center space-x-1 bg-[#242D2D] p-1 rounded-lg text-white text-xs font-medium">
                        @if ($recentIngredients->onFirstPage())
                            <span class="px-2 py-1 opacity-30">&lt;</span>
                        @else
                            <a href="{{ $recentIngredients->previousPageUrl() }}" class="px-2 py-1 hover:bg-white/10 rounded">&lt;</a>
                        @endif

                        @foreach ($recentIngredients->getUrlRange(1, $recentIngredients->lastPage()) as $page => $url)
                            @if ($page == $recentIngredients->currentPage())
                                <span class="px-2.5 py-1 bg-white/20 rounded text-[#7EC9CE]">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-2.5 py-1 hover:bg-white/10 rounded">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($recentIngredients->hasMorePages())
                            <a href="{{ $recentIngredients->nextPageUrl() }}" class="px-2 py-1 hover:bg-white/10 rounded">&gt;</a>
                        @else
                            <span class="px-2 py-1 opacity-30">&gt;</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        {{ $donutData['tidak segar'] }},
                        {{ $donutData['tidak diketahui'] }},
                        {{ $donutData['segar'] }}
                    ],
                    backgroundColor: ['#EC221F', '#9CA3AF', '#22C55E'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: { legend: { display: false } }
            }
        });
    </script>
</x-app-layout>
