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
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-4 h-4 rounded-full bg-[#E5A000]"></span>
                                <span class="text-gray-700 font-medium">Rawan</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-4 h-4 rounded-full bg-[#22C55E]"></span>
                                <span class="text-gray-700 font-medium">Segar</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7 flex flex-col gap-6">
                    
                    <div class="bg-white border-2 border-[#B2C3C4]/40 rounded-3xl shadow-sm p-6 flex-1">
                        <div class="mb-2">
                            <h3 class="font-bold text-lg text-[#242D2D]">Bahan Masuk</h3>
                            <p class="text-sm text-gray-500">
                                <span class="text-green-500 font-bold">(+500) more</span> in 12 Mei
                            </p>
                        </div>
                        <div class="w-full h-48">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>

                    <div class="bg-white border-2 border-[#B2C3C4]/40 rounded-3xl shadow-sm p-8 flex flex-col items-center justify-center text-center h-44">
                        <h1 class="text-6xl font-black text-[#242D2D] tracking-tight mb-2">500</h1>
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
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="px-6 py-4">Skibidi</td>
                                <td class="px-6 py-4 text-gray-500">12 Mei 2026</td>
                                <td class="px-6 py-4 text-gray-500">100 buah</td>
                                <td class="px-6 py-4">
                                    <span class="bg-[#EC221F] text-[#FFFFFF] px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wide">Busuk</span>
                                </td>
                                <td class="px-6 py-4"><a href="#" class="text-[#7EC9CE] hover:underline">Lihat</a></td>
                            </tr>
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="px-6 py-4">Bawang</td>
                                <td class="px-6 py-4 text-gray-500">12 Mei 2026</td>
                                <td class="px-6 py-4 text-gray-500">100 kg</td>
                                <td class="px-6 py-4">
                                    <span class="bg-[#E5A000] text-[#FFFFFF] px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wide">Rawan</span>
                                </td>
                                <td class="px-6 py-4"><a href="#" class="text-[#7EC9CE] hover:underline">Lihat</a></td>
                            </tr>
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="px-6 py-4">Ketela</td>
                                <td class="px-6 py-4 text-gray-500">12 Mei 2026</td>
                                <td class="px-6 py-4 text-gray-500">100 buah</td>
                                <td class="px-6 py-4">
                                    <span class="bg-[#E5A000] text-[#FFFFFF] px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wide">Rawan</span>
                                </td>
                                <td class="px-6 py-4"><a href="#" class="text-[#7EC9CE] hover:underline">Lihat</a></td>
                            </tr>
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="px-6 py-4">Tomat</td>
                                <td class="px-6 py-4 text-gray-500">12 Mei 2026</td>
                                <td class="px-6 py-4 text-gray-500">100 buah</td>
                                <td class="px-6 py-4">
                                    <span class="bg-[#22C55E]/20 text-[#22C55E] px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wide">Segar</span>
                                </td>
                                <td class="px-6 py-4"><a href="#" class="text-[#7EC9CE] hover:underline">Lihat</a></td>
                            </tr>
                            <tr class="hover:bg-gray-50/40 transition">
                                <td class="px-6 py-4">Cabai</td>
                                <td class="px-6 py-4 text-gray-500">12 Mei 2026</td>
                                <td class="px-6 py-4 text-gray-500">100 Kg</td>
                                <td class="px-6 py-4">
                                    <span class="bg-[#22C55E]/20 text-[#22C55E] px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wide">Segar</span>
                                </td>
                                <td class="px-6 py-4"><a href="#" class="text-[#7EC9CE] hover:underline">Lihat</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-end pt-4 mt-4">
                    <div class="flex items-center space-x-1 bg-[#242D2D] p-1 rounded-lg text-[#FFFFFF] text-xs font-medium">
                        <button class="px-2 py-1 hover:bg-white/10 rounded">&lt;</button>
                        <button class="px-2.5 py-1 bg-white/20 rounded text-[#7EC9CE]">1</button>
                        <button class="px-2.5 py-1 hover:bg-white/10 rounded">2</button>
                        <button class="px-2.5 py-1 hover:bg-white/10 rounded">3</button>
                        <button class="px-2.5 py-1 hover:bg-white/10 rounded">4</button>
                        <button class="px-2.5 py-1 hover:bg-white/10 rounded">5</button>
                        <button class="px-2.5 py-1 hover:bg-white/10 rounded">6</button>
                        <button class="px-2 py-1 hover:bg-white/10 rounded">&gt;</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // 1. Donut Chart Setup (Grafik Bahan)
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [20, 35, 45], // Representing slice segments roughly from image
                    backgroundColor: ['#EC221F', '#E5A000', '#22C55E'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%', // Makes it a thin donut ring matching design
                plugins: { legend: { display: false } }
            }
        });

        // 2. Smooth Area Line Chart Setup (Bahan Masuk)
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        
        // Gradient assignment to give that fading light teal aesthetic under the curve
        const gradient = lineCtx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(126, 201, 206, 0.4)');
        gradient.addColorStop(1, 'rgba(126, 201, 206, 0.0)');

        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Minggu'],
                datasets: [{
                    data: [180, 220, 350, 450, 310, 250, 420], // Approximated wave points
                    borderColor: '#7EC9CE',
                    borderWidth: 3,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.4, // Curves the straight lines softly
                    pointRadius: 0 // Removes ugly dot vertex markers matching design clean style
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#B2C3C4', font: { size: 10 } } },
                    y: { min: 0, max: 500, ticks: { stepSize: 100, color: '#B2C3C4', font: { size: 10 } } }
                }
            }
        });
    </script>
