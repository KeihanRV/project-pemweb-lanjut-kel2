<?php

namespace App\Services;

use App\Models\Kitchen;
use App\Models\Ingredient;
use App\Models\User;
use Illuminate\Http\Request;

class IngredientService
{
    public function getListData(Request $request, User $user): array
    {
        $perPage = in_array($request->input('per_page'), ['10', '25', '100'])
            ? (int) $request->input('per_page')
            : 10;

        if ($user->is_admin) {
            $kitchens = Kitchen::orderBy('nama')->get();
            $selectedKitchen = null;

            if ($kitchens->isNotEmpty()) {
                $selectedKitchen = $kitchens->first();

                if ($request->filled('kitchen')) {
                    $selectedKitchen = $kitchens->firstWhere('id', $request->input('kitchen')) ?? $selectedKitchen;
                }

                $ingredients = $selectedKitchen->ingredients()
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage)
                    ->withQueryString();
            } else {
                $ingredients = Ingredient::orderBy('created_at', 'desc')
                    ->paginate($perPage)
                    ->withQueryString();
            }

            return compact('ingredients', 'kitchens', 'selectedKitchen', 'perPage');
        }

        $kitchens = collect();
        $selectedKitchen = $user->kitchen;

        $ingredients = $selectedKitchen
            ->ingredients()
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return compact('ingredients', 'kitchens', 'selectedKitchen', 'perPage');
    }
}
