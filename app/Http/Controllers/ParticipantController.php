<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class ParticipantController extends Controller
{
    public function index(): View
    {
        return view('participants.index', [
            'participants' => Student::query()
                ->withCount('events')
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get(),
        ]);
    }

    public function exportPdf()
    {
        $participants = Student::query()
            ->with('events')
            ->withCount('events')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return Pdf::loadView('participants.pdf', [
            'participants' => $participants,
        ])->setPaper('a4', 'landscape')->download('participants-bde.pdf');
    }

    public function create(): View
    {
        return view('participants.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateParticipant($request);
        Student::create($validated);

        return redirect()->route('participants.index')->with('success', 'Élève ajouté avec succès.');
    }

    public function edit(Student $participant): View
    {
        return view('participants.edit', compact('participant'));
    }

    public function update(Request $request, Student $participant): RedirectResponse
    {
        $validated = $this->validateParticipant($request, $participant);
        $participant->update($validated);

        return redirect()->route('participants.index')->with('success', 'Élève modifié avec succès.');
    }

    public function destroy(Student $participant): RedirectResponse
    {
        $participant->delete();

        return redirect()->route('participants.index')->with('success', 'Élève supprimé avec succès.');
    }

    private function validateParticipant(Request $request, ?Student $participant = null): array
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'class_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('students', 'email')->ignore($participant?->id)],
        ]);
    }
}
