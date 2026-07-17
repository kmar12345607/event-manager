@extends('layouts.public')
@section('title', $event->name)

@section('content')
<style>
    .evt-page { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f0f2f8; }

    /* Bandeau héro */
    .evt-hero {
        background: linear-gradient(135deg, #0d1b4b 0%, #1a237e 45%, #1565c0 100%);
        padding: 70px 0 90px; position: relative; overflow: hidden;
    }
    .evt-hero::before {
        content: ''; position: absolute; inset: 0;
        background-image: radial-gradient(circle at 15% 20%, rgba(144,202,249,0.15) 0%, transparent 45%),
                           radial-gradient(circle at 85% 80%, rgba(124,77,255,0.12) 0%, transparent 45%);
    }
    .evt-hero-inner { position: relative; z-index: 2; }
    .evt-badge {
        display: inline-flex; align-items: center; gap: 7px;
        border-radius: 30px; padding: 6px 16px; font-size: 0.78rem; font-weight: 800;
        margin-bottom: 18px; backdrop-filter: blur(10px);
    }
    .evt-badge.s-up { background: rgba(219,234,254,0.95); color: #1e40af; }
    .evt-badge.s-on { background: rgba(220,252,231,0.95); color: #166534; }
    .evt-badge.s-co { background: rgba(243,232,255,0.95); color: #7e22ce; }
    .evt-badge.s-ca { background: rgba(254,226,226,0.95); color: #991b1b; }
    .evt-hero h1 { color: white; font-weight: 900; font-size: 2.5rem; letter-spacing: -0.5px; margin-bottom: 18px; }
    .evt-hero-meta { display: flex; flex-wrap: wrap; gap: 22px; }
    .evt-hero-meta span { color: rgba(255,255,255,0.8); font-size: 0.92rem; display: flex; align-items: center; gap: 8px; font-weight: 500; }
    .evt-hero-meta i { color: #90caf9; }

    /* Cartes */
    .evt-cards-wrap { margin-top: -55px; position: relative; z-index: 3; padding-bottom: 80px; }
    .evt-card {
        background: white; border-radius: 20px; border: 1px solid #e8eaf6;
        box-shadow: 0 20px 50px rgba(13,27,75,0.12);
        transition: transform 0.15s ease-out, box-shadow 0.3s ease;
    }

    .evt-info-list { list-style: none; padding: 0; margin: 0 0 22px; }
    .evt-info-list li { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f0f2f8; color: #444; font-size: 0.92rem; }
    .evt-info-list li:last-child { border-bottom: none; }
    .evt-info-list i { width: 34px; height: 34px; border-radius: 10px; background: #eff6ff; color: #1565c0; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0; }

    .evt-prog-label { display: flex; justify-content: space-between; font-size: 0.8rem; color: #757575; margin-bottom: 6px; font-weight: 600; }
    .evt-prog-wrap { background: #e8eaf6; border-radius: 10px; height: 8px; overflow: hidden; margin-bottom: 4px; }
    .evt-prog-fill { height: 100%; border-radius: 10px; transition: width 0.6s ease; }

    .evt-desc { color: #666; font-size: 0.9rem; line-height: 1.7; }

    .btn-evt-back {
        border: 2px solid #e0e0e0; color: #555; border-radius: 30px;
        padding: 9px 20px; font-weight: 700; font-size: 0.85rem;
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.2s;
    }
    .btn-evt-back:hover { border-color: #1a237e; background: #1a237e; color: white; }

    /* Formulaire */
    .evt-form-title { font-weight: 900; color: #0d1b4b; font-size: 1.3rem; margin-bottom: 4px; }
    .evt-form-sub { color: #9e9e9e; font-size: 0.85rem; margin-bottom: 26px; }
    .evt-form label { font-weight: 700; font-size: 0.85rem; color: #333; margin-bottom: 6px; display: block; }
    .evt-form .req { color: #ef4444; }
    .evt-form .form-control {
        border: 2px solid #eceff8; border-radius: 12px; padding: 12px 16px;
        font-size: 0.92rem; transition: all 0.2s;
    }
    .evt-form .form-control:focus {
        border-color: #1565c0; box-shadow: 0 0 0 4px rgba(21,101,192,0.1); outline: none;
    }
    .btn-evt-submit {
        background: linear-gradient(135deg, #2563eb, #3b82f6); color: white;
        border: none; border-radius: 30px; padding: 15px; width: 100%;
        font-weight: 800; font-size: 0.95rem; transition: all 0.3s;
        box-shadow: 0 8px 20px rgba(37,99,235,0.3);
    }
    .btn-evt-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(37,99,235,0.45); color: white; }

    .evt-full-icon {
        width: 90px; height: 90px; border-radius: 50%; background: #fee2e2; color: #ef4444;
        display: flex; align-items: center; justify-content: center; font-size: 2.2rem; margin: 0 auto 20px;
    }

    /* Indicateur d'étapes (wizard) */
    .step-indicator { display: flex; align-items: center; margin-bottom: 30px; }
    .step-indicator .step-dot {
        width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 0.85rem; color: #9e9e9e;
        background: #eceff8; border: 2px solid #eceff8; transition: all 0.25s;
    }
    .step-indicator .step-label { font-size: 0.72rem; font-weight: 700; color: #9e9e9e; margin-top: 6px; text-align: center; transition: color 0.25s; }
    .step-indicator .step-item { display: flex; flex-direction: column; align-items: center; flex: 0 0 auto; width: 80px; }
    .step-indicator .step-line { flex: 1; height: 2px; background: #eceff8; margin: 0 -6px 20px; transition: background 0.25s; }
    .step-indicator .step-item.active .step-dot { background: #2563eb; border-color: #2563eb; color: white; }
    .step-indicator .step-item.active .step-label { color: #1a237e; }
    .step-indicator .step-item.done .step-dot { background: #16a34a; border-color: #16a34a; color: white; }
    .step-indicator .step-line.done { background: #16a34a; }

    .wizard-pane { display: none; }
    .wizard-pane.active { display: block; animation: fadeInStep 0.3s ease; }
    @keyframes fadeInStep { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

    .wizard-nav { display: flex; gap: 10px; margin-top: 8px; }
    .btn-wizard-prev {
        border: 2px solid #eceff8; background: white; color: #555; border-radius: 30px;
        padding: 13px 20px; font-weight: 700; font-size: 0.88rem; flex-shrink: 0; transition: all 0.2s;
    }
    .btn-wizard-prev:hover { border-color: #1a237e; color: #1a237e; }
    .btn-wizard-next {
        background: linear-gradient(135deg, #2563eb, #3b82f6); color: white; border: none;
        border-radius: 30px; padding: 13px 22px; font-weight: 800; font-size: 0.88rem;
        flex: 1; transition: all 0.3s; box-shadow: 0 8px 20px rgba(37,99,235,0.3);
    }
    .btn-wizard-next:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(37,99,235,0.45); color: white; }

    .recap-box { background: #f8faff; border: 1px solid #eceff8; border-radius: 14px; padding: 18px 20px; margin-bottom: 22px; }
    .recap-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #e0e6f5; font-size: 0.88rem; }
    .recap-row:last-child { border-bottom: none; }
    .recap-row .k { color: #9e9e9e; font-weight: 600; }
    .recap-row .v { color: #1a237e; font-weight: 700; text-align: right; }

    /* Bandeau "Se connecter" incitatif */
    .evt-login-hint {
        display: flex; align-items: center; gap: 12px;
        background: linear-gradient(135deg, #eff6ff, #f0f7ff);
        border: 1px solid #dbeafe; border-radius: 14px;
        padding: 14px 16px; margin-bottom: 22px;
    }
    .evt-login-hint i { font-size: 1.3rem; color: #1565c0; flex-shrink: 0; }
    .evt-login-hint p { font-size: 0.84rem; color: #334155; margin: 0; line-height: 1.4; }
    .evt-login-hint a { color: #1565c0; font-weight: 800; text-decoration: none; }
    .evt-login-hint a:hover { text-decoration: underline; }
</style>

<div class="evt-page">

    <!-- Héro -->
    <section class="evt-hero">
        <div class="container evt-hero-inner">
            @php
                $isFull = $event->participants_count >= $event->max_participants;
                $percent = $event->max_participants > 0
                    ? round(($event->participants_count / $event->max_participants) * 100)
                    : 0;
                $statusMap = [
                    'upcoming'  => ['label' => 'À venir',  'class' => 's-up', 'icon' => 'bi-clock'],
                    'ongoing'   => ['label' => 'En cours', 'class' => 's-on', 'icon' => 'bi-lightning-charge'],
                    'completed' => ['label' => 'Terminé',  'class' => 's-co', 'icon' => 'bi-check-circle'],
                    'cancelled' => ['label' => 'Annulé',   'class' => 's-ca', 'icon' => 'bi-x-circle'],
                ];
                $s = $statusMap[$event->status] ?? $statusMap['upcoming'];
            @endphp

            <span class="evt-badge {{ $s['class'] }}"><i class="bi {{ $s['icon'] }}"></i> {{ $s['label'] }}</span>
            <h1>{{ $event->name }}</h1>

            <div class="evt-hero-meta">
                <span><i class="bi bi-calendar3"></i>{{ $event->event_date->translatedFormat('l d F Y à H:i') }}</span>
                <span><i class="bi bi-geo-alt"></i>{{ $event->location }}</span>
                <span><i class="bi bi-people"></i>{{ $event->participants_count }} / {{ $event->max_participants }} inscrits</span>
            </div>
        </div>
    </section>

    <!-- Cartes -->
    <div class="container evt-cards-wrap">
        <div class="row g-4 justify-content-center">

            <!-- Infos événement -->
            <div class="col-lg-5">
                <div class="evt-card p-4 sticky-top" style="top: 90px;"
                     data-intro="Ici tu retrouves toutes les infos clés de l'événement : date, lieu, et nombre de places déjà prises."
                     data-step="1"
                     data-title="Infos de l'événement">
                    <ul class="evt-info-list">
                        <li><i class="bi bi-calendar3"></i> {{ $event->event_date->translatedFormat('l d F Y à H:i') }}</li>
                        <li><i class="bi bi-geo-alt"></i> {{ $event->location }}</li>
                        <li><i class="bi bi-people"></i> {{ $event->participants_count }} / {{ $event->max_participants }} inscrits</li>
                    </ul>

                    <div class="mb-4"
                         data-intro="Cette barre indique le taux de remplissage. Si elle atteint 100%, l'événement est complet et les inscriptions se ferment automatiquement."
                         data-step="2"
                         data-title="Places disponibles">
                        <div class="evt-prog-label">
                            <span>Remplissage</span>
                            <span>{{ $percent }}%</span>
                        </div>
                        <div class="evt-prog-wrap">
                            <div class="evt-prog-fill" style="width:{{ $percent }}%; background: {{ $percent >= 90 ? '#ef4444' : ($percent >= 60 ? '#f59e0b' : 'linear-gradient(90deg,#2563eb,#3b82f6)') }};"></div>
                        </div>
                    </div>

                    @if($event->description)
                        <p class="evt-desc mb-4">{{ $event->description }}</p>
                    @endif

                    <a href="{{ route('home') }}" class="btn-evt-back">
                        <i class="bi bi-arrow-left"></i> Retour aux événements
                    </a>
                </div>
            </div>

            <!-- Formulaire d'inscription -->
            <div class="col-lg-6">
                @if($isFull)
                    <div class="evt-card p-5 text-center">
                        <div class="evt-full-icon"><i class="bi bi-calendar-x"></i></div>
                        <h5 class="fw-bold mb-2" style="color:#0d1b4b;">Événement complet</h5>
                        <p class="text-muted mb-4">Toutes les places ont été prises. Revenez pour les prochains événements.</p>
                        <a href="{{ route('home') }}" class="btn-evt-submit d-inline-block" style="width:auto;padding:12px 30px;">
                            Voir d'autres événements
                        </a>
                    </div>
                @else
                    <div class="evt-card p-4 evt-form">
                        @guest
                        <div class="evt-form-title"
                             data-intro="C'est ici que tu t'inscris ! Il te faut juste un compte, puis un formulaire en 3 petites étapes."
                             data-step="3"
                             data-title="S'inscrire">S'inscrire à cet événement</div>
                        <p class="evt-form-sub">Un compte est nécessaire pour s'inscrire.</p>

                        <!-- Mur de connexion : compte obligatoire -->
                        <div class="text-center py-4"
                             data-intro="Un compte est obligatoire pour s'inscrire à un événement : ça permet de retrouver toutes tes inscriptions dans &quot;Mon espace&quot; et d'éviter les doublons."
                             data-step="4"
                             data-title="Compte obligatoire">
                            <div class="evt-full-icon" style="background:#eff6ff;color:#1565c0;">
                                <i class="bi bi-person-lock"></i>
                            </div>
                            <h6 class="fw-bold mb-2" style="color:#0d1b4b;">Connecte-toi pour t'inscrire</h6>
                            <p class="text-muted mb-4" style="font-size:.88rem;">
                                Un compte gratuit est nécessaire pour réserver ta place et
                                retrouver toutes tes inscriptions au même endroit.
                            </p>
                            <div class="d-grid gap-2">
                                <a href="{{ route('login') }}?redirect_to={{ urlencode(url()->current()) }}"
                                   class="btn-evt-submit d-inline-block" style="width:auto;padding:12px 30px;">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Se connecter
                                </a>
                                <a href="{{ route('register') }}?redirect_to={{ urlencode(url()->current()) }}"
                                   class="btn-evt-back d-inline-block" style="justify-content:center;">
                                    <i class="bi bi-person-plus"></i> Créer un compte (gratuit)
                                </a>
                            </div>
                        </div>
                        @else
                        @unless(auth()->user()->hasVerifiedEmail())
                        <!-- Compte connecté mais NON vérifié : page de vérification uniquement -->
                        <div class="evt-form-title">Vérifiez votre compte</div>
                        <p class="evt-form-sub">Une dernière étape avant de réserver votre place.</p>

                        <div class="text-center py-4">
                            <div class="evt-full-icon" style="background:#fff7ed;color:#f59e0b;">
                                <i class="bi bi-envelope-exclamation"></i>
                            </div>
                            <h6 class="fw-bold mb-2" style="color:#0d1b4b;">Vérifiez votre adresse email</h6>
                            <p class="text-muted mb-4" style="font-size:.88rem;">
                                Nous avons envoyé un lien de confirmation à
                                <strong>{{ auth()->user()->email }}</strong>.
                                Vérifiez votre boîte mail (et vos spams) puis cliquez sur
                                le lien pour activer votre compte et pouvoir vous inscrire.
                            </p>
                            <form action="{{ route('verification.send') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-evt-submit d-inline-block" style="width:auto;padding:12px 30px;">
                                    <i class="bi bi-arrow-clockwise me-1"></i> Renvoyer l'email de vérification
                                </button>
                            </form>
                        </div>
                        @else
                        <!-- Compte connecté ET vérifié : formulaire d'inscription complet -->
                        <div class="evt-form-title"
                             data-intro="C'est ici que tu t'inscris ! Il te faut juste un compte, puis un formulaire en 3 petites étapes."
                             data-step="3"
                             data-title="S'inscrire">S'inscrire à cet événement</div>
                        <p class="evt-form-sub">Suivez les 3 étapes pour réserver votre place.</p>

                        <!-- Indicateur d'étapes -->
                        <div class="step-indicator" id="stepIndicator">
                            <div class="step-item active" data-step-item="1"
                                 data-intro="Étape 1 : ton nom complet (ton email est déjà rempli, c'est celui de ton compte)."
                                 data-step="5"
                                 data-title="Étape 1 sur 3">
                                <div class="step-dot">1</div>
                                <div class="step-label">Vos infos</div>
                            </div>
                            <div class="step-line" data-step-line="1"></div>
                            <div class="step-item" data-step-item="2"
                                 data-intro="Étape 2 : ton téléphone et une éventuelle remarque (facultatif, tu peux passer directement à la suite)."
                                 data-step="6"
                                 data-title="Étape 2 sur 3">
                                <div class="step-dot">2</div>
                                <div class="step-label">Détails</div>
                            </div>
                            <div class="step-line" data-step-line="2"></div>
                            <div class="step-item" data-step-item="3"
                                 data-intro="Étape 3 : tu vérifies le récapitulatif et tu cliques sur &quot;Confirmer mon inscription&quot;. C'est fini, ta place est réservée !"
                                 data-step="7"
                                 data-title="Étape 3 sur 3">
                                <div class="step-dot">3</div>
                                <div class="step-label">Confirmer</div>
                            </div>
                        </div>

                        <form action="{{ route('public.events.register', $event) }}" method="POST" id="registerForm">
                            @csrf

                            <!-- Étape 1 : identité -->
                            <div class="wizard-pane active" data-pane="1">
                                <div class="mb-3"
                                     data-intro="Remplis ton nom ici, puis clique sur &quot;Suivant&quot; pour passer à l'étape 2. C'est tout, tu es prêt à essayer !"
                                     data-step="8"
                                     data-title="À toi de jouer">
                                    <label>Nom complet <span class="req">*</span></label>
                                    <input type="text" name="full_name" id="f_full_name"
                                           class="form-control @error('full_name') is-invalid @enderror"
                                           value="{{ old('full_name', auth()->user()->name) }}"
                                           placeholder="Ex: Ahmed Ben Ali">
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" id="f_email" class="form-control" value="{{ auth()->user()->email }}" disabled>
                                    <div class="form-text" style="font-size:.75rem;">
                                        <i class="bi bi-check-circle-fill text-success me-1"></i>Cette inscription sera liée à votre compte.
                                    </div>
                                </div>

                                <div class="wizard-nav">
                                    <button type="button" class="btn-wizard-next" onclick="wizardNext(1)">
                                        Suivant <i class="bi bi-arrow-right ms-1"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Étape 2 : détails -->
                            <div class="wizard-pane" data-pane="2">
                                <div class="mb-3">
                                    <label>Téléphone</label>
                                    <input type="text" name="phone" id="f_phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}"
                                           placeholder="Ex: +216 22 111 111">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label>Notes / Questions</label>
                                    <textarea name="notes" id="f_notes" class="form-control" rows="3"
                                              placeholder="Une question ou remarque ?">{{ old('notes') }}</textarea>
                                </div>

                                <div class="wizard-nav">
                                    <button type="button" class="btn-wizard-prev" onclick="wizardPrev(2)">
                                        <i class="bi bi-arrow-left"></i>
                                    </button>
                                    <button type="button" class="btn-wizard-next" onclick="wizardNext(2)">
                                        Suivant <i class="bi bi-arrow-right ms-1"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Étape 3 : confirmation -->
                            <div class="wizard-pane" data-pane="3">
                                <div class="recap-box" id="recapBox">
                                    <div class="recap-row"><span class="k">Nom complet</span><span class="v" id="recap_name">—</span></div>
                                    <div class="recap-row"><span class="k">Email</span><span class="v" id="recap_email">—</span></div>
                                    <div class="recap-row"><span class="k">Téléphone</span><span class="v" id="recap_phone">—</span></div>
                                    <div class="recap-row"><span class="k">Événement</span><span class="v">{{ $event->name }}</span></div>
                                </div>

                                <div class="wizard-nav">
                                    <button type="button" class="btn-wizard-prev" onclick="wizardPrev(3)">
                                        <i class="bi bi-arrow-left"></i>
                                    </button>
                                    <button type="submit" class="btn-wizard-next">
                                        <i class="bi bi-check-circle me-1"></i>Confirmer mon inscription
                                    </button>
                                </div>
                            </div>

                            <p class="text-muted text-center mt-3 mb-0" style="font-size:.75rem">
                                <i class="bi bi-shield-check me-1"></i>
                                Vos données sont utilisées uniquement pour la gestion de cet événement.
                            </p>
                        </form>
                        @endunless
                        @endguest
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function goToStep(step) {
    document.querySelectorAll('.wizard-pane').forEach(p => p.classList.toggle('active', p.dataset.pane == step));
    document.querySelectorAll('.step-item').forEach(item => {
        const n = parseInt(item.dataset.stepItem);
        item.classList.toggle('active', n === step);
        item.classList.toggle('done', n < step);
    });
    document.querySelectorAll('.step-line').forEach(line => {
        line.classList.toggle('done', parseInt(line.dataset.stepLine) < step);
    });
}

function wizardNext(fromStep) {
    if (fromStep === 1) {
        const name = document.getElementById('f_full_name');
        const email = document.getElementById('f_email');
        if (!name.value.trim() || !email.value.trim()) {
            alert('Merci de remplir votre nom complet et votre email avant de continuer.');
            return;
        }
    }
    if (fromStep === 2) {
        document.getElementById('recap_name').textContent = document.getElementById('f_full_name').value || '—';
        document.getElementById('recap_email').textContent = document.getElementById('f_email').value || '—';
        document.getElementById('recap_phone').textContent = document.getElementById('f_phone').value || 'Non renseigné';
    }
    goToStep(fromStep + 1);
}

function wizardPrev(fromStep) {
    goToStep(fromStep - 1);
}

@if ($errors->any())
    // S'il y a une erreur de validation après soumission (ex: email déjà inscrit,
    // événement complet), on revient directement à l'étape concernée.
    @if ($errors->has('phone') || $errors->has('notes'))
        goToStep(2);
    @else
        goToStep(1);
    @endif
@endif
</script>
@endsection