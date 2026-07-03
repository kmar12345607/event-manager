@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-sub', 'Bienvenue, ' . auth()->user()->name . ' — ' . now()->translatedFormat('l d F Y'))

@section('page-actions')
    <a href="{{ route('admin.events.create') }}" class="btn-primary">+ Nouvel événement</a>
@endsection

@section('content')

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
        <a href="{{ route('admin.events.create') }}" class="quick-btn">
            <div class="quick-btn-icon">➕</div>
            <div class="quick-btn-label">Créer un événement</div>
        </a>
        <a href="{{ route('admin.participants.create') }}" class="quick-btn">
            <div class="quick-btn-icon">👤</div>
            <div class="quick-btn-label">Ajouter un participant</div>
        </a>
        <a href="{{ route('admin.events.index') }}" class="quick-btn">
            <div class="quick-btn-icon">📋</div>
            <div class="quick-btn-label">Prendre les présences</div>
        </a>
        <a href="{{ route('admin.participants.index') }}" class="quick-btn">
            <div class="quick-btn-icon">📊</div>
            <div class="quick-btn-label">Voir les participants</div>
        </a>
    </div>

    <div class="grid-2">
        <div class="card" style="grid-column: 1 / -1;">
            <div class="card-header">
                <div class="card-title">Événements récents</div>
                <a href="{{ route('admin.events.index') }}" class="card-action">Voir tous →</a>
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
                            <a href="{{ route('admin.events.show', $event) }}" class="event-name">
                                {{ $event->name }}
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
                                <a href="{{ route('admin.events.show', $event) }}" class="btn-sm btn-view">👁 Voir</a>
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn-sm btn-edit">✏️ Éditer</a>
                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Supprimer cet événement ?')">
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

@endsection
