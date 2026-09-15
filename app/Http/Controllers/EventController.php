<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        return view('events.index', [
            'events' => Event::query()->orderBy('event_date')->get(),
        ]);
    }

    public function create(): View
    {
        return view('events.create', [
            'students' => Student::query()->orderBy('last_name')->orderBy('first_name')->get(),
        ]);
    }

    public function show(Event $event): View
    {
        return view('events.show', [
            'event' => $event->load('students'),
            'students' => Student::query()->orderBy('last_name')->orderBy('first_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'event_date' => ['required', 'date_format:Y-m-d'],
            'student_ids' => ['nullable', 'array'],
            'student_ids.*' => ['integer', 'exists:students,id'],
        ], [
            'name.required' => 'Le nom de l’événement est obligatoire.',
            'color.regex' => 'La couleur doit être un code hexadécimal valide.',
            'event_date.required' => 'La date de l’événement est obligatoire.',
            'event_date.date_format' => 'La date sélectionnée est invalide.',
        ]);

        $studentIds = $validated['student_ids'] ?? [];
        unset($validated['student_ids']);

        $event = Event::create($validated);
        $event->students()->sync($studentIds);

        return redirect()->route('events.show', $event)->with('success', 'Événement créé avec succès.');
    }

    public function updateStudents(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'student_ids' => ['nullable', 'array'],
            'student_ids.*' => ['integer', 'exists:students,id'],
        ]);

        $event->students()->sync($validated['student_ids'] ?? []);

        return redirect()->route('events.show', $event)->with('success', 'La liste des participants a été mise à jour.');
    }
}
