<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Event Manager – @yield('title', 'Dashboard')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --navy:   #1a2744;
            --blue:   #2563eb;
            --blue-light: #3b82f6;
            --sky:    #e8f0fe;
            --white:  #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-600: #475569;
            --gray-800: #1e293b;
            --green:  #10b981;
            --orange: #f59e0b;
            --red:    #ef4444;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            min-height: 100vh;
            display: flex;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: var(--navy);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 38px; height: 38px;
            background: var(--blue);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }

        .logo-text { color: white; font-weight: 700; font-size: 15px; line-height: 1.2; }
        .logo-text span { color: var(--blue-light); }

        .sidebar-nav { padding: 16px 12px; flex: 1; overflow-y: auto; }

        .nav-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--gray-400);
            padding: 8px 8px 4px;
            margin-top: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all .15s;
            margin-bottom: 2px;
        }

        .nav-item:hover { background: rgba(255,255,255,0.07); color: white; }
        .nav-item.active { background: var(--blue); color: white; }
        .nav-item .icon { font-size: 16px; width: 20px; text-align: center; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 8px;
            background: rgba(255,255,255,0.05);
        }

        .user-avatar {
            width: 34px; height: 34px;
            background: var(--blue);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: white; flex-shrink: 0;
        }

        .user-info { overflow: hidden; flex: 1; }
        .user-name { color: white; font-size: 13px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { color: var(--gray-400); font-size: 11px; }

        .logout-btn { color: var(--gray-400); background: none; border: none; font-size: 16px; cursor: pointer; transition: color .15s; }
        .logout-btn:hover { color: var(--red); }

        /* ===== Main ===== */
        .main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-width: 0; }

        .topbar {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 0 28px;
            min-height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 10;
            flex-wrap: wrap;
            gap: 10px;
        }

        .page-title { font-size: 20px; font-weight: 700; color: var(--navy); }
        .page-subtitle { font-size: 13px; color: var(--gray-400); margin-top: 1px; }
        .topbar-actions { display: flex; align-items: center; gap: 12px; }

        .btn-primary, .topbar-btn {
            background: var(--blue);
            color: white !important;
            border: none;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background .15s;
        }
        .btn-primary:hover, .topbar-btn:hover { background: var(--navy); color: white; }

        .content { padding: 28px; }

        /* ===== Stat cards ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 22px 22px 18px;
            border: 1px solid var(--gray-200);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
        }

        .stat-card.blue::before   { background: var(--blue); }
        .stat-card.green::before  { background: var(--green); }
        .stat-card.orange::before { background: var(--orange); }
        .stat-card.navy::before   { background: var(--navy); }

        .stat-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .stat-label { font-size: 12px; font-weight: 600; color: var(--gray-400); text-transform: uppercase; letter-spacing: .5px; }

        .stat-icon {
            width: 36px; height: 36px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
        }

        .stat-icon.blue   { background: var(--sky); }
        .stat-icon.green  { background: #d1fae5; }
        .stat-icon.orange { background: #fef3c7; }
        .stat-icon.navy   { background: #e0e7ff; }

        .stat-value { font-size: 32px; font-weight: 800; color: var(--navy); line-height: 1; }
        .stat-suffix { font-size: 16px; font-weight: 600; color: var(--gray-400); }
        .stat-change { font-size: 12px; color: var(--gray-400); margin-top: 6px; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }

        .card { background: white; border-radius: 14px; border: 1px solid var(--gray-200); overflow: hidden; }

        .card-header {
            padding: 18px 22px 14px;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title { font-size: 15px; font-weight: 700; color: var(--navy); }
        .card-action { font-size: 12px; color: var(--blue); text-decoration: none; font-weight: 600; }
        .card-action:hover { text-decoration: underline; }

        .events-table { width: 100%; }

        .events-table th {
            font-size: 11px; font-weight: 600; letter-spacing: .5px;
            text-transform: uppercase; color: var(--gray-400);
            padding: 10px 22px; text-align: left; background: var(--gray-50);
        }

        .events-table td {
            padding: 14px 22px; font-size: 13px;
            border-top: 1px solid var(--gray-100); vertical-align: middle;
        }

        .events-table tr:hover td { background: var(--gray-50); }

        .event-name { font-weight: 600; color: var(--navy); text-decoration: none; }
        .event-name:hover { color: var(--blue); text-decoration: underline; }
        .event-meta { font-size: 11px; color: var(--gray-400); margin-top: 2px; }

        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-upcoming { background: var(--sky); color: var(--blue); }
        .badge-active   { background: #d1fae5; color: #059669; }
        .badge-past     { background: var(--gray-100); color: var(--gray-600); }
        .badge-cancelled{ background: #fee2e2; color: var(--red); }

        .participants-count { display: flex; align-items: center; gap: 6px; font-size: 13px; }

        .mini-bar { width: 60px; height: 5px; background: var(--gray-200); border-radius: 3px; overflow: hidden; }
        .mini-bar-fill { height: 100%; background: var(--blue); border-radius: 3px; }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        .quick-btn {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 18px 14px;
            text-align: center;
            text-decoration: none;
            color: var(--navy);
            cursor: pointer;
            transition: all .15s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .quick-btn:hover {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(37,99,235,.08);
            transform: translateY(-1px);
        }

        .quick-btn-icon {
            width: 42px; height: 42px;
            border-radius: 11px;
            background: var(--sky);
            display: flex; align-items: center; justify-content: center;
            font-size: 19px;
        }

        .quick-btn-label { font-size: 13px; font-weight: 600; }

        .empty-state { text-align: center; padding: 40px 20px; color: var(--gray-400); }
        .empty-icon { font-size: 36px; margin-bottom: 10px; }
        .empty-title { font-size: 14px; font-weight: 600; color: var(--gray-600); }
        .empty-sub { font-size: 13px; margin-top: 4px; }

        .action-btns { display: flex; gap: 6px; }

        .btn-sm {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: opacity .15s;
        }
        .btn-sm:hover { opacity: 0.8; }
        .btn-edit  { background: var(--sky); color: var(--blue); }
        .btn-view  { background: #d1fae5; color: #059669; }
        .btn-del   { background: #fee2e2; color: var(--red); }

        /* ===== Page card (listes génériques : participants, etc.) ===== */
        .page-card { background: white; border-radius: 14px; border: 1px solid var(--gray-200); overflow: hidden; }
        .page-card-header {
            padding: 18px 22px; border-bottom: 1px solid var(--gray-100);
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;
        }
        .badge-status { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .badge-present   { background: #d1fae5; color: #059669; }
        .badge-absent    { background: #fee2e2; color: var(--red); }
        .badge-registered{ background: #fef3c7; color: #b45309; }
        .btn-action {
            width: 32px; height: 32px; border-radius: 8px; border: none;
            display: inline-flex; align-items: center; justify-content: center;
            text-decoration: none; cursor: pointer; transition: opacity .15s;
        }
        .btn-action:hover { opacity: .8; }

        /* ===== Flash messages ===== */
        .flash-alert {
            margin: 18px 28px 0;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .flash-success { background: #d1fae5; color: #065f46; }
        .flash-error   { background: #fee2e2; color: #991b1b; }

        @media (max-width: 991px) {
            .sidebar { display: none; }
            .main { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">📅</div>
        <div class="logo-text">Event<span>Manager</span></div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Principal</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="icon">🏠</span> Dashboard
        </a>
        <a href="{{ route('admin.events.index') }}" class="nav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
            <span class="icon">📅</span> Événements
        </a>
        <a href="{{ route('admin.participants.index') }}" class="nav-item {{ request()->routeIs('admin.participants.*') ? 'active' : '' }}">
            <span class="icon">👥</span> Participants
        </a>

        <div class="nav-label">Administration</div>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <span class="icon">🔐</span> Comptes utilisateurs
        </a>

        <div class="nav-label">Système</div>
        <a href="{{ route('admin.profile.edit') }}" class="nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <span class="icon">⚙️</span> Paramètres
        </a>
        <a href="{{ route('home') }}" class="nav-item">
            <span class="icon">🌐</span> Voir le site public
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Administrateur</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn" title="Déconnexion">↩</button>
            </form>
        </div>
    </div>
</aside>

<div class="main">

    <header class="topbar">
        <div>
            <div class="page-title">@yield('page-title', 'Dashboard')</div>
            <div class="page-subtitle">@yield('page-sub', '')</div>
        </div>
        <div class="topbar-actions">
            @yield('page-actions')
        </div>
    </header>

    @if(session('success'))
        <div class="flash-alert flash-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash-alert flash-error"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
    @endif

    <main class="content">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
