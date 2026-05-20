<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPEKA Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 antialiased h-full overflow-hidden">

    <div class="flex h-screen w-screen overflow-hidden">

        @include('partials.sidebar')

        <main class="flex-1 h-full overflow-y-auto p-8">
            <div class="py-6 bg-gray-50">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-6 bg-gray-50/50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <div class="lg:col-span-5 bg-white border-2 border-[#B2C3C4]/40 rounded-3xl shadow-sm p-6 flex flex-col justify-between">
                    <h3 class="font-bold text-lg text-[#242D2D] mb-4">Grafik Bahan</h3>

                    <div class="relative w-64 h-64 mx-auto flex items-center justify-center">
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
                                <span class="w-4 h-4 rounded-full bg-[#E5A000]"></span>
                                <span class="text-gray-700 font-medium">Rawan</span>
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

                <div class="lg:col-span-7 flex flex-col gap-6">

                    <div class="bg-white border-2 border-[#B2C3C4]/40 rounded-3xl shadow-sm p-6 flex-1">
                        <div class="mb-2">
                            <h3 class="font-bold text-lg text-[#242D2D]">Bahan Masuk</h3>
                            <p class="text-sm text-gray-500">7 hari terakhir</p>
                        </div>
                        <div class="w-full h-48">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white border-2 border-[#B2C3C4]/40 rounded-3xl shadow-sm p-8 flex flex-col items-center justify-center text-center h-44">
                        <h1 class="text-6xl font-black text-[#242D2D] tracking-tight mb-2">{{ $totalIngredients }}</h1>
                        <p class="text-lg font-medium text-[#242D2D]/80">Bahan Tersimpan Saat Ini</p>
                    </div>

                </div>
            </div>

            <div class="bg-[#FFFFFF] border-2 border-[#7EC9CE] rounded-3xl shadow-sm p-6">
                <div class="overflow-x-auto rounded-xl">
                    <table class="w-full text-left text-sm text-[#242D2D]">

                        <thead class="bg-[#7EC9CE] text-[#242D2D] text-base font-semibold">
                            <tr>
                                <th scope="col" class="px-6 py-4 rounded-tl-xl">Nama</th>
                                <th scope="col" class="px-6 py-4">Tanggal Masuk</th>
                                <th scope="col" class="px-6 py-4">Kuantitas</th>
                                <th scope="col" class="px-6 py-4">Status</th>
                                <th scope="col" class="px-6 py-4 rounded-tr-xl">Foto</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#B2C3C4]/40 font-medium">
                            @forelse ($ingredients as $ingredient)
                                @php
                                    $status = $ingredient->status_kesegaran;
                                    $label = match($status) {
                                        'segar'           => ['text' => 'Segar',  'class' => 'bg-[#22C55E]/20 text-[#22C55E]'],
                                        'tidak segar'     => ['text' => 'Busuk',  'class' => 'bg-[#EC221F] text-white'],
                                        'tidak diketahui' => ['text' => 'Rawan',  'class' => 'bg-[#E5A000] text-white'],
                                        default           => ['text' => '-',      'class' => 'bg-gray-100 text-gray-500'],
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50/40 transition">
                                    <td class="px-6 py-4">{{ $ingredient->nama }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ \Carbon\Carbon::parse($ingredient->tanggal_datang)->format('d M Y') }}</td>
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
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada bahan tersimpan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($ingredients->hasPages())
                    <div class="flex items-center justify-end pt-4 mt-4">
                        <div class="flex items-center space-x-1 bg-[#242D2D] p-1 rounded-lg text-[#FFFFFF] text-xs font-medium">
                            @if ($ingredients->onFirstPage())
                                <span class="px-2 py-1 opacity-30">&lt;</span>
                            @else
                                <a href="{{ $ingredients->previousPageUrl() }}" class="px-2 py-1 hover:bg-white/10 rounded">&lt;</a>
                            @endif

                            @foreach ($ingredients->getUrlRange(1, $ingredients->lastPage()) as $page => $url)
                                @if ($page == $ingredients->currentPage())
                                    <span class="px-2.5 py-1 bg-white/20 rounded text-[#7EC9CE]">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-2.5 py-1 hover:bg-white/10 rounded">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($ingredients->hasMorePages())
                                <a href="{{ $ingredients->nextPageUrl() }}" class="px-2 py-1 hover:bg-white/10 rounded">&gt;</a>
                            @else
                                <span class="px-2 py-1 opacity-30">&gt;</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

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
                    backgroundColor: ['#EC221F', '#E5A000', '#22C55E'],
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

        const lineCtx = document.getElementById('lineChart').getContext('2d');

        const gradient = lineCtx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(126, 201, 206, 0.4)');
        gradient.addColorStop(1, 'rgba(126, 201, 206, 0.0)');

        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($lineLabels) !!},
                datasets: [{
                    data: {!! json_encode($lineData) !!},
                    borderColor: '#7EC9CE',
                    borderWidth: 3,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#B2C3C4', font: { size: 10 } } },
                    y: { min: 0, ticks: { stepSize: 1, color: '#B2C3C4', font: { size: 10 } } }
                }
            }
        });
    </script>
