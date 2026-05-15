<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Services\FreshnessService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class IngredientController extends Controller
{
    public function __construct(
        protected FreshnessService $freshnessService
    ) {}

    public function index(): View
    {
        $ingredients = Ingredient::orderBy('created_at', 'desc')->get();

        return view('ingredients.index', compact('ingredients'));
    }

    public function create(): View
    {
        return view('ingredients.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_datang' => ['required', 'date'],
            'kadaluarsa' => ['required', 'date', 'after_or_equal:tanggal_datang'],
            'kuantitas' => ['required', 'integer', 'min:1'],
            'satuan' => ['required', 'string', 'max:50'],
            'foto' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        $path = $request->file('foto')->store('ingredients', 'public');
        $absolutePath = Storage::disk('public')->path($path);

        $result = $this->freshnessService->check($absolutePath);
        $status = $this->mapPrediction($result['prediction'] ?? 'unknown');

        Ingredient::create([
            'nama' => $validated['nama'],
            'tanggal_datang' => $validated['tanggal_datang'],
            'kadaluarsa' => $validated['kadaluarsa'],
            'kuantitas' => $validated['kuantitas'],
            'satuan' => $validated['satuan'],
            'foto' => $path,
            'status_kesegaran' => $status,
        ]);

        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient berhasil ditambahkan.');
    }

    public function edit(Ingredient $ingredient): View
    {
        return view('ingredients.edit', [
            'ingredient' => $ingredient,
        ]);
    }

    public function update(Request $request, Ingredient $ingredient): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_datang' => ['required', 'date'],
            'kadaluarsa' => ['required', 'date', 'after_or_equal:tanggal_datang'],
            'kuantitas' => ['required', 'integer', 'min:1'],
            'satuan' => ['required', 'string', 'max:50'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        $data = [
            'nama' => $validated['nama'],
            'tanggal_datang' => $validated['tanggal_datang'],
            'kadaluarsa' => $validated['kadaluarsa'],
            'kuantitas' => $validated['kuantitas'],
            'satuan' => $validated['satuan'],
        ];

        if ($request->hasFile('foto')) {
            if ($ingredient->foto) {
                Storage::disk('public')->delete($ingredient->foto);
            }

            $path = $request->file('foto')->store('ingredients', 'public');
            $absolutePath = Storage::disk('public')->path($path);

            $result = $this->freshnessService->check($absolutePath);
            $data['status_kesegaran'] = $this->mapPrediction($result['prediction'] ?? 'unknown');
            $data['foto'] = $path;
        }

        $ingredient->update($data);

        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient berhasil diperbarui.');
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
