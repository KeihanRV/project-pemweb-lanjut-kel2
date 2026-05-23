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

        <main class="flex-1 h-full overflow-y-auto p-6 md:p-8 font-sans">
            <div class="max-w-7xl mx-auto space-y-6">
                
                <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                    <div>
                        <h3 class="text-3xl font-bold tracking-tight text-gray-900">Dashboard</h3>
                        @if (auth()->user()->is_admin)
                            <p class="text-sm text-gray-500">Selamat datang di admin section SIPEKA.</p>
                        @else
                            <p class="text-sm text-gray-500">Lihat ringkasan data dan aktivitas terbaru di SIPEKA.</p>
                        @endif
                    </div>
                </div>

                @if(auth()->user()->is_admin)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 flex items-center space-x-4">
                            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah User</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-0.5">{{ $totalUsers ?? 0 }}</h3>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 flex items-center space-x-4">
                            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0V11m0 5H9m11-4a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Kitchen</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-0.5">{{ $totalKitchens ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <div class="lg:col-span-5 bg-white border border-gray-200 rounded-2xl shadow-sm p-6 flex flex-col justify-between">
                        <h3 class="font-semibold text-base text-gray-900 mb-4">Grafik Bahan</h3>
                        <div class="relative w-56 h-56 mx-auto flex items-center justify-center">
                            <canvas id="donutChart"></canvas>
                        </div>
                        <div class="mt-6 space-y-2.5 max-w-[220px] mx-auto w-full text-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                    <span class="text-gray-600">Segar</span>
                                </div>
                                <span class="text-gray-900 font-semibold">{{ $donutData['Segar'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                                    <span class="text-gray-600">Busuk</span>
                                </div>
                                <span class="text-gray-900 font-semibold">{{ $donutData['Busuk'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-gray-400"></span>
                                    <span class="text-gray-600">Unknown</span>
                                </div>
                                <span class="text-gray-900 font-semibold">{{ $donutData['Unknown'] }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-7 flex flex-col gap-6">
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 flex-1">
                            <div class="mb-4">
                                <h3 class="font-semibold text-base text-gray-900">Bahan Masuk</h3>
                                <p class="text-xs text-gray-500">Analisis data 7 hari terakhir</p>
                            </div>
                            <div class="w-full h-44">
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Bahan Tersimpan Saat Ini</p>
                                <h1 class="text-4xl font-bold text-gray-900 tracking-tight mt-1">{{ $totalIngredients }}</h1>
                            </div>
                            <div class="p-3 bg-slate-100 rounded-xl text-slate-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 font-semibold text-xs uppercase tracking-wider">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5">Nama</th>
                                    <th scope="col" class="px-6 py-3.5">Tanggal Masuk</th>
                                    <th scope="col" class="px-6 py-3.5">Kuantitas</th>
                                    <th scope="col" class="px-6 py-3.5">Status</th>
                                    <th scope="col" class="px-6 py-3.5 text-center">Foto</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($ingredients as $ingredient)
                                    <tr class="hover:bg-gray-50/70 transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $ingredient->nama }}</td>
                                        <td class="px-6 py-4 text-gray-500">{{ \Carbon\Carbon::parse($ingredient->tanggal_datang)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 text-gray-500">{{ $ingredient->kuantitas }} {{ $ingredient->satuan }}</td>
                                        <td class="px-6 py-4"><x-freshness-badge :status="$ingredient->status_kesegaran" /></td>
                                        <td class="px-6 py-4 flex justify-center">
                                            @if ($ingredient->foto)
                                                <a href="{{ asset('storage/' . $ingredient->foto) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $ingredient->foto) }}" alt="{{ $ingredient->nama }}" class="h-9 w-9 object-cover rounded-lg border border-gray-200 hover:scale-105 transition-transform duration-150">
                                                </a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada data bahan makanan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($ingredients->hasPages())
                        <div class="flex items-center justify-between border-t border-gray-200 px-6 py-3.5 bg-gray-50/50">
                            <span class="text-xs text-gray-500">
                                Halaman <span class="font-medium text-gray-700">{{ $ingredients->currentPage() }}</span> dari <span class="font-medium text-gray-700">{{ $ingredients->lastPage() }}</span>
                            </span>
                            
                            <div class="flex items-center space-x-3">
                                <form action="{{ request()->url() }}" method="GET" class="flex items-center space-x-1.5">
                                    @foreach(request()->except('page') as $key => $value)
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endforeach
                                    <label for="custom_page" class="text-xs text-gray-500">Lompat ke:</label>
                                    <input type="number" id="custom_page" name="page" min="1" max="{{ $ingredients->lastPage() }}" placeholder="{{ $ingredients->currentPage() }}" class="w-12 text-center p-1 text-xs border border-gray-300 rounded focus:ring-1 focus:ring-slate-500 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </form>

                                <div class="inline-flex space-x-1">
                                    @if ($ingredients->onFirstPage())
                                        <span class="p-1.5 text-gray-300 bg-gray-100 rounded-md cursor-not-allowed text-xs">&larr; Prev</span>
                                     @else
                                        <a href="{{ $ingredients->previousPageUrl() }}" class="p-1.5 text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-md text-xs transition font-medium shadow-sm">&larr; Prev</a>
                                    @endif

                                    @if ($ingredients->hasMorePages())
                                        <a href="{{ $ingredients->nextPageUrl() }}" class="p-1.5 text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-md text-xs transition font-medium shadow-sm">Next &rarr;</a>
                                    @else
                                        <span class="p-1.5 text-gray-300 bg-gray-100 rounded-md cursor-not-allowed text-xs">Next &rarr;</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Menggunakan warna-warna modern tailwind secara langsung via HEX murni
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [{{ $donutData['Segar'] }}, {{ $donutData['Busuk'] }}, {{ $donutData['Unknown'] }}],
                    backgroundColor: ['#10B981', '#F43F5E', '#9CA3AF'],
                    borderWidth: 4,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: { legend: { display: false } }
            }
        });

        const lineCtx = document.getElementById('lineChart').getContext('2d');
        const gradient = lineCtx.createLinearGradient(0, 0, 0, 160);
        gradient.addColorStop(0, 'rgba(14, 165, 233, 0.15)');
        gradient.addColorStop(1, 'rgba(14, 165, 233, 0.0)');

        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($lineLabels) !!},
                datasets: [{
                    data: {!! json_encode($lineData) !!},
                    borderColor: '#0EA5E9',
                    borderWidth: 2.5,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.35,
                    pointRadius: 1,
                    pointHoverRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#9CA3AF', font: { size: 11 } } },
                    y: { grid: { color: '#F3F4F6' }, min: 0, ticks: { stepSize: 1, color: '#9CA3AF', font: { size: 11 } } }
                }
            }
        });

        // Auto submit saat input pagination diketik lalu ditekan Enter
        document.getElementById('custom_page')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    </script>
</body>
</html>