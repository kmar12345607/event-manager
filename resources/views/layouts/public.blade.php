<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EventManager') — Événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/intro.js/minified/introjs.min.css" rel="stylesheet">
    <style>
        :root {
            --brand: #2563eb;
            --brand-dark: #1d4ed8;
        }
        body { background: #f8fafc; }

        /* Navbar */
        .navbar-brand { font-weight: 700; color: var(--brand) !important; }
        .navbar { border-bottom: 1px solid #e2e8f0; background: #fff; }

        /* Hero */
        .hero {
            background: linear-gradient(135deg, #1e293b 0%, #2563eb 100%);
            color: #fff;
            padding: 5rem 0 4rem;
        }
        .hero h1 { font-size: 2.5rem; font-weight: 800; }
        .hero p { font-size: 1.1rem; opacity: .85; }

        /* Cards événements */
        .event-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
            transition: transform .2s, box-shadow .2s;
            overflow: hidden;
        }
        .event-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,.12);
        }
        .event-card .card-header {
            background: var(--brand);
            color: #fff;
            padding: 1.25rem;
            border: none;
        }
        .event-card .badge-status {
            font-size: .7rem;
            padding: .35em .7em;
        }

        /* Footer */
        footer {
            background: #1e293b;
            color: #94a3b8;
            padding: 2rem 0;
            margin-top: 4rem;
        }
        footer a { color: #94a3b8; text-decoration: none; }

        /* Progress bar capacité */
        .capacity-bar { height: 6px; border-radius: 3px; }

        /* ===== BOUTON D'AIDE FLOTTANT + TOUR GUIDÉ (identique à la page d'accueil) ===== */
        .help-float-btn {
            position: fixed; bottom: 28px; right: 28px; z-index: 9999;
            width: 58px; height: 58px; border-radius: 50%;
            background: linear-gradient(135deg, #2563eb, #3b82f6); color: white;
            border: none; box-shadow: 0 10px 30px rgba(37,99,235,0.45);
            font-size: 1.4rem; display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.3s;
            animation: helpPulse 2.5s infinite;
        }
        .help-float-btn:hover { transform: scale(1.08); box-shadow: 0 14px 36px rgba(37,99,235,0.6); }
        @keyframes helpPulse {
            0%, 100% { box-shadow: 0 10px 30px rgba(37,99,235,0.45); }
            50% { box-shadow: 0 10px 30px rgba(37,99,235,0.45), 0 0 0 10px rgba(37,99,235,0.12); }
        }

        /* Thème Intro.js assorti au design du site */
        .introjs-tooltip { border-radius: 16px; font-family: 'Inter', sans-serif; box-shadow: 0 20px 50px rgba(13,27,75,0.25); max-width: 340px; }
        .introjs-tooltiptext { font-size: 0.92rem; color: #333; line-height: 1.6; }
        .introjs-tooltip-title { font-weight: 800; color: #0d1b4b; }
        .introjs-button {
            border-radius: 25px !important; font-weight: 700 !important; font-size: 0.85rem !important;
            padding: 8px 18px !important; text-shadow: none !important; border: none !important;
        }
        .introjs-nextbutton, .introjs-donebutton {
            background: linear-gradient(135deg, #2563eb, #3b82f6) !important; color: white !important;
        }
        .introjs-prevbutton { background: #eceff8 !important; color: #555 !important; }
        .introjs-skipbutton { color: #9e9e9e !important; }
        .introjs-progress { border-radius: 10px !important; }
        .introjs-progressbar { background: linear-gradient(90deg,#2563eb,#3b82f6) !important; }
        .introjs-helperNumberLayer {
            background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
            box-shadow: 0 3px 10px rgba(37,99,235,0.4) !important;
        }
    </style>
</head>
<body data-page="{{ $pageTour ?? 'default' }}">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top" style="background:#1a56db;padding:.75rem 0;">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}" style="color:#fff;font-weight:700;font-size:1.1rem;">
            <i class="bi bi-calendar-event me-2"></i>Event Manager
        </a>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.85);text-decoration:none;font-size:.9rem;">
                Événements
            </a>
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('participant.dashboard') }}" id="tour-mon-espace" style="background:rgba(255,255,255,0.15);color:#fff;padding:.45rem 1.1rem;border-radius:8px;text-decoration:none;font-size:.9rem;font-weight:500;">
                    <i class="bi bi-speedometer2 me-1"></i>{{ auth()->user()->isAdmin() ? 'Admin' : 'Mon espace' }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                    @csrf
                    <button type="submit" style="background:transparent;color:rgba(255,255,255,0.85);border:1px solid rgba(255,255,255,0.3);padding:.45rem .9rem;border-radius:8px;font-size:.9rem;cursor:pointer;">
                        <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" style="background:rgba(255,255,255,0.15);color:#fff;padding:.45rem 1.1rem;border-radius:8px;text-decoration:none;font-size:.9rem;font-weight:500;border:1px solid rgba(255,255,255,0.3);">
                    Se connecter
                </a>
                <a href="{{ route('register') }}" id="tour-creer-compte" style="background:#fff;color:#1a56db;padding:.45rem 1.1rem;border-radius:8px;text-decoration:none;font-size:.9rem;font-weight:700;">
                    Commencer
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- Alertes -->
<div class="container mt-3">
    @if(session('success'))
        <div id="alert-succes-inscription" class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

@yield('content')

<!-- Footer -->
<footer>
    <div class="container text-center">
        <p class="mb-1">
            <i class="bi bi-calendar-event me-2"></i>
            <strong style="color:#fff">EventManager</strong>
        </p>
        <small>Plateforme de gestion d'événements · {{ date('Y') }}</small>
    </div>
</footer>

<!-- ===== BOUTON D'AIDE FLOTTANT (relance le guide de la page actuelle) ===== -->
<button class="help-float-btn" id="helpTourBtn" title="Besoin d'aide ? Lancer la visite guidée" onclick="startGuidedTour()">
    <i class="bi bi-question-lg"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intro.js/minified/intro.min.js"></script>
<script>
// Lance le guide : intro.js repère tout seul les éléments qui ont
// un attribut data-step / data-intro sur la page actuelle et les enchaîne dans l'ordre.
function startGuidedTour() {
    introJs().setOptions({
        nextLabel: 'Suivant →',
        prevLabel: '← Précédent',
        doneLabel: 'Terminer',
        skipLabel: '✕',
        showProgress: true,
        showBullets: false,
        exitOnOverlayClick: true,
        overlayOpacity: 0.65,
        scrollToElement: true,
        disableInteraction: false
    }).start();
}

// Lance automatiquement le guide au premier passage sur CETTE page
// (une clé différente par page, basée sur l'URL, pour que chaque page
// ait son propre guide au lieu de partager une seule clé "default")
document.addEventListener('DOMContentLoaded', function () {
    var pageKey = window.location.pathname.replace(/[^a-z0-9]/gi, '_') || 'home';
    var storageKey = 'evt_tour_seen_' + pageKey;

    if (document.querySelectorAll('[data-step]').length && !localStorage.getItem(storageKey)) {
        setTimeout(startGuidedTour, 700);
        localStorage.setItem(storageKey, '1');
    }
});

// Mini-guide de félicitations juste après une inscription réussie
// (se déclenche uniquement si le bandeau vert de succès est présent)
// Un compte est désormais obligatoire pour s'inscrire à un événement,
// donc ce bandeau n'apparaît que pour un utilisateur déjà connecté.
document.addEventListener('DOMContentLoaded', function () {
    var alertSucces = document.getElementById('alert-succes-inscription');
    if (alertSucces && window.introJs) {
        setTimeout(function () {
            var steps = [
                {
                    element: '#alert-succes-inscription',
                    title: 'Inscription confirmée 🎉',
                    intro: "C'est fait, votre place est réservée ! Vous pouvez retrouver cette inscription à tout moment."
                },
                {
                    element: '#tour-mon-espace',
                    title: 'Retrouvez-la ici',
                    intro: "Cliquez sur \"Mon espace\" pour voir tous vos événements inscrits."
                }
            ];
            introJs().setOptions({
                steps: steps,
                nextLabel: 'Suivant →', doneLabel: 'Compris', showProgress: false, exitOnOverlayClick: true
            }).start();
        }, 400);
    }
});
</script>
@stack('scripts')
</body>
</html>