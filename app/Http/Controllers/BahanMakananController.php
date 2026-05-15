<?php

namespace App\Http\Controllers;

use App\Models\BahanMakanan;
use App\Services\FreshnessService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BahanMakananController extends Controller
{
    public function __construct(
        protected FreshnessService $freshnessService
    ) {}

    public function index(): View
    {
        $bahan = BahanMakanan::orderBy('created_at', 'desc')->get();

        return view('bahan-makanan.index', compact('bahan'));
    }

    public function create(): View
    {
        return view('bahan-makanan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_masuk' => ['required', 'date'],
            'kuantitas' => ['required', 'integer', 'min:1'],
            'satuan' => ['required', 'string', 'max:50'],
            'foto' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        $path = $request->file('foto')->store('bahan_makanan', 'public');
        $absolutePath = Storage::disk('public')->path($path);

        $result = $this->freshnessService->check($absolutePath);
        $status = $this->mapPrediction($result['prediction'] ?? 'unknown');

        BahanMakanan::create([
            'nama' => $validated['nama'],
            'tanggal_masuk' => $validated['tanggal_masuk'],
            'kuantitas' => $validated['kuantitas'],
            'satuan' => $validated['satuan'],
            'foto' => $path,
            'status' => $status,
        ]);

        return redirect()->route('bahan-makanan.index')
            ->with('success', 'Bahan makanan berhasil ditambahkan.');
    }

    public function edit(BahanMakanan $bahanMakanan): View
    {
        return view('bahan-makanan.edit', [
            'bahan' => $bahanMakanan,
        ]);
    }

    public function update(Request $request, BahanMakanan $bahanMakanan): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_masuk' => ['required', 'date'],
            'kuantitas' => ['required', 'integer', 'min:1'],
            'satuan' => ['required', 'string', 'max:50'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        $data = [
            'nama' => $validated['nama'],
            'tanggal_masuk' => $validated['tanggal_masuk'],
            'kuantitas' => $validated['kuantitas'],
            'satuan' => $validated['satuan'],
        ];

        if ($request->hasFile('foto')) {
            if ($bahanMakanan->foto) {
                Storage::disk('public')->delete($bahanMakanan->foto);
            }

            $path = $request->file('foto')->store('bahan_makanan', 'public');
            $absolutePath = Storage::disk('public')->path($path);

            $result = $this->freshnessService->check($absolutePath);
            $data['status'] = $this->mapPrediction($result['prediction'] ?? 'unknown');
            $data['foto'] = $path;
        }

        $bahanMakanan->update($data);

        return redirect()->route('bahan-makanan.index')
            ->with('success', 'Bahan makanan berhasil diperbarui.');
    }

    private function mapPrediction(string $prediction): string
    {
        return match ($prediction) {
            'fresh' => 'segar',
            'spoiled' => 'tidak segar',
            default => 'tidak diketahui',
        };
    }
}
