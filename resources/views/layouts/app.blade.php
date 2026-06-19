<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }
        .navbar-brand { font-weight: 700; font-size: 1.3rem; }
        .sidebar {
            min-height: calc(100vh - 60px);
            background: #1a237e;
            width: 240px;
            position: fixed;
            top: 60px;
            left: 0;
            padding-top: 20px;
            z-index: 100;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.75);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 10px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
        }
        .sidebar .nav-link i { width: 20px; }
        .main-content {
            margin-left: 240px;
            padding: 30px;
            margin-top: 60px;
        }
        .top-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 200;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            height: 60px;
        }
        .user-badge {
            background: #e8eaf6;
            color: #1a237e;
            border-radius: 20px;
            padding: 6px 15px;
            font-weight: 600;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<!-- TOP NAVBAR -->
<nav class="navbar top-navbar px-4">
    <a class="navbar-brand text-primary" href="{{ route('events.index') }}">
        <i class="bi bi-calendar-event-fill me-2"></i>Event Manager
    </a>
    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="user-badge">
            <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
        </span>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
            </button>
        </form>
    </div>
</nav>

<!-- SIDEBAR -->
<div class="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}"
               href="{{ route('events.index') }}">
                <i class="bi bi-calendar-event me-2"></i>Événements
            </a>
        </li>
        <li class="nav-item">
<a class="nav-link {{ request()->routeIs('events.participants.*') ? 'active' : '' }}"
   href="{{ route('events.index') }}">
    <i class="bi bi-people me-2"></i>Participants
</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}"
               href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
        </li>
        <hr style="border-color: rgba(255,255,255,0.2); margin: 10px 15px;">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('profile.edit') }}">
                <i class="bi bi-person-gear me-2"></i>Mon profil
            </a>
        </li>
    </ul>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
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

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>