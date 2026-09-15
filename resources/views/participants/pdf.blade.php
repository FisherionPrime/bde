<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Liste des participants - Educia BDE</title>
    <style>
        @page { margin: 28px 30px; }
        body { color: #252331; font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        h1 { color: #40205f; font-size: 20px; margin: 0 0 5px; }
        .meta { color: #686272; font-size: 9px; margin-bottom: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th { background: #40205f; color: #ffffff; font-size: 9px; padding: 9px 7px; text-align: left; }
        td { border-bottom: 1px solid #ddd8e2; padding: 8px 7px; vertical-align: top; }
        tr:nth-child(even) td { background: #f7f4f8; }
        .count { text-align: center; width: 70px; }
        .email { width: 175px; }
        .class { width: 115px; }
        .events { color: #686272; }
        .empty { color: #96909d; }
    </style>
</head>
<body>
    <h1>Liste des participants</h1>
    <div class="meta">Educia BDE - export du {{ now()->format('d/m/Y à H:i') }} - {{ $participants->count() }} participant(s)</div>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th class="email">Email</th>
                <th class="class">Classe</th>
                <th class="count">Activités</th>
                <th>Événements associés</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($participants as $participant)
                <tr>
                    <td>{{ $participant->last_name ?: '—' }}</td>
                    <td>{{ $participant->first_name ?: $participant->name ?: '—' }}</td>
                    <td>{{ $participant->email ?: '—' }}</td>
                    <td>{{ $participant->class_name ?: '—' }}</td>
                    <td class="count">{{ $participant->events_count }}</td>
                    <td class="events">
                        @if ($participant->events->isNotEmpty())
                            {{ $participant->events->pluck('name')->join(', ') }}
                        @else
                            <span class="empty">Aucune activité</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty">Aucun participant enregistré.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
