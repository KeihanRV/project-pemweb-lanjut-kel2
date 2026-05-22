<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $q = request('q');
        $sort = request('sort');

        $query = User::query();

        if ($q) {
            $query->where(function ($r) use ($q) {
                $r->where('name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($sort) {
            switch ($sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'email_asc':
                    $query->orderBy('email', 'asc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $perPage = (int) request('per_page', 10);
        if (! in_array($perPage, [10,25,100])) {
            $perPage = 10;
        }

        $users = $query->paginate($perPage)->withQueryString();

        return view('list-pengguna.index', compact('users'));
    }

    public function show($id)
    {
        return redirect()->route('pengguna-edit', $id);
    }

    public function create()
    {
        return view('list-pengguna.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Prevent creating a user with reserved system email
        if (isset($validated['email']) && strtolower($validated['email']) === strtolower(config('app.system_user_email'))) {
            return redirect()->route('pengguna-index')
                             ->with('error', 'Cannot create user with reserved system email.');
        }

        User::create($validated);

        return redirect()->route('pengguna-index')
                         ->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('list-pengguna.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Protect immutable system user
        if ($user->isSystemUser()) {
            return redirect()->route('pengguna-index')
                             ->with('error', 'System user cannot be modified.');
        }

        // handle is_admin toggle from inline checkbox forms
        if ($request->has('is_admin')) {
            $validated['is_admin'] = (bool) $request->input('is_admin');
        }

        $user->update($validated);

        return redirect()->route('pengguna-index')
                         ->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if (auth()->id() === $user->id) {
            return redirect()->route('pengguna-index')
                             ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        // Prevent deletion of immutable system user
        if ($user->isSystemUser()) {
            return redirect()->route('pengguna-index')
                             ->with('error', 'System user cannot be deleted.');
        }

        $user->delete();

        return redirect()->route('pengguna-index')
                         ->with('success', 'User berhasil dihapus!');
    }

    public function grantAdmin($id)
    {
        $user = User::findOrFail($id);
        if ($user->isSystemUser()) {
            return redirect()->route('pengguna-index')
                             ->with('error', 'Cannot modify system user.');
        }

        $user->update(['is_admin' => true]);

        return redirect()->route('pengguna-index')
                         ->with('success', "Hak akses admin berhasil diberikan kepada {$user->name}.");
    }
}