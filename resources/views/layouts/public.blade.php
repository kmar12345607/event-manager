<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EventManager') — Événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
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
    </style>
</head>
<body>

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
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('participant.dashboard') }}" style="background:rgba(255,255,255,0.15);color:#fff;padding:.45rem 1.1rem;border-radius:8px;text-decoration:none;font-size:.9rem;font-weight:500;">
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
                <a href="#evenements" style="background:#fff;color:#1a56db;padding:.45rem 1.1rem;border-radius:8px;text-decoration:none;font-size:.9rem;font-weight:700;">
                    Commencer
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- Alertes -->
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>