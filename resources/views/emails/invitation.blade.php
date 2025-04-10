<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation à {{ $guest->event->name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            line-height: 1.7;
            color: #444;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 25px 20px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 35px;
            background-color: #ffffff;
        }
        .event-details {
            margin-bottom: 35px;
        }
        .event-details h2 {
            color: #2c3e50;
            margin: 0 0 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e8e8e8;
            font-size: 24px;
        }
        .event-details p {
            margin: 12px 0;
            font-size: 16px;
        }
        .detail-label {
            font-weight: bold;
            min-width: 100px;
            display: inline-block;
            color: #3498db;
        }
        .personal-info {
            margin-bottom: 25px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
            border-left: 4px solid #3498db;
        }
        .personal-info p:first-child {
            margin-top: 0;
        }
        .qr-code {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            border: 1px solid #e8e8e8;
        }
        .qr-code img {
            max-width: 200px;
            height: auto;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .qr-code-caption {
            font-size: 14px;
            color: #666;
            margin: 5px 0 15px;
        }
        .button {
            display: inline-block;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 15px;
            text-align: center;
            transition: background-color 0.2s;
        }
        .button:hover {
            background-color: #2980b9;
        }
        .download-link {
            display: inline-block;
            margin-top: 15px;
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }
        .download-link:hover {
            text-decoration: underline;
        }
        .footer {
            font-size: 13px;
            text-align: center;
            color: #999;
            padding: 20px;
            background-color: #f9f9f9;
            border-top: 1px solid #e8e8e8;
        }
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            .content {
                padding: 20px;
            }
            .personal-info, .qr-code {
                padding: 15px;
            }
            .header {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Invitation</h1>
            <p>Vous êtes invité(e) à participer à un événement spécial</p>
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
                <p>Nous avons le plaisir de vous convier à cet événement. Veuillez trouver ci-dessous votre QR code personnel qui vous permettra d'accéder à l'événement.</p>
            </div>

            <div class="qr-code">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $guest->qr_code }}" alt="QR Code pour {{ $guest->first_name }} {{ $guest->last_name }}">
                <p class="qr-code-caption">Code d'invitation: <strong>{{ $guest->qr_code }}</strong></p>

                <!-- Lien pour télécharger le QR code -->
                <a href="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ $guest->qr_code }}&download=1&file=qr_{{ $guest->id }}.png"
                   class="download-link" download="QR_Code_{{ $guest->first_name }}_{{ $guest->last_name }}.png">
                    Télécharger votre QR code
                </a>
            </div>

            <p>Veuillez présenter ce QR code à l'entrée de l'événement (version imprimée ou sur votre téléphone).</p>

            <p>Nous nous réjouissons de vous accueillir!</p>
        </div>

        <div class="footer">
            <p>Cet email a été envoyé automatiquement. Merci de ne pas y répondre.</p>
            <p>&copy; {{ date('Y') }} Système de Gestion de Présence par QR Code</p>
        </div>
    </div>
</body>
</html>
