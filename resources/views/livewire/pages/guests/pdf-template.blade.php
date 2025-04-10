<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des invités - {{ $event->name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .event-info {
            margin-bottom: 30px;
            font-size: 14px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 8px;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .page-footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Liste des invités</h1>

    <div class="event-info">
        <p><strong>Événement :</strong> {{ $event->name }}</p>
        <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}</p>
        <p><strong>Lieu :</strong> {{ $event->location ?: 'Non spécifié' }}</p>
        <p><strong>Nombre d'invités :</strong> {{ count($guests) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Invitation envoyée</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guests as $index => $guest)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $guest->first_name }} {{ $guest->last_name }}</td>
                    <td>{{ $guest->email }}</td>
                    <td>{{ $guest->phone ?: 'Non renseigné' }}</td>
                    <td>{{ $guest->invitation_sent ? 'Oui' : 'Non' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-footer">
        Document généré le {{ now()->translatedFormat('d F Y à H:i') }}
    </div>
</body>
</html>
