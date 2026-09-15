<?php

use App\Http\Controllers\EventController;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index', [
        'events' => Event::query()->orderBy('event_date')->get(),
    ]);
})->name('index');

Route::get('/login', function () {
    return view('auth.login');
})->name('auth.login');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('auth.login');
})->name('auth.logout');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (! Auth::attempt($request->only('email', 'password'))) {
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->withInput();
    }

    $request->session()->regenerate();

    return redirect()->route('index');
})->name('auth.login.submit');

Route::get('/register', function () {
    return view('auth.register');
})->name('auth.register');

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => ['nullable', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255'],
        'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);

    User::create([
        'name' => $request->name ?? '',
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'user',
    ]);

    return redirect()->route('auth.login')->with('success', 'Compte créé avec succès.');
})->name('auth.register.store');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/evenements/nouveau', [EventController::class, 'create'])->name('events.create');
    Route::post('/evenements', [EventController::class, 'store'])->name('events.store');

    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
