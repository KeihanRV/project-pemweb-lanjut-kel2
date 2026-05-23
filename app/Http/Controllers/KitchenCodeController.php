<?php

namespace App\Http\Controllers;

use App\Models\Kitchen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KitchenCodeController extends Controller
{
    /**
     * Show the kitchen code form (3-stage interface).
     */
    public function show()
    {
        // If user already has a kitchen assigned, redirect to dashboard
        if (Auth::user()->kitchen_id) {
            return redirect()->route('dashboard');
        }

        return view('auth.kitchen-code');
    }

    /**
     * Validate and assign kitchen code to user.
     */
    public function validateCode(Request $request)
    {
        if (!$request->filled('code')) {
            $request->merge([
                'code' => strtoupper(
                    $request->input('code_1', '') .
                    $request->input('code_2', '') .
                    $request->input('code_3', '') .
                    $request->input('code_4', '')
                )
            ]);
        }

        $request->validate([
            'code' => ['required', 'string', 'size:4', 'alpha_num'],
        ]);

        $code = strtoupper($request->code);
        $kitchen = Kitchen::where('code', $code)->first();

        if (!$kitchen) {
            return back()
                ->withErrors(['code' => 'Kode SPPG tidak valid. Silakan periksa kembali.'])
                ->withInput();
        }

        Auth::user()->update(['kitchen_id' => $kitchen->id]);

        return view('auth.kitchen-code', [
            'successMessage' => "Selamat datang di kitchen {$kitchen->nama}!",
            'kitchen' => $kitchen,
        ]);
    }
}
