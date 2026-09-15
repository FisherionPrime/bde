<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/login', function () {
    return view('auth.login');
})->name('auth.login');

Route::post('/logout', function () {
    session()->flush();

    return redirect()->route('auth.login');
})->name('auth.logout');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = DB::table('users')->where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->withInput();
    }

    session([
        'user_id' => $user->id,
        'user_name' => $user->name,
        'user_email' => $user->email,
    ]);

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

    $existingUser = DB::table('users')->where('email', $request->email)->exists();

    if ($existingUser) {
        return back()->withErrors([
            'email' => 'Cet email est déjà utilisé.',
        ])->withInput();
    }

    $data = [
        'name' => $request->name ?? '',
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ];

    DB::table('users')->insert($data);

    return redirect()->route('auth.login')->with('success', 'Compte créé avec succès.');
})->name('auth.register.store');
