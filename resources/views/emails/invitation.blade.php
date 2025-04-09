<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation à {{ $guest->event->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #3498db;
            margin-bottom: 5px;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .event-details {
            margin-bottom: 30px;
        }
        .event-details h2 {
            color: #2c3e50;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .event-details p {
            margin: 8px 0;
        }
        .detail-label {
            font-weight: bold;
            min-width: 100px;
            display: inline-block;
        }
        .qr-code {
            text-align: center;
            margin: 30px 0;
        }
        .qr-code img {
            max-width: 200px;
            height: auto;
        }
        .footer {
            font-size: 12px;
            text-align: center;
            color: #7f8c8d;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .button {
            display: inline-block;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin-top: 20px;
        }
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            .content {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Invitation</h1>
        <p>Vous êtes invité(e) à participer à un événement</p>
    </div>

    <div class="content">
        <div class="event-details">
            <h2>{{ $guest->event->name }}</h2>

            <p><span class="detail-label">Date:</span>
                @if ($guest->event->end_date && $guest->event->start_date->format('Y-m-d') != $guest->event->end_date->format('Y-m-d'))
                    Du {{ $guest->event->start_date->format('d/m/Y') }} au {{ $guest->event->end_date->format('d/m/Y') }}
                @else
                    Le {{ $guest->event->start_date->format('d/m/Y') }}
                @endif
            </p>

            @if ($guest->event->location)
                <p><span class="detail-label">Lieu:</span> {{ $guest->event->location }}</p>
            @endif

            @if ($guest->event->description)
                <p><span class="detail-label">Description:</span><br>{{ $guest->event->description }}</p>
            @endif
        </div>

        <div class="personal-info">
            <p>Bonjour {{ $guest->first_name }} {{ $guest->last_name }},</p>
            <p>Nous avons le plaisir de vous convier à cet événement. Voici votre QR code personnel qui vous permettra d'accéder à l'événement:</p>
        </div>

        <div class="qr-code">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $guest->qr_code }}" alt="QR Code pour {{ $guest->first_name }} {{ $guest->last_name }}">
            <p>Code: {{ $guest->qr_code }}</p>
        </div>

        <p>Veuillez présenter ce QR code à l'entrée de l'événement (version imprimée ou sur votre téléphone).</p>

        <p>Nous nous réjouissons de vous accueillir!</p>
    </div>

    <div class="footer">
        <p>Cet email a été envoyé automatiquement. Merci de ne pas y répondre.</p>
        <p>&copy; {{ date('Y') }} Système de Gestion de Présence par QR Code</p>
    </div>
</body>
</html>
