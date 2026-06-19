<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Manager – Dashboard</title>
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

        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: var(--navy);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
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

        .sidebar-nav { padding: 16px 12px; flex: 1; }

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

        .main { margin-left: 240px; flex: 1; display: flex; flex-direction: column; }

        .topbar {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 0 28px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .page-title { font-size: 20px; font-weight: 700; color: var(--navy); }
        .page-subtitle { font-size: 13px; color: var(--gray-400); margin-top: 1px; }
        .topbar-actions { display: flex; align-items: center; gap: 12px; }

        .btn-primary {
            background: var(--blue);
            color: white;
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
        .btn-primary:hover { background: var(--navy); }

        .content { padding: 28px; }

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
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon">📅</div>
        <div class="logo-text">Event<span>Manager</span></div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Principal</div>
        <a href="{{ route('dashboard') }}" class="nav-item active">
            <span class="icon">🏠</span> Dashboard
        </a>
        <a href="{{ route('events.index') }}" class="nav-item">
            <span class="icon">📅</span> Événements
        </a>
        <a href="{{ route('events.index') }}" class="nav-item">
            <span class="icon">👥</span> Participants
        </a>
        <a href="{{ route('events.index') }}" class="nav-item">
            <span class="icon">✅</span> Présences
        </a>

        <div class="nav-label">Rapports</div>
        <a href="{{ route('events.index') }}" class="nav-item">
            <span class="icon">📊</span> Statistiques
        </a>
        <a href="{{ route('events.index') }}" class="nav-item">
            <span class="icon">📤</span> Exporter
        </a>

        <div class="nav-label">Système</div>
        <a href="{{ route('profile.edit') }}" class="nav-item">
            <span class="icon">⚙️</span> Paramètres
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
            <div class="page-title">Dashboard</div>
            <div class="page-subtitle">Bienvenue, {{ auth()->user()->name }} 👋 — {{ now()->translatedFormat('l d F Y') }}</div>
        </div>
        <div class="topbar-actions">
            <a href="{{ route('events.create') }}" class="btn-primary">+ Nouvel événement</a>
        </div>
    </header>

    <main class="content">

        <div class="stats-grid">
            <div class="stat-card blue">
                <div class="stat-header">
                    <div class="stat-label">Événements total</div>
                    <div class="stat-icon blue">📅</div>
                </div>
                <div class="stat-value">{{ $stats['total_events'] }}</div>
                <div class="stat-change">Tous les événements créés</div>
            </div>

            <div class="stat-card green">
                <div class="stat-header">
                    <div class="stat-label">Participants</div>
                    <div class="stat-icon green">👥</div>
                </div>
                <div class="stat-value">{{ $stats['total_participants'] }}</div>
                <div class="stat-change">Inscrits au total</div>
            </div>

            <div class="stat-card orange">
                <div class="stat-header">
                    <div class="stat-label">Taux de présence</div>
                    <div class="stat-icon orange">✅</div>
                </div>
                <div class="stat-value">{{ $stats['attendance_rate'] }}<span class="stat-suffix">%</span></div>
                <div class="stat-change">{{ $stats['present_count'] }} présents enregistrés</div>
            </div>

            <div class="stat-card navy">
                <div class="stat-header">
                    <div class="stat-label">À venir</div>
                    <div class="stat-icon navy">🚀</div>
                </div>
                <div class="stat-value">{{ $stats['upcoming_events'] }}</div>
                <div class="stat-change">Événements planifiés</div>
            </div>
        </div>

        <div class="quick-actions">
            <a href="{{ route('events.create') }}" class="quick-btn">
                <div class="quick-btn-icon">➕</div>
                <div class="quick-btn-label">Créer un événement</div>
            </a>
            <a href="{{ route('events.index') }}" class="quick-btn">
                <div class="quick-btn-icon">👤</div>
                <div class="quick-btn-label">Ajouter un participant</div>
            </a>
            <a href="{{ route('events.index') }}" class="quick-btn">
                <div class="quick-btn-icon">📋</div>
                <div class="quick-btn-label">Prendre les présences</div>
            </a>
            <a href="{{ route('events.index') }}" class="quick-btn">
                <div class="quick-btn-icon">📊</div>
                <div class="quick-btn-label">Voir les rapports</div>
            </a>
        </div>

        <div class="grid-2">
            <div class="card" style="grid-column: 1 / -1;">
                <div class="card-header">
                    <div class="card-title">Événements récents</div>
                    <a href="{{ route('events.index') }}" class="card-action">Voir tous →</a>
                </div>

                @if($recentEvents->count() > 0)
                <table class="events-table">
                    <thead>
                        <tr>
                            <th>Événement</th>
                            <th>Statut</th>
                            <th>Participants</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentEvents as $event)
                        <tr>
                            <td>
                                <a href="{{ route('events.show', $event) }}" class="event-name">
                                    {{ $event->title ?? $event->name }}
                                </a>
                                <div class="event-meta">{{ $event->location ?? '—' }}</div>
                            </td>
                            <td>
                                @php
                                    $statusMap = [
                                        'upcoming'  => ['label' => 'À venir',  'class' => 'badge-upcoming'],
                                        'ongoing'   => ['label' => 'En cours', 'class' => 'badge-active'],
                                        'completed' => ['label' => 'Terminé',  'class' => 'badge-past'],
                                        'cancelled' => ['label' => 'Annulé',   'class' => 'badge-cancelled'],
                                    ];
                                    $s = $statusMap[$event->status] ?? ['label' => $event->status, 'class' => 'badge-past'];
                                @endphp
                                <span class="badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                            </td>
                            <td>
                                <div class="participants-count">
                                    {{ $event->participants_count }}
                                    <div class="mini-bar">
                                        <div class="mini-bar-fill" style="width: {{ min(100, ($event->participants_count / max(1, $stats['total_participants'])) * 100 * 3) }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td style="color: var(--gray-600);">{{ $event->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('events.show', $event) }}" class="btn-sm btn-view">👁 Voir</a>
                                    <a href="{{ route('events.edit', $event) }}" class="btn-sm btn-edit">✏️ Éditer</a>
                                    <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('Supprimer cet événement ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn-del">🗑</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <div class="empty-icon">📅</div>
                    <div class="empty-title">Aucun événement pour l'instant</div>
                    <div class="empty-sub">Créez votre premier événement pour commencer</div>
                </div>
                @endif
            </div>
        </div>

    </main>
</div>

</body>
</html>