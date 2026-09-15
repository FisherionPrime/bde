<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'users' => User::query()->orderBy('name')->orderBy('email')->get(),
        ]);
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', Rule::in(['user', 'admin'])],
        ]);

        if ($user->is(auth()->user()) && $validated['role'] !== 'admin') {
            return back()->withErrors(['user' => 'Tu ne peux pas retirer tes propres droits administrateur.']);
        }

        if ($user->role === 'admin' && $validated['role'] !== 'admin' && User::query()->where('role', 'admin')->count() === 1) {
            return back()->withErrors(['user' => 'Le BDE doit conserver au moins un administrateur.']);
        }

        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'Le rôle de '.$user->name.' a été mis à jour.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->is(auth()->user())) {
            return back()->withErrors(['user' => 'Tu ne peux pas supprimer ton propre compte.']);
        }

        if ($user->role === 'admin' && User::query()->where('role', 'admin')->count() === 1) {
            return back()->withErrors(['user' => 'Le dernier administrateur ne peut pas être supprimé.']);
        }

        $user->delete();

        return back()->with('success', 'Le compte de '.$user->name.' a été supprimé.');
    }
}
