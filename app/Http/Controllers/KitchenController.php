<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kitchen;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KitchenController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Kitchen::class);
        $q = request('q');
        $sortBy = request('sort_by');
        $sortOrder = request('sort_order', 'desc');

        $query = Kitchen::query();

        if ($q) {
            $query->where(function ($r) use ($q) {
                $r->where('nama', 'like', "%{$q}%")
                  ->orWhere('lokasi', 'like', "%{$q}%");
            });
        }

        if ($sortBy) {
            $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }

        $perPage = (int) request('per_page', 10);
        if (! in_array($perPage, [10,25,100])) {
            $perPage = 10;
        }

        $kitchens = $query->paginate($perPage)->withQueryString();

        return view('kitchen.index', compact('kitchens','perPage','sortBy','sortOrder','q'));
    }

    // public function show($id)
    // {
    //     return redirect()->route('kitchens.update', $id);
    // }
        public function show(Kitchen $kitchen)
        {
            $this->authorize('view', $kitchen);
            return redirect()->route('kitchens-edit', $kitchen->id);
        }

    public function create()
    {
        $this->authorize('create', Kitchen::class);
        return view('kitchen.create');
    }

    public function edit(Kitchen $kitchen)
    {
        $this->authorize('update', $kitchen);
        return view('kitchen.edit', compact('kitchen'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Kitchen::class);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
        ]);

        Kitchen::create($validated);

        return redirect()->route('kitchens-index')
                         ->with('success', 'Kitchen berhasil ditambahkan!');
    }


    public function update(Request $request, Kitchen $kitchen)
    {
        $this->authorize('update', $kitchen);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
        ]);

        $kitchen->update($validated);

        return redirect()->route('kitchens-index')
                         ->with('success', 'Kitchen berhasil diperbarui!');
    }

    public function destroy(Kitchen $kitchen)
    {
        $this->authorize('delete', $kitchen);
        $kitchen->delete();

        return redirect()->route('kitchens-index')
                         ->with('success', 'Kitchen berhasil dihapus!');
    }

    public function getTotalKitchen()
    {
        $total = Kitchen::count();
        return response()->json(['total_kitchens' => $total]);
    }
}
