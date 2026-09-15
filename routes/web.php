<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\UserController;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index', [
        'events' => Event::query()->orderBy('event_date')->limit(3)->get(),
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
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'class_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => trim($request->first_name.' '.$request->last_name),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'class_name' => $request->class_name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'user',
        ]);

        return redirect()->route('auth.login')->with('success', 'Compte créé avec succès.');
    })->name('auth.register.store');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('auth.login');
})->name('auth.logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('index', [
            'events' => Event::query()->orderBy('event_date')->limit(3)->get(),
        ]);
    })->name('index');

    Route::get('/participants', [ParticipantController::class, 'index'])->name('participants.index');
    Route::get('/participants/export', [ParticipantController::class, 'exportPdf'])->name('participants.export');
    Route::get('/evenements', [EventController::class, 'index'])->name('events.index');
    Route::get('/evenements/{event}', [EventController::class, 'show'])->whereNumber('event')->name('events.show');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/evenements/nouveau', [EventController::class, 'create'])->name('events.create');
    Route::post('/evenements', [EventController::class, 'store'])->name('events.store');
    Route::put('/evenements/{event}/participants', [EventController::class, 'updateStudents'])->name('events.participants.update');

    Route::get('/participants/nouveau', [ParticipantController::class, 'create'])->name('participants.create');
    Route::post('/participants', [ParticipantController::class, 'store'])->name('participants.store');
    Route::get('/participants/{participant}/modifier', [ParticipantController::class, 'edit'])->name('participants.edit');
        Route::post('/participants/importer', [ParticipantController::class, 'import'])->name('participants.import');
    Route::put('/participants/{participant}', [ParticipantController::class, 'update'])->name('participants.update');
    Route::delete('/participants/{participant}', [ParticipantController::class, 'destroy'])->name('participants.destroy');

    Route::get('/admin', [UserController::class, 'index'])->name('admin.dashboard');
    Route::patch('/admin/utilisateurs/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.role');
    Route::delete('/admin/utilisateurs/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});
