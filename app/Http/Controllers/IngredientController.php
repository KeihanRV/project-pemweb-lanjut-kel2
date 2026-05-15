<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Kitchen;
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

    public function index(Request $request): View
    {
        $kitchens = Kitchen::orderBy('nama')->get();
        $perPage = in_array($request->query('per_page'), ['10', '25', '100'])
            ? (int) $request->query('per_page')
            : 10;

        $ingredients = Ingredient::orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();
        $selectedKitchen = null;

        if ($kitchens->isNotEmpty()) {
            $selectedKitchen = $kitchens->first();

            if ($request->filled('kitchen')) {
                $selectedKitchen = $kitchens->firstWhere('id', $request->query('kitchen')) ?? $selectedKitchen;
            }

            $ingredients = $selectedKitchen->ingredients()
                ->orderBy('created_at', 'desc')
                ->paginate($perPage)
                ->withQueryString();
        }

        return view('ingredients.index', compact('ingredients', 'kitchens', 'selectedKitchen', 'perPage'));
    }

    public function create(Request $request): View
    {
        $kitchens = Kitchen::orderBy('nama')->get();
        $selectedKitchen = null;

        if ($kitchens->isNotEmpty()) {
            $selectedKitchen = $kitchens->firstWhere('id', $request->query('kitchen')) ?? $kitchens->first();
        }

        return view('ingredients.create', compact('kitchens', 'selectedKitchen'));
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
            'kitchen_id' => ['nullable', 'exists:kitchens,id'],
        ]);

        $path = $request->file('foto')->store('ingredients', 'public');
        $absolutePath = Storage::disk('public')->path($path);

        $result = $this->freshnessService->check($absolutePath);
        $status = $this->mapPrediction($result['prediction'] ?? 'unknown');

        $ingredient = Ingredient::create([
            'nama' => $validated['nama'],
            'tanggal_datang' => $validated['tanggal_datang'],
            'kadaluarsa' => $validated['kadaluarsa'],
            'kuantitas' => $validated['kuantitas'],
            'satuan' => $validated['satuan'],
            'foto' => $path,
            'status_kesegaran' => $status,
        ]);

        if ($validated['kitchen_id']) {
            $ingredient->kitchens()->attach($validated['kitchen_id']);
        }

        return redirect()->route('ingredients.index', ['kitchen' => $validated['kitchen_id'] ?? null])
            ->with('success', 'Ingredient berhasil ditambahkan.');
    }

    public function edit(Request $request, Ingredient $ingredient): View
    {
        $kitchens = Kitchen::orderBy('nama')->get();
        $selectedKitchen = null;

        if ($kitchens->isNotEmpty()) {
            if ($request->filled('kitchen')) {
                $selectedKitchen = $kitchens->firstWhere('id', $request->query('kitchen'));
            }

            if (! $selectedKitchen) {
                $selectedKitchen = $ingredient->kitchens()->first() ?? $kitchens->first();
            }
        }

        return view('ingredients.edit', compact('ingredient', 'kitchens', 'selectedKitchen'));
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
            'kitchen_id' => ['nullable', 'exists:kitchens,id'],
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

        if ($validated['kitchen_id']) {
            $ingredient->kitchens()->syncWithoutDetaching([$validated['kitchen_id']]);
        }

        return redirect()->route('ingredients.index', ['kitchen' => $validated['kitchen_id'] ?? null])
            ->with('success', 'Ingredient berhasil diperbarui.');
    }

    public function destroy(Request $request, Ingredient $ingredient): RedirectResponse
    {
        $kitchenId = $request->input('kitchen_id');

        if ($kitchenId) {
            $ingredient->kitchens()->detach($kitchenId);

            if ($ingredient->kitchens()->count() === 0) {
                $ingredient->delete();
            }

            return redirect()->route('ingredients.index', ['kitchen' => $kitchenId])
                ->with('success', 'Ingredient berhasil dihapus dari kitchen.');
        }

        $ingredient->kitchens()->detach();
        $ingredient->delete();

        return redirect()->route('ingredients.index')
            ->with('success', 'Ingredient berhasil dihapus.');
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
