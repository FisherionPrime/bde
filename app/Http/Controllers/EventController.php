<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function create(): View
    {
        return view('events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'event_date' => ['required', 'date_format:Y-m-d'],
        ], [
            'name.required' => 'Le nom de l’événement est obligatoire.',
            'color.regex' => 'La couleur doit être un code hexadécimal valide.',
            'event_date.required' => 'La date de l’événement est obligatoire.',
            'event_date.date_format' => 'La date sélectionnée est invalide.',
        ]);

        Event::create($validated);

        return redirect()->route('index')->with('success', 'Événement créé avec succès.');
    }
}
