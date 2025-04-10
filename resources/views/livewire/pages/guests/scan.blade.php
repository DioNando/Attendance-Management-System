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
            <x-form.form submit="processQrCode">
                <div class="flex gap-3">
                    <div class="w-full">
                        <x-form.input name="qr_code" placeholder="Entrez le code d'invitation" />
                    </div>
                    <x-button.primary type="submit" color="green">
                        Vérifier
                    </x-button.primary>
                </div>
            </x-form.form>
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

        <div id="scan-result" class="{{ $show_result ? '' : 'hidden' }}">
            @if ($result)
                <div class="p-4 mb-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <div
                        class="text-lg font-bold mb-2 {{ $result['status'] === 'success'
                            ? 'text-green-600'
                            : ($result['status'] === 'warning'
                                ? 'text-yellow-600'
                                : 'text-red-600') }}">
                        {{ $result['status'] === 'success'
                            ? 'Présence enregistrée'
                            : ($result['status'] === 'warning'
                                ? 'Attention'
                                : 'Erreur') }}
                    </div>
                    <div class="text-gray-700 dark:text-gray-300">{{ $result['message'] }}</div>
                </div>

                @if ($guest)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-gray-500 dark:text-gray-400">Nom</div>
                                <div class="font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $guest['first_name'] }} {{ $guest['last_name'] }}
                                </div>
                            </div>
                            <div>
                                <div class="text-gray-500 dark:text-gray-400">Email</div>
                                <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $guest['email'] }}</div>
                            </div>
                            <div>
                                <div class="text-gray-500 dark:text-gray-400">Code</div>
                                <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $guest['qr_code'] }}
                                </div>
                            </div>
                            <div>
                                <div class="text-gray-500 dark:text-gray-400">Statut</div>
                                <div class="font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $result['status'] === 'success'
                                        ? 'Présent'
                                        : ($result['status'] === 'warning'
                                            ? 'Déjà enregistré'
                                            : 'Non enregistré') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <div id="scan-placeholder"
            class="{{ $show_result ? 'hidden' : 'flex flex-col items-center justify-center py-12 text-gray-500 dark:text-gray-400' }}">
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
                alert(
                    'Votre navigateur ne prend pas en charge l\'accès à la caméra. Essayez avec Chrome ou Firefox.');
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
                        alert(
                            'Accès à la caméra refusé. Veuillez autoriser l\'accès dans les paramètres de votre navigateur.');
                    } else if (error.name === 'NotFoundError') {
                        alert(
                            'Aucune caméra détectée. Vérifiez que votre appareil dispose d\'une caméra fonctionnelle.');
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

            // Utiliser Livewire au lieu de fetch
            @this.processQrCode(qrCode).then(() => {
                // Reprendre le scanning après 3 secondes
                setTimeout(() => {
                    if (stream) scanning = true;
                }, 3000);
            });
        }

        // Initialiser
        initScanner();
    });
</script>
<script src="https://unpkg.com/jsqr@1.4.0/dist/jsQR.js"></script>

