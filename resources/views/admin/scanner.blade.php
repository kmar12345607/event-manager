@extends('layouts.app')

@section('title', 'Scanner de billets')
@section('page-title', 'Scanner de billets')
@section('page-sub', 'Valide l\'entrée des participants comme au cinéma 🎬')

@section('content')
<div class="row g-4">

    <!-- Colonne scanner -->
    <div class="col-lg-6">
        <div class="page-card">
            <div class="page-card-header">
                <span class="fw-bold" style="color:#1a2744;">
                    <i class="bi bi-camera-fill me-1"></i> Scan caméra
                </span>
                <button id="toggle-scanner" class="btn-primary" type="button" style="padding:6px 14px; font-size:12px;">
                    Démarrer la caméra
                </button>
            </div>
            <div style="padding: 18px 22px;">
                <div id="qr-reader" style="width: 100%; border-radius: 10px; overflow: hidden;"></div>
                <p class="text-muted mt-2 mb-0" style="font-size:12px;">
                    Autorise l'accès à la caméra dans ton navigateur. Nécessite HTTPS ou localhost.
                </p>
            </div>
        </div>

        <!-- Saisie manuelle en secours -->
        <div class="page-card mt-4">
            <div class="page-card-header">
                <span class="fw-bold" style="color:#1a2744;">
                    <i class="bi bi-keyboard-fill me-1"></i> Saisie manuelle
                </span>
            </div>
            <div style="padding: 18px 22px;">
                <form id="manual-form" class="d-flex gap-2">
                    <input type="text" id="manual-code" class="form-control" placeholder="Ex: EVT003-A1B2C3" autocomplete="off">
                    <button type="submit" class="btn-primary" style="white-space:nowrap;">Valider</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Colonne résultat -->
    <div class="col-lg-6">
        <div class="page-card" style="min-height: 320px;">
            <div class="page-card-header">
                <span class="fw-bold" style="color:#1a2744;"><i class="bi bi-clipboard-check-fill me-1"></i> Résultat</span>
            </div>
            <div id="result-zone" style="padding: 28px 22px;">
                <div class="empty-state">
                    <div class="empty-icon">🎫</div>
                    <div class="empty-title">En attente d'un billet</div>
                    <div class="empty-sub">Scanne un QR code ou saisis un code manuellement.</div>
                </div>
            </div>
        </div>

        <!-- Historique de session -->
        <div class="page-card mt-4">
            <div class="page-card-header">
                <span class="fw-bold" style="color:#1a2744;"><i class="bi bi-clock-history me-1"></i> Historique de la session</span>
            </div>
            <ul id="history-list" style="list-style:none; margin:0; padding: 8px 0; max-height: 260px; overflow-y:auto;"></ul>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const resultZone   = document.getElementById('result-zone');
    const historyList  = document.getElementById('history-list');
    const manualForm   = document.getElementById('manual-form');
    const manualInput  = document.getElementById('manual-code');
    const toggleBtn    = document.getElementById('toggle-scanner');

    let html5QrCode = null;
    let scannerRunning = false;
    let lastScanTime = 0;

    async function verifyCode(code) {
        if (!code) return;

        try {
            const response = await fetch("{{ route('admin.scanner.verify') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ ticket_code: code }),
            });

            const data = await response.json();
            renderResult(data, code);
            addToHistory(data, code);
        } catch (err) {
            renderResult({ status: 'error', message: 'Erreur réseau, réessaie.' }, code);
        }
    }

    function renderResult(data, code) {
        let bg, icon, title, sub = '';

        if (data.status === 'success') {
            bg = '#d1fae5'; icon = '✅';
            title = `${data.participant.name} — Entrée validée`;
            sub = `${data.participant.event} · ${data.participant.time}`;
        } else if (data.status === 'already_used') {
            bg = '#fef3c7'; icon = '⚠️';
            title = 'Billet déjà utilisé';
            sub = data.message;
        } else {
            bg = '#fee2e2'; icon = '❌';
            title = 'Billet invalide';
            sub = data.message || code;
        }

        resultZone.innerHTML = `
            <div style="background:${bg}; border-radius:12px; padding:24px; text-align:center;">
                <div style="font-size:40px; margin-bottom:10px;">${icon}</div>
                <div style="font-weight:700; font-size:16px; color:#1a2744;">${title}</div>
                <div style="font-size:13px; color:#475569; margin-top:4px;">${sub}</div>
                <div style="font-size:11px; color:#94a3b8; margin-top:10px; font-family:monospace;">${code}</div>
            </div>
        `;
    }

    function addToHistory(data, code) {
        const li = document.createElement('li');
        li.style.cssText = 'padding:10px 22px; border-top:1px solid #f1f5f9; font-size:13px; display:flex; justify-content:space-between; align-items:center;';
        const time = new Date().toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

        let badge;
        if (data.status === 'success') badge = '<span class="badge-status badge-present">Validé</span>';
        else if (data.status === 'already_used') badge = '<span class="badge-status badge-registered">Déjà utilisé</span>';
        else badge = '<span class="badge-status badge-absent">Invalide</span>';

        li.innerHTML = `
            <span style="font-family:monospace; color:#475569;">${code}</span>
            <span>${badge}</span>
            <span style="color:#94a3b8; font-size:11px;">${time}</span>
        `;
        historyList.prepend(li);
    }

    // ─── Saisie manuelle ───
    manualForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const code = manualInput.value.trim();
        if (code) {
            verifyCode(code);
            manualInput.value = '';
        }
    });

    // ─── Scanner caméra ───
    toggleBtn.addEventListener('click', async function () {
        if (!scannerRunning) {
            html5QrCode = new Html5Qrcode("qr-reader");
            try {
                await html5QrCode.start(
                    { facingMode: "environment" },
                    { fps: 10, qrbox: { width: 250, height: 250 } },
                    (decodedText) => {
                        // Anti double-scan : on ignore les lectures répétées en moins d'1.5s
                        const now = Date.now();
                        if (now - lastScanTime < 1500) return;
                        lastScanTime = now;
                        verifyCode(decodedText.trim());
                    },
                    () => {} // erreurs de lecture image par image, ignorées silencieusement
                );
                scannerRunning = true;
                toggleBtn.textContent = 'Arrêter la caméra';
            } catch (err) {
                resultZone.innerHTML = `
                    <div style="background:#fee2e2; border-radius:12px; padding:24px; text-align:center;">
                        <div style="font-size:32px;">🚫</div>
                        <div style="font-weight:700; color:#1a2744; margin-top:8px;">Accès caméra refusé</div>
                        <div style="font-size:13px; color:#475569; margin-top:4px;">
                            Vérifie les autorisations du navigateur, ou utilise la saisie manuelle.
                        </div>
                    </div>
                `;
            }
        } else {
            await html5QrCode.stop();
            html5QrCode.clear();
            scannerRunning = false;
            toggleBtn.textContent = 'Démarrer la caméra';
        }
    });
});
</script>
@endpush