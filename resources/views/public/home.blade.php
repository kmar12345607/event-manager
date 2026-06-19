@extends('layouts.public')
@section('title', 'Accueil')

@section('content')

{{-- HERO --}}
<section style="background: linear-gradient(135deg, #0f172a 0%, #1e40af 60%, #2563eb 100%); min-height: 92vh; display: flex; align-items: center; padding: 3rem 0; position: relative; overflow: hidden;">
    <div style="position:absolute;top:-80px;right:-80px;width:400px;height:400px;border-radius:50%;background:rgba(255,255,255,0.04);"></div>
    <div style="position:absolute;bottom:-100px;left:-60px;width:300px;height:300px;border-radius:50%;background:rgba(255,255,255,0.03);"></div>
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div style="display:inline-block;background:rgba(255,255,255,0.12);color:#93c5fd;font-size:.8rem;padding:.4rem 1rem;border-radius:999px;margin-bottom:1.5rem;">
                    🎯 Plateforme de gestion d'événements
                </div>
                <h1 style="color:#fff;font-size:3rem;font-weight:800;line-height:1.15;margin-bottom:1.25rem;">
                    Gérez vos événements<br>
                    <span style="color:#60a5fa;">simplement.</span>
                </h1>
                <p style="color:#94a3b8;font-size:1.1rem;line-height:1.8;margin-bottom:2rem;">
                    Découvrez nos événements, inscrivez-vous en quelques clics et suivez votre participation. Une expérience simple et rapide pour tous.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#evenements" style="background:#2563eb;color:#fff;padding:.85rem 2rem;border-radius:8px;text-decoration:none;font-weight:700;font-size:.95rem;">
                        Voir les événements →
                    </a>
                    <a href="#apropos" style="background:rgba(255,255,255,0.1);color:#fff;padding:.85rem 2rem;border-radius:8px;text-decoration:none;font-weight:500;border:1px solid rgba(255,255,255,0.2);">
                        En savoir plus
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=700&q=80"
                     alt="Événement"
                     style="border-radius:16px;width:100%;max-width:520px;object-fit:cover;height:370px;box-shadow:0 25px 60px rgba(0,0,0,0.5);">
            </div>
        </div>
    </div>
</section>

{{-- STATS --}}
<section style="background:#1e293b;padding:2.5rem 0;">
    <div class="container">
        @php
            $totalEvents       = \App\Models\Event::count();
            $totalParticipants = \App\Models\Participant::count();
            $present           = \App\Models\Participant::where('attendance_status','present')->count();
            $rate              = $totalParticipants > 0 ? round(($present/$totalParticipants)*100) : 0;
            $upcomingCount     = \App\Models\Event::whereIn('status',['active','upcoming','ongoing'])->count();
        @endphp
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <div style="color:#60a5fa;font-size:2.2rem;font-weight:800;">{{ $totalEvents }}+</div>
                <div style="color:#94a3b8;font-size:.9rem;">Événements organisés</div>
            </div>
            <div class="col-6 col-md-3">
                <div style="color:#34d399;font-size:2.2rem;font-weight:800;">{{ $totalParticipants }}+</div>
                <div style="color:#94a3b8;font-size:.9rem;">Participants inscrits</div>
            </div>
            <div class="col-6 col-md-3">
                <div style="color:#f59e0b;font-size:2.2rem;font-weight:800;">{{ $upcomingCount }}</div>
                <div style="color:#94a3b8;font-size:.9rem;">Événements à venir</div>
            </div>
            <div class="col-6 col-md-3">
                <div style="color:#a78bfa;font-size:2.2rem;font-weight:800;">100%</div>
                <div style="color:#94a3b8;font-size:.9rem;">Inscription gratuite</div>
            </div>
        </div>
    </div>
</section>

{{-- ÉVÉNEMENTS --}}
<section id="evenements" style="padding:5rem 0;background:#f8fafc;">
    <div class="container">
        <div class="text-center mb-5">
            <span style="color:#2563eb;font-size:.85rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;">Nos événements</span>
            <h2 style="font-size:2rem;font-weight:800;color:#0f172a;margin-top:.5rem;">Événements disponibles</h2>
            <p style="color:#64748b;max-width:500px;margin:auto;">Inscrivez-vous aux événements qui vous intéressent en quelques secondes.</p>
        </div>

        @if($events->isEmpty())
            <div class="text-center py-5">
                <div style="font-size:3rem;margin-bottom:1rem;">📅</div>
                <h5 style="color:#64748b;">Aucun événement disponible pour le moment</h5>
                <p style="color:#94a3b8;">Revenez bientôt !</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($events as $event)
                @php
                    $percent  = $event->max_participants > 0
                        ? round(($event->participants_count / $event->max_participants) * 100) : 0;
                    $isFull   = $event->participants_count >= $event->max_participants;
                    $barColor = $percent >= 90 ? '#ef4444' : ($percent >= 60 ? '#f59e0b' : '#22c55e');
                    $dateFormatted = $event->event_date
                        ? \Carbon\Carbon::parse($event->event_date)->format('d/m/Y')
                        : 'Date non définie';
                    $eventImages = [
                        'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=400&q=80',
                        'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=400&q=80',
                        'https://images.unsplash.com/photo-1591115765373-5207764f72e7?w=400&q=80',
                        'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=400&q=80',
                        'https://images.unsplash.com/photo-1560439514-4e9645039924?w=400&q=80',
                    ];
                    $img = $eventImages[$event->id % count($eventImages)];
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.07);transition:transform .2s,box-shadow .2s;height:100%;"
                         onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 12px 32px rgba(0,0,0,0.13)'"
                         onmouseout="this.style.transform='';this.style.boxShadow='0 2px 12px rgba(0,0,0,0.07)'">

                        {{-- Vraie photo --}}
                        <div style="position:relative;height:200px;overflow:hidden;">
                            <img src="{{ $img }}" alt="{{ $event->name }}"
                                 style="width:100%;height:100%;object-fit:cover;">
                            <div style="position:absolute;inset:0;background:linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.4));"></div>
                            <div style="position:absolute;top:12px;left:12px;">
                                <span style="background:rgba(255,255,255,0.9);color:#1e40af;font-size:.72rem;padding:.3rem .7rem;border-radius:999px;font-weight:600;">
                                    @if(in_array($event->status, ['active','upcoming','ongoing']))
                                        🟢 À venir
                                    @elseif(in_array($event->status, ['done','completed']))
                                        ⚫ Terminé
                                    @else
                                        🔴 Annulé
                                    @endif
                                </span>
                            </div>
                            @if($isFull)
                                <div style="position:absolute;top:12px;right:12px;">
                                    <span style="background:#ef4444;color:#fff;font-size:.72rem;padding:.3rem .7rem;border-radius:999px;font-weight:600;">Complet</span>
                                </div>
                            @endif
                        </div>

                        <div style="padding:1.25rem;">
                            <h5 style="font-weight:700;color:#0f172a;margin-bottom:.75rem;font-size:1rem;">{{ $event->name }}</h5>
                            <div style="color:#64748b;font-size:.85rem;margin-bottom:.4rem;">
                                <i class="bi bi-calendar3 me-1 text-primary"></i>{{ $dateFormatted }}
                            </div>
                            <div style="color:#64748b;font-size:.85rem;margin-bottom:.4rem;">
                                <i class="bi bi-geo-alt me-1 text-primary"></i>{{ $event->location }}
                            </div>
                            <div style="color:#64748b;font-size:.85rem;margin-bottom:1rem;">
                                <i class="bi bi-people me-1 text-primary"></i>{{ $event->participants_count }} / {{ $event->max_participants }} inscrits
                            </div>
                            <div style="background:#e2e8f0;border-radius:4px;height:6px;margin-bottom:.4rem;">
                                <div style="background:{{ $barColor }};width:{{ $percent }}%;height:100%;border-radius:4px;"></div>
                            </div>
                            <div style="font-size:.75rem;color:#94a3b8;margin-bottom:1.25rem;">
                                {{ $isFull ? 'Complet' : ($event->max_participants - $event->participants_count).' place(s) restante(s)' }}
                            </div>
                            @if($event->description)
                                <p style="color:#64748b;font-size:.85rem;margin-bottom:1.25rem;line-height:1.6;">
                                    {{ \Illuminate\Support\Str::limit($event->description, 90) }}
                                </p>
                            @endif
                            <a href="{{ route('public.events.show', $event) }}"
                               style="display:block;text-align:center;padding:.75rem;border-radius:8px;font-weight:600;font-size:.9rem;text-decoration:none;
                                      background:{{ $isFull ? '#f1f5f9' : '#2563eb' }};
                                      color:{{ $isFull ? '#94a3b8' : '#fff' }};">
                                {{ $isFull ? 'Complet' : "S'inscrire →" }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($events->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $events->links() }}
                </div>
            @endif
        @endif
    </div>
</section>

{{-- COMMENT ÇA MARCHE --}}
<section style="padding:5rem 0;background:#fff;">
    <div class="container">
        <div class="text-center mb-5">
            <span style="color:#2563eb;font-size:.85rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;">Simple & rapide</span>
            <h2 style="font-size:2rem;font-weight:800;color:#0f172a;margin-top:.5rem;">Comment ça marche ?</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <div style="background:#eff6ff;width:70px;height:70px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.75rem;">🔍</div>
                <h5 style="font-weight:700;color:#0f172a;">Parcourir</h5>
                <p style="color:#64748b;font-size:.9rem;">Consultez la liste des événements disponibles et trouvez celui qui vous intéresse.</p>
            </div>
            <div class="col-md-4 text-center">
                <div style="background:#eff6ff;width:70px;height:70px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.75rem;">📝</div>
                <h5 style="font-weight:700;color:#0f172a;">S'inscrire</h5>
                <p style="color:#64748b;font-size:.9rem;">Remplissez le formulaire d'inscription en quelques secondes, sans créer de compte.</p>
            </div>
            <div class="col-md-4 text-center">
                <div style="background:#eff6ff;width:70px;height:70px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.75rem;">✅</div>
                <h5 style="font-weight:700;color:#0f172a;">Participer</h5>
                <p style="color:#64748b;font-size:.9rem;">Votre place est réservée, participez à l'événement le jour J.</p>
            </div>
        </div>
    </div>
</section>

{{-- À PROPOS --}}
<section id="apropos" style="padding:5rem 0;background:#f8fafc;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=700&q=80"
                     alt="À propos"
                     style="border-radius:16px;width:100%;object-fit:cover;height:400px;box-shadow:0 12px 40px rgba(0,0,0,0.12);">
            </div>
            <div class="col-lg-6">
                <span style="color:#2563eb;font-size:.85rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;">À propos</span>
                <h2 style="font-size:2rem;font-weight:800;color:#0f172a;margin-top:.5rem;margin-bottom:1.25rem;">Notre plateforme</h2>
                <p style="color:#64748b;line-height:1.8;margin-bottom:1rem;">
                    EventManager est une plateforme de gestion d'événements conçue pour simplifier l'organisation et le suivi des participants. Notre objectif est de rendre l'inscription aux événements accessible à tous.
                </p>
                <p style="color:#64748b;line-height:1.8;margin-bottom:1.5rem;">
                    Que ce soit pour des conférences, des workshops, des hackathons ou des formations, notre plateforme s'adapte à tous types d'événements.
                </p>
                <div class="row g-3">
                    @foreach(['Inscription gratuite','Interface intuitive','Gestion simplifiée','Suivi en temps réel'] as $feat)
                    <div class="col-6">
                        <div style="display:flex;align-items:center;gap:.5rem;font-size:.9rem;color:#0f172a;font-weight:500;">
                            <span style="color:#22c55e;font-size:1.1rem;">✓</span> {{ $feat }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA FINAL --}}
<section style="background:linear-gradient(135deg,#1e40af,#2563eb);padding:5rem 0;text-align:center;">
    <div class="container">
        <h2 style="color:#fff;font-size:2.2rem;font-weight:800;margin-bottom:1rem;">Prêt à vous inscrire ?</h2>
        <p style="color:#bfdbfe;font-size:1rem;margin-bottom:2rem;max-width:500px;margin-left:auto;margin-right:auto;">
            Rejoignez nos événements et développez vos compétences professionnelles.
        </p>
        <a href="#evenements" style="background:#fff;color:#1e40af;padding:1rem 2.5rem;border-radius:8px;text-decoration:none;font-weight:700;font-size:1rem;">
            Voir les événements →
        </a>
    </div>
</section>

@endsection