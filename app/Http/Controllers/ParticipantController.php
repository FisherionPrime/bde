<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ParticipantController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $query = Student::query()->withCount('events');

        if ($search !== '') {
            $query->where(function ($builder) use ($search): void {
                $builder->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('class_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        }

        return view('participants.index', [
            'participants' => $query
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get(),
            'search' => $search,
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

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:10240'],
        ]);

        $filePath = $request->file('file')->getRealPath();
        $encoding = mb_detect_encoding(
            (string) file_get_contents($filePath),
            ['UTF-8', 'Windows-1252', 'ISO-8859-1'],
            true
        ) ?: 'UTF-8';
        $reader = IOFactory::createReader('Csv');
        $reader->setInputEncoding($encoding);
        $spreadsheet = $reader->load($filePath);
        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $headers = $this->normalizeImportHeaders(array_shift($rows) ?? []);
        $requiredHeaders = ['first_name', 'last_name', 'class_name', 'email'];

        if (array_diff($requiredHeaders, $headers) !== []) {
            return back()->withErrors([
                'file' => 'Le fichier doit contenir les colonnes prénom, nom, classe et email sur la première ligne.',
            ]);
        }

        $students = [];
        foreach ($rows as $rowNumber => $row) {
            $values = [];
            foreach ($headers as $column => $header) {
                $values[$header] = trim((string) ($row[$column] ?? ''));
            }

            if ($values['first_name'] === '' && $values['last_name'] === '' && $values['email'] === '') {
                continue;
            }

            $validator = validator($values, [
                'first_name' => ['required', 'string', 'max:100'],
                'last_name' => ['required', 'string', 'max:100'],
                'class_name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'email', 'max:255'],
            ]);

            if ($validator->fails()) {
                return back()->withErrors([
                    'file' => 'La ligne '.($rowNumber + 1).' est invalide : '.$validator->errors()->first(),
                ]);
            }

            $students[] = $values;
        }

        if ($students === []) {
            return back()->withErrors(['file' => 'Le fichier ne contient aucun élève à importer.']);
        }

        $emails = array_column($students, 'email');
        $students = array_values(array_reduce($students, function (array $unique, array $student): array {
            $unique[$student['email']] = $student;

            return $unique;
        }, []));
        $emails = array_column($students, 'email');
        $existingEmails = Student::query()->whereIn('email', $emails)->pluck('email')->all();
        $students = array_values(array_filter($students, fn (array $student): bool => ! in_array($student['email'], $existingEmails, true)));

        if ($students === []) {
            return back()->withErrors(['file' => 'Tous les élèves du fichier existent déjà.']);
        }

        DB::transaction(fn () => Student::insert($students));

        return redirect()->route('participants.index')->with('success', count($students).' élève(s) importé(s) avec succès.');
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

    private function normalizeImportHeaders(array $headers): array
    {
        $normalized = [];

        foreach ($headers as $column => $header) {
            $name = Str::of((string) $header)->ascii()->lower()->replaceMatches('/[^a-z0-9]+/', '_')->trim('_')->value();
            $normalized[$column] = match ($name) {
                'prenom', 'first_name', 'firstname' => 'first_name',
                'nom', 'last_name', 'lastname' => 'last_name',
                'classe', 'class', 'class_name' => 'class_name',
                default => $name,
            };
        }

        return $normalized;
    }
}
