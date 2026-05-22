<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Kitchen;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = auth()->user();

        if (!$user->is_admin && !$user->kitchen_id) {
            return redirect()->route('kitchen-code.show');
        }

        $ingredientQuery = $user->is_admin
            ? Ingredient::query()
            : $user->kitchen->ingredients();

        // Freshness distribution for donut chart
        $freshnessCounts = (clone $ingredientQuery)
            ->select(DB::raw('LOWER(status_kesegaran) as status_kesegaran'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('LOWER(status_kesegaran)'))
            ->pluck('total', 'status_kesegaran');

        $donutData = [
            'Segar'   => $freshnessCounts->get('segar', 0),
            'Busuk'   => $freshnessCounts->get('busuk', 0),
            'Unknown' => $freshnessCounts->get('unknown', 0),
        ];

        // Total ingredient count
        $totalIngredients = (clone $ingredientQuery)->count();

        // Ingredients added per day for the past 7 days for line chart
        $past7Days = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->toDateString());

        $dailyCounts = (clone $ingredientQuery)
            ->select(DB::raw('DATE(tanggal_datang) as day'), DB::raw('count(*) as total'))
            ->whereBetween('tanggal_datang', [$past7Days->first(), $past7Days->last()])
            ->groupBy('day')
            ->pluck('total', 'day');

        $lineLabels = $past7Days->map(fn($d) => \Carbon\Carbon::parse($d)->translatedFormat('D'))->values();
        $lineData   = $past7Days->map(fn($d) => $dailyCounts->get($d, 0))->values();

        // Recent ingredients table (paginated)
        $ingredients = (clone $ingredientQuery)
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('dashboard', compact(
            'donutData',
            'totalIngredients',
            'lineLabels',
            'lineData',
            'ingredients',
        ));
    }

    public function adminIndex(): View
    {
        $totalIngredients = Ingredient::count();
        $totalKitchens    = Kitchen::count();
        $totalUsers       = User::count();

        $freshnessCounts = Ingredient::select(DB::raw('LOWER(status_kesegaran) as status_kesegaran'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('LOWER(status_kesegaran)'))
            ->pluck('total', 'status_kesegaran');

        $donutData = [
            'Segar'   => $freshnessCounts->get('segar', 0),
            'Busuk'   => $freshnessCounts->get('busuk', 0),
            'Unknown' => $freshnessCounts->get('unknown', 0),
        ];

        $kitchens = Kitchen::withCount('ingredients')->orderBy('nama')->get();

        $recentIngredients = Ingredient::with('kitchens')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.dashboard', compact(
            'totalIngredients',
            'totalKitchens',
            'totalUsers',
            'donutData',
            'kitchens',
            'recentIngredients',
        ));
    }
}
