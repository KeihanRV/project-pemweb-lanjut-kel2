<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Kitchen;
use App\Services\FreshnessService;
use App\Services\IngredientService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class IngredientController extends Controller
{
    public function __construct(
        protected FreshnessService $freshnessService,
        protected IngredientService $ingredientService,
    ) {}

    public function bahanMakanan(Request $request): View|RedirectResponse
    {
        $user = auth()->user();

        if (!$user->is_admin && !$user->kitchen_id) {
            return redirect()->route('kitchen-code.show');
        }

        $data = $this->ingredientService->getListData($request, $user);

        return view('ingredients.index', $data);
    }

    public function index(Request $request): View|RedirectResponse
    {
        $user = auth()->user();
        
        // 1. Sanitasi Pagination & Sorting
        $perPage = in_array($request->query('per_page'), ['10', '25', '100']) ? (int) $request->query('per_page') : 10;
        $search = $request->query('search');
        $status = $request->query('status');
        
        $sortBy = in_array($request->query('sort_by'), ['nama', 'tanggal_datang', 'kadaluarsa', 'kuantitas', 'status_kesegaran'])
            ? $request->query('sort_by')
            : 'created_at';
        $sortOrder = $request->query('sort_order') === 'asc' ? 'asc' : 'desc';

        // dd([
        //     'Request All' => $request->all(),
        //     'Sort By Terdeteksi' => $sortBy,
        //     'Sort Order Terdeteksi' => $sortOrder
        // ]);

        // 2. Mapping Status (Samakan standarisasi string di DB)
        $statusMap = match (strtolower($status)) {
            'segar' => 'Segar',
            'busuk' => 'Busuk',
            'unknown' => 'Unknown',
            default => null,
        };

        // 3. Alur Logic ADMIN
        if ($user->is_admin) {
            $kitchens = Kitchen::orderBy('nama')->get();
            $selectedKitchen = null;

            // Tentukan kitchen mana yang sedang dipilih
            if ($kitchens->isNotEmpty()) {
                $selectedKitchen = $kitchens->first();
                if ($request->filled('kitchen')) {
                    $selectedKitchen = $kitchens->firstWhere('id', $request->query('kitchen')) ?? $selectedKitchen;
                }
            }

            // Mulai Query Utama dari Model Ingredient agar sorting aman dari ambiguitas pivot
            $query = Ingredient::query();

            // Filter berdasarkan Kitchen yang dipilh admin (gunakan storages sebagai sumber data)
            if ($selectedKitchen) {
                $query->whereHas('storages', function ($q) use ($selectedKitchen) {
                    $q->where('storages.kitchen_id', $selectedKitchen->id);
                });
            }

            // Terapkan Searching & Filtering Status (Gunakan $statusMap hasil konversi!)
            $ingredients = $query->when($search, fn ($q) => $q->where('ingredients.nama', 'like', "%{$search}%"))
                ->when($statusMap, fn ($q) => $q->whereRaw('LOWER(ingredients.status_kesegaran) = ?', [strtolower($statusMap)]))
                ->orderBy("ingredients.{$sortBy}", $sortOrder)
                ->paginate($perPage)
                ->withQueryString();

            return view('ingredients.index', compact('ingredients', 'kitchens', 'selectedKitchen', 'perPage', 'search', 'status', 'sortBy', 'sortOrder'));
        }

        // 4. Alur Logic STAFF / USER BIASA
        if (!$user->kitchen_id) {
            return redirect()->route('kitchen-code.show');
        }

        $kitchen = $user->kitchen;
        
        // Terapkan hal yang sama pada query user biasa (Gunakan $statusMap!)
        $ingredients = Ingredient::whereHas('storages', function ($q) use ($kitchen) {
                $q->where('storages.kitchen_id', $kitchen->id);
            })
            ->when($search, fn ($q) => $q->where('ingredients.nama', 'like', "%{$search}%"))
            ->when($statusMap, fn ($q) => $q->whereRaw('LOWER(ingredients.status_kesegaran) = ?', [strtolower($statusMap)]))
            ->orderBy("ingredients.{$sortBy}", $sortOrder)
            ->paginate($perPage)
            ->withQueryString();

     
            return view('ingredients.user-index', compact('ingredients', 'kitchen', 'perPage', 'search', 'status', 'sortBy', 'sortOrder'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        $user = auth()->user();

        // If user is not admin and doesn't have a kitchen, redirect
        if (!$user->is_admin && !$user->kitchen_id) {
            return redirect()->route('kitchen-code.show');
        }

        // If user is admin, show all kitchens
        if ($user->is_admin) {
            $kitchens = Kitchen::orderBy('nama')->get();
            $selectedKitchen = null;

            if ($kitchens->isNotEmpty()) {
                $selectedKitchen = $kitchens->firstWhere('id', $request->query('kitchen')) ?? $kitchens->first();
            }

            return view('ingredients.create', compact('kitchens', 'selectedKitchen'));
        }

        // If user is not admin, show only their kitchen
        $kitchen = $user->kitchen;
        return view('ingredients.user-create', compact('kitchen'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        // Check if user has permission
        if (!$user->is_admin && !$user->kitchen_id) {
            return redirect()->route('kitchen-code.show');
        }

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_datang' => ['required', 'date'],
            'kadaluarsa' => ['required', 'date', 'after_or_equal:tanggal_datang'],
            'kuantitas' => ['required', 'integer', 'min:1'],
            'satuan' => ['required', 'string', 'max:50'],
            'foto' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'kitchen_id' => ['nullable', 'exists:kitchens,id'],
        ]);

        // If user is not admin, force kitchen_id to be their kitchen
        if (!$user->is_admin) {
            $validated['kitchen_id'] = $user->kitchen_id;
        }

        $path = $request->file('foto')->store('ingredients', 'public');
        $absolutePath = Storage::disk('public')->path($path);

        $result = $this->freshnessService->check($absolutePath);
        $status = $this->mapPrediction($result['prediction'] ?? 'unknown');

        // Status kesegaran hanya berasal dari analisis ML; tidak boleh diisi manual.
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
            // create storage entry for this kitchen
            \App\Models\Storage::create([
                'ingredient_id' => $ingredient->id,
                'kitchen_id' => $validated['kitchen_id'],
            ]);

            // keep pivot for backward compatibility
            $ingredient->kitchens()->attach($validated['kitchen_id']);
        }

        return redirect()->route('bahan-makanan')
            ->with('success', 'Ingredient berhasil ditambahkan.');
    }

    public function edit(Request $request, Ingredient $ingredient): View
    {
        $user = auth()->user();

        // If user is not admin, check if ingredient belongs to their kitchen using storages
        if (!$user->is_admin) {
            $userKitchenIds = $ingredient->storages()->pluck('kitchen_id')->toArray();
            if (!in_array($user->kitchen_id, $userKitchenIds)) {
                abort(403, 'Unauthorized');
            }

            $kitchen = $user->kitchen;
            return view('ingredients.user-edit', compact('ingredient', 'kitchen'));
        }

        // Admin view
        $kitchens = Kitchen::orderBy('nama')->get();
        $selectedKitchen = null;

        if ($kitchens->isNotEmpty()) {
            if ($request->filled('kitchen')) {
                $selectedKitchen = $kitchens->firstWhere('id', $request->query('kitchen'));
            }

            if (!$selectedKitchen) {
                $selectedKitchen = $ingredient->kitchens()->first() ?? $kitchens->first();
            }
        }

        return view('ingredients.edit', compact('ingredient', 'kitchens', 'selectedKitchen'));
    }

    public function update(Request $request, Ingredient $ingredient): RedirectResponse
    {
        $user = auth()->user();

        // If user is not admin, check if ingredient belongs to their kitchen using storages
        if (!$user->is_admin) {
            $userKitchenIds = $ingredient->storages()->pluck('kitchen_id')->toArray();
            if (!in_array($user->kitchen_id, $userKitchenIds)) {
                abort(403, 'Unauthorized');
            }
        }

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'tanggal_datang' => ['required', 'date'],
            'kadaluarsa' => ['required', 'date', 'after_or_equal:tanggal_datang'],
            'kuantitas' => ['required', 'integer', 'min:1'],
            'satuan' => ['required', 'string', 'max:50'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'kitchen_id' => ['nullable', 'exists:kitchens,id'],
        ]);

        // If user is not admin, force kitchen_id to be their kitchen
        if (!$user->is_admin) {
            $validated['kitchen_id'] = $user->kitchen_id;
        }

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
            // ensure storage exists for this kitchen
            \App\Models\Storage::firstOrCreate([
                'ingredient_id' => $ingredient->id,
                'kitchen_id' => $validated['kitchen_id'],
            ]);

            // keep pivot for backward compatibility
            // $ingredient->kitchens()->syncWithoutDetaching([$validated['kitchen_id']]);
        }

        return redirect()->route('ingredients.index', ['kitchen' => $validated['kitchen_id'] ?? null])
            ->with('success', 'Ingredient berhasil diperbarui.');
    }

    public function destroy(Request $request, Ingredient $ingredient): RedirectResponse
    {
        $user = auth()->user();

        // If user is not admin, check if ingredient belongs to their kitchen
        if (!$user->is_admin) {
            $userKitchenIds = $ingredient->kitchens()->pluck('kitchens.id')->toArray();
            if (!in_array($user->kitchen_id, $userKitchenIds)) {
                abort(403, 'Unauthorized');
            }
        }

        $kitchenId = $request->input('kitchen_id');

        if ($kitchenId) {
            // remove storage entry linking this ingredient to the kitchen
            \App\Models\Storage::where('ingredient_id', $ingredient->id)
                ->where('kitchen_id', $kitchenId)
                ->delete();

            // detach pivot for backward compatibility
            $ingredient->kitchens()->detach($kitchenId);

            // if no more storages exist for this ingredient, delete the ingredient
            if (\App\Models\Storage::where('ingredient_id', $ingredient->id)->count() === 0) {
                $ingredient->delete();
            }

            return redirect()->route('bahan-makanan')
                ->with('success', 'Ingredient berhasil dihapus dari kitchen.');
        }

        // delete all storages and pivot and ingredient
        \App\Models\Storage::where('ingredient_id', $ingredient->id)->delete();
        $ingredient->kitchens()->detach();
        $ingredient->delete();

        return redirect()->route('bahan-makanan')
            ->with('success', 'Ingredient berhasil dihapus.');
    }

    private function mapPrediction(string $prediction): string
    {
        return match (strtolower($prediction)) {
            'fresh' => 'Segar',
            'spoiled' => 'Busuk',
            default => 'Unknown',
        };
    }
}
