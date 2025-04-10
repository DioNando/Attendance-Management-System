{{-- @section('title', 'Scanner les invités - ' . $event->name) --}}

<x-app-layout>

    <x-slot name="header">
        <x-label.page-title label="Scanner les invités" />
    </x-slot>

    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-6">Scanner les invités pour: {{ $event->name }}</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Interface de scan -->
            <div
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 px-5 sm:p-6 py-6 sm:py-7 rounded-lg">
                <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Scanner un QR code</h2>

                <!-- Affichage de la webcam/caméra -->
                <div id="scanner-container" class="relative mb-6 h-64 bg-gray-100 dark:bg-gray-700 rounded-lg">
                    <video playsinline id="scanner" class="w-full h-full object-cover rounded-lg"></video>
                    <div id="scanner-overlay" class="absolute inset-0 flex items-center justify-center">
                        <div class="w-48 h-48 border-2 border-blue-500 rounded-lg"></div>
                    </div>
                </div>

                <!-- Options et contrôles -->
                <div class="flex gap-4 mb-6">
                    <div class="grid grid-cols-1 flex-auto">
                        <select id="camera-select"
                            class=" px-3 py-1.5 text-base col-start-1 row-start-1 w-full appearance-none rounded-md bg-gray-300/10 dark:bg-white/5 pr-8 pl-3 text-gray-900 dark:text-white outline-1 -outline-offset-1 *:bg-gray-200 dark:*:bg-gray-800 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-500 sm:text-sm/6 outline-gray-300 dark:outline-white/10">
                            <option value="">Choisir une caméra...</option>
                        </select>
                        <x-heroicon-o-chevron-down
                            class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-400 sm:size-4" />
                    </div>
                    <x-button.primary id="start-scanner" type="button" icon="heroicon-o-camera">
                        Démarrer la caméra
                    </x-button.primary>
                    <x-button.primary id="stop-scanner" type="button" color="gray" class="hidden">
                        Arrêter la caméra
                    </x-button.primary>
                </div>

                <!-- Saisie manuelle du code -->
                <div>
                    <h3 class="text-lg font-medium mb-2 text-gray-900 dark:text-gray-100">Saisie manuelle</h3>
                    <form action="{{ route('scan.process', $event) }}" method="POST" id="manual-form">
                        @csrf
                        <div class="flex gap-3">
                            <div class="w-full">
                                <x-form.input name="qr_code" placeholder="Entrez le code d'invitation" />
                            </div>

                            <x-button.primary type="submit" color="green">
                                Vérifier
                            </x-button.primary>
                        </div>
                    </form>
                    @if (session()->has('success'))
                        <x-session-message type="success" />
                    @endif
                    @if (session()->has('warning'))
                        <x-session-message type="warning" />
                    @endif
                    @if (session()->has('error'))
                        <x-session-message type="error" />
                    @endif
                </div>
            </div>

            <!-- Résultat du scan -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-6 rounded-lg">
                <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Résultat du scan</h2>

                <div id="scan-result" class="hidden">
                    <div class="p-4 mb-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                        <div id="result-status" class="text-lg font-bold mb-2"></div>
                        <div id="result-message" class="text-gray-700 dark:text-gray-300"></div>
                    </div>

                    <div id="guest-info" class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-gray-500 dark:text-gray-400">Nom</div>
                                <div id="guest-name" class="font-semibold text-gray-900 dark:text-gray-100"></div>
                            </div>
                            <div>
                                <div class="text-gray-500 dark:text-gray-400">Email</div>
                                <div id="guest-email" class="font-semibold text-gray-900 dark:text-gray-100"></div>
                            </div>
                            <div>
                                <div class="text-gray-500 dark:text-gray-400">Code</div>
                                <div id="guest-code" class="font-semibold text-gray-900 dark:text-gray-100"></div>
                            </div>
                            <div>
                                <div class="text-gray-500 dark:text-gray-400">Statut</div>
                                <div id="guest-status" class="font-semibold text-gray-900 dark:text-gray-100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="scan-placeholder"
                    class="flex flex-col items-center justify-center py-12 text-gray-500 dark:text-gray-400">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                        </path>
                    </svg>
                    <p>Scannez un QR code pour voir les détails de l'invité</p>
                </div>
            </div>
        </div>

        <!-- Derniers scans -->
        <div class="mt-8 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 p-6 rounded-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Derniers scans</h2>
                <x-button.primary href="{{ route('scan.stats', $event) }}" color="gray"
                    icon="heroicon-o-chevron-right" responsive>
                    Voir toutes les statistiques
                </x-button.primary>
            </div>

            <div id="recent-scans">
                <!-- AJAX loaded content -->
            </div>
        </div>
    </div>
</x-app-layout>

{{-- @push('scripts') --}}
<script src="https://unpkg.com/jsqr@1.4.0/dist/jsQR.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables pour le scanner
        const video = document.getElementById('scanner');
        const startButton = document.getElementById('start-scanner');
        const stopButton = document.getElementById('stop-scanner');
        const cameraSelect = document.getElementById('camera-select');
        let canvasElement;
        let canvas;
        let scanning = false;
        let stream = null;

        // Initialiser le scanner
        function initScanner() {
            // Créer l'élément canvas pour l'analyse des frames
            canvasElement = document.createElement('canvas');
            canvas = canvasElement.getContext('2d');

            // Lister les caméras disponibles
            if (navigator.mediaDevices && navigator.mediaDevices.enumerateDevices) {
                navigator.mediaDevices.enumerateDevices()
                    .then(devices => {
                        const videoDevices = devices.filter(device => device.kind === 'videoinput');
                        if (videoDevices.length > 0) {
                            videoDevices.forEach((device, index) => {
                                const option = document.createElement('option');
                                option.value = device.deviceId;
                                option.text = device.label || `Caméra ${index + 1}`;
                                cameraSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => console.error('Erreur lors de l\'énumération des appareils:', error));
            }

            // Événements des boutons
            startButton.addEventListener('click', startScanning);
            stopButton.addEventListener('click', stopScanning);
            cameraSelect.addEventListener('change', () => {
                if (scanning) {
                    stopScanning().then(startScanning);
                }
            });
        }

        // Démarrer le scanner
        function startScanning() {
            if (scanning) return;

            const constraints = {
                video: {
                    facingMode: 'environment', // Utilise la caméra arrière par défaut
                    width: {
                        ideal: 1280
                    },
                    height: {
                        ideal: 720
                    }
                }
            };

            // Utiliser un appareil spécifique si sélectionné
            if (cameraSelect.value) {
                constraints.video = {
                    deviceId: {
                        exact: cameraSelect.value
                    },
                    // Conserver la préférence pour la caméra arrière sur mobile
                    facingMode: 'environment'
                };
            }

            // Vérifier si l'API est disponible
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                alert('Votre navigateur ne prend pas en charge l\'accès à la caméra. Essayez avec Chrome ou Firefox.');
                return;
            }

            navigator.mediaDevices.getUserMedia(constraints)
                .then(function(mediaStream) {
                    stream = mediaStream;
                    video.srcObject = mediaStream;
                    video.setAttribute('playsinline', true);
                    video.play();

                    startButton.classList.add('hidden');
                    stopButton.classList.remove('hidden');

                    scanning = true;
                    requestAnimationFrame(tick);
                })
                .catch(function(error) {
                    console.error('Impossible d\'accéder à la caméra:', error);

                    // Message d'erreur plus détaillé selon le type d'erreur
                    if (error.name === 'NotAllowedError') {
                        alert('Accès à la caméra refusé. Veuillez autoriser l\'accès dans les paramètres de votre navigateur.');
                    } else if (error.name === 'NotFoundError') {
                        alert('Aucune caméra détectée. Vérifiez que votre appareil dispose d\'une caméra fonctionnelle.');
                    } else {
                        alert('Impossible d\'accéder à la caméra: ' + error.message);
                    }
                });
        }

        // Arrêter le scanner
        function stopScanning() {
            return new Promise((resolve) => {
                if (!scanning) {
                    resolve();
                    return;
                }

                scanning = false;

                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }

                video.srcObject = null;
                startButton.classList.remove('hidden');
                stopButton.classList.add('hidden');

                resolve();
            });
        }

        // Analyser chaque frame pour les QR codes
        function tick() {
            if (!scanning) return;

            if (video.readyState === video.HAVE_ENOUGH_DATA) {
                canvasElement.height = video.videoHeight;
                canvasElement.width = video.videoWidth;
                canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);

                const imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: "dontInvert",
                });

                if (code) {
                    // QR code détecté
                    console.log("QR Code détecté:", code.data);
                    processQrCode(code.data);
                }
            }

            requestAnimationFrame(tick);
        }

        // Traiter les données du QR code
        function processQrCode(qrCode) {
            // Arrêter temporairement le scanning pour éviter les scans multiples
            scanning = false;

            // Envoyer les données au serveur
            fetch('{{ route('scan.process', $event) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        qr_code: qrCode
                    })
                })
                .then(response => response.json())
                .then(result => {
                    displayScanResult(result);

                    // Reprendre le scanning après 3 secondes
                    setTimeout(() => {
                        if (stream) scanning = true;
                    }, 3000);

                    // Mettre à jour la liste des scans récents
                    loadRecentScans();
                })
                .catch(error => {
                    console.error('Erreur lors du traitement du QR code:', error);
                    alert('Erreur lors du traitement du QR code.');

                    // Reprendre le scanning
                    scanning = true;
                });
        }

        // Afficher le résultat du scan
        function displayScanResult(result) {
            const scanPlaceholder = document.getElementById('scan-placeholder');
            const scanResult = document.getElementById('scan-result');
            const resultStatus = document.getElementById('result-status');
            const resultMessage = document.getElementById('result-message');

            scanPlaceholder.classList.add('hidden');
            scanResult.classList.remove('hidden');

            // Définir le statut et le message
            resultStatus.textContent = result.status === 'success' ?
                'Présence enregistrée' :
                (result.status === 'warning' ? 'Attention' : 'Erreur');
            resultStatus.className = 'text-lg font-bold mb-2 ' +
                (result.status === 'success' ? 'text-green-600' :
                    (result.status === 'warning' ? 'text-yellow-600' : 'text-red-600'));
            resultMessage.textContent = result.message;

            // Remplir les informations de l'invité si disponibles
            if (result.guest) {
                document.getElementById('guest-name').textContent = result.guest.first_name + ' ' + result.guest
                    .last_name;
                document.getElementById('guest-email').textContent = result.guest.email;
                document.getElementById('guest-code').textContent = result.guest.qr_code;
                document.getElementById('guest-status').textContent = result.status === 'success' ? 'Présent' :
                    (result.status === 'warning' ? 'Déjà enregistré' : 'Non enregistré');
                document.getElementById('guest-info').classList.remove('hidden');
            } else {
                document.getElementById('guest-info').classList.add('hidden');
            }
        }

        // Charger les scans récents
        function loadRecentScans() {
            fetch('{{ route('api.recent-scans', $event) }}')
                .then(response => response.json())
                .then(data => {
                    const recentScansContainer = document.getElementById('recent-scans');

                    if (data.length === 0) {
                        recentScansContainer.innerHTML =
                            '<p class="text-gray-500 dark:text-gray-400 text-center py-8">Aucun scan récent</p>';
                        return;
                    }

                    let html =
                        '<div class="overflow-x-auto"><table class="w-full md:rounded-lg overflow-hidden outline -outline-offset-1 outline-gray-300 dark:outline-gray-700">' +
                        '<thead class="bg-blue-200 dark:bg-gray-600"><tr>' +
                        '<th scope="col" class="px-5 py-3.5 text-left text-sm font-semibold text-blue-900 dark:text-gray-100">Invité</th>' +
                        '<th scope="col" class="px-5 py-3.5 text-left text-sm font-semibold text-blue-900 dark:text-gray-100">Code</th>' +
                        '<th scope="col" class="px-5 py-3.5 text-left text-sm font-semibold text-blue-900 dark:text-gray-100">Heure</th>' +
                        '<th scope="col" class="px-5 py-3.5 text-left text-sm font-semibold text-blue-900 dark:text-gray-100">Scanné par</th>' +
                        '</tr></thead>' +
                        '<tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-gray-900 dark:text-gray-100">';

                    data.forEach(scan => {
                        html += `<tr>
                        <td class="px-5 py-3.5">${scan.guest.first_name} ${scan.guest.last_name}</td>
                        <td class="px-5 py-3.5">${scan.guest.qr_code}</td>
                        <td class="px-5 py-3.5">${scan.created_at}</td>
                        <td class="px-5 py-3.5">${scan.scanned_by_name}</td>
                    </tr>`;
                    });

                    html += '</tbody></table></div>';
                    recentScansContainer.innerHTML = html;
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des scans récents:', error);
                });
        }

        // Initialiser
        initScanner();
        loadRecentScans();
    });
</script>
{{-- @endpush --}}
