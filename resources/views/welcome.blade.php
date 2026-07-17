<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Manager – Plateforme de gestion d'événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; overflow-x: hidden; }

        /* NAVBAR */
        .navbar {
            background: rgba(255,255,255,0.97) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            padding: 15px 0;
        }
        .navbar-brand { font-size: 1.4rem; font-weight: 700; color: #1a237e !important; }
        .navbar-brand i { color: #1565c0; }
        .btn-nav-login {
            border: 2px solid #1a237e; color: #1a237e;
            border-radius: 25px; padding: 8px 25px;
            font-weight: 600; transition: all 0.3s;
            text-decoration: none;
        }
        .btn-nav-login:hover { background: #1a237e; color: white; }
        .btn-nav-register {
            background: linear-gradient(135deg, #1a237e, #1565c0);
            color: white; border-radius: 25px; padding: 8px 25px;
            font-weight: 600; border: none; transition: all 0.3s;
            text-decoration: none;
        }
        .btn-nav-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(21,101,192,0.4);
            color: white;
        }

        /* HERO */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg,
                rgba(26,35,126,0.93) 0%,
                rgba(13,71,161,0.88) 50%,
                rgba(21,101,192,0.85) 100%),
                url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1600&q=80')
                center/cover no-repeat;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }
        .hero::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            background: rgba(255,255,255,0.03);
            border-radius: 50%;
            top: -100px; right: -100px;
        }
        .hero::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            bottom: -50px; left: -50px;
        }
        .hero-content { position: relative; z-index: 2; }
        .hero-badge {
            background: rgba(255,255,255,0.15);
            color: white; padding: 8px 20px;
            border-radius: 25px; font-size: 0.85rem;
            font-weight: 600; display: inline-block;
            margin-bottom: 25px;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .hero h1 {
            font-size: 3.5rem; font-weight: 800;
            color: white; line-height: 1.2; margin-bottom: 20px;
        }
        .hero h1 span { color: #90caf9; }
        .hero p {
            font-size: 1.15rem; color: rgba(255,255,255,0.85);
            margin-bottom: 35px; line-height: 1.7;
        }
        .btn-hero-primary {
            background: white; color: #1a237e;
            border-radius: 30px; padding: 14px 35px;
            font-weight: 700; font-size: 1rem;
            border: none; transition: all 0.3s;
            text-decoration: none; display: inline-block;
        }
        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            color: #1a237e;
        }
        .btn-hero-secondary {
            background: transparent; color: white;
            border-radius: 30px; padding: 14px 35px;
            font-weight: 600; font-size: 1rem;
            border: 2px solid rgba(255,255,255,0.5);
            transition: all 0.3s; text-decoration: none;
            display: inline-block;
        }
        .btn-hero-secondary:hover {
            background: rgba(255,255,255,0.1);
            color: white; border-color: white;
        }

        /* HERO CARD */
        .hero-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.2);
            padding: 30px; color: white;
        }
        .hero-card .stat-number { font-size: 2rem; font-weight: 800; color: #90caf9; }
        .hero-card .stat-label { font-size: 0.85rem; color: rgba(255,255,255,0.75); margin-top: 5px; }
        .mini-event-card {
            background: rgba(255,255,255,0.15);
            border-radius: 12px; padding: 12px 15px;
            margin-bottom: 10px; display: flex;
            align-items: center; gap: 12px;
        }
        .mini-event-icon {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px; display: flex;
            align-items: center; justify-content: center;
            font-size: 1.1rem; flex-shrink: 0;
        }
        .badge-status { font-size: 0.7rem; padding: 3px 10px; border-radius: 15px; }
        .badge-active { background: #43a047; }
        .badge-done { background: rgba(255,255,255,0.2); }

        /* FEATURES */
        .features { padding: 100px 0; background: #f8f9ff; }
        .section-badge {
            background: #e3f2fd; color: #1565c0;
            padding: 6px 18px; border-radius: 20px;
            font-size: 0.8rem; font-weight: 700;
            display: inline-block; margin-bottom: 15px;
        }
        .feature-card {
            background: white; border-radius: 16px;
            padding: 25px 25px 30px; height: 100%;
            border: 1px solid #e8eaf6; transition: all 0.3s;
            overflow: hidden;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(26,35,126,0.1);
            border-color: #1565c0;
        }
        .feature-card img {
            width: 100%; height: 160px;
            object-fit: cover; border-radius: 10px;
            margin-bottom: 20px;
        }
        .feature-icon {
            width: 55px; height: 55px;
            border-radius: 14px; display: flex;
            align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 15px;
        }

        /* STATS */
        .stats {
            padding: 80px 0;
            background: linear-gradient(135deg,
                rgba(26,35,126,0.95) 0%,
                rgba(21,101,192,0.95) 100%),
                url('https://images.unsplash.com/photo-1511578314322-379afb476865?w=1600&q=80')
                center/cover no-repeat;
        }
        .stat-card { text-align: center; color: white; padding: 20px; }
        .stat-card .number { font-size: 3rem; font-weight: 800; color: #90caf9; }
        .stat-card .label { font-size: 1rem; color: rgba(255,255,255,0.8); margin-top: 5px; }

        /* HOW IT WORKS */
        .how { padding: 100px 0; background: white; }
        .step-card { text-align: center; padding: 30px 20px; }
        .step-number {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #1a237e, #1565c0);
            color: white; border-radius: 50%;
            display: flex; align-items: center;
            justify-content: center; font-size: 1.4rem;
            font-weight: 800; margin: 0 auto 20px;
        }
        .step-img {
            width: 100%; height: 200px;
            object-fit: cover; border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        /* TESTIMONIAL */
        .testimonial {
            padding: 100px 0;
            background: #f8f9ff;
        }
        .testimonial-card {
            background: white; border-radius: 16px;
            padding: 35px; border: 1px solid #e8eaf6;
            transition: all 0.3s; height: 100%;
        }
        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(26,35,126,0.1);
        }
        .avatar {
            width: 55px; height: 55px;
            border-radius: 50%; object-fit: cover;
            border: 3px solid #e3f2fd;
        }

        /* CTA */
        .cta {
            padding: 100px 0;
            background: linear-gradient(135deg,
                rgba(26,35,126,0.95),
                rgba(21,101,192,0.95)),
                url('https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=1600&q=80')
                center/cover no-repeat;
            text-align: center;
        }
        .cta h2 { font-size: 2.5rem; font-weight: 800; color: white; }
        .btn-cta {
            background: white; color: #1a237e;
            border-radius: 30px; padding: 16px 50px;
            font-size: 1.1rem; font-weight: 700;
            border: none; transition: all 0.3s;
            text-decoration: none; display: inline-block;
        }
        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            color: #1a237e;
        }

        /* FOOTER */
        footer {
            background: #0d1b4b;
            color: rgba(255,255,255,0.7);
            padding: 50px 0 30px;
        }
        footer .brand { color: white; font-weight: 700; font-size: 1.3rem; }
        footer a { color: rgba(255,255,255,0.6); text-decoration: none; transition: color 0.2s; }
        footer a:hover { color: white; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="bi bi-calendar-event-fill me-2"></i>Event Manager
        </a>
        <div class="ms-auto d-flex gap-3 align-items-center">
            <a href="{{ route('login') }}" class="btn-nav-login">Se connecter</a>
            <a href="{{ route('register') }}" class="btn-nav-register">Commencer</a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 hero-content">
                <div class="hero-badge">
                    <i class="bi bi-stars me-1"></i> Plateforme de gestion d'événements
                </div>
                <h1>Gérez vos <span>événements</span> comme un pro</h1>
                <p>Une solution complète pour créer des événements, inscrire des participants et suivre la présence depuis un tableau de bord intuitif.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('register') }}" class="btn-hero-primary">
                        <i class="bi bi-rocket-takeoff me-2"></i>Commencer gratuitement
                    </a>
                    <a href="{{ route('login') }}" class="btn-hero-secondary">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-card">
                    <div class="row mb-4">
                        <div class="col-4 text-center">
                            <div class="stat-number">3</div>
                            <div class="stat-label">Événements</div>
                        </div>
                        <div class="col-4 text-center border-start border-end"
                             style="border-color: rgba(255,255,255,0.2) !important;">
                            <div class="stat-number">12</div>
                            <div class="stat-label">Participants</div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="stat-number">87%</div>
                            <div class="stat-label">Présence</div>
                        </div>
                    </div>
                    <div class="mini-event-card">
                        <div class="mini-event-icon"><i class="bi bi-laptop"></i></div>
                        <div class="flex-grow-1">
                            <div class="fw-bold small">Conférence Tech 2026</div>
                            <div style="font-size:0.75rem; opacity:0.75">10 Juil • ESPRIT Tunis</div>
                        </div>
                        <span class="badge badge-status badge-active">Actif</span>
                    </div>
                    <div class="mini-event-card">
                        <div class="mini-event-icon"><i class="bi bi-code-slash"></i></div>
                        <div class="flex-grow-1">
                            <div class="fw-bold small">Workshop Laravel</div>
                            <div style="font-size:0.75rem; opacity:0.75">15 Juil • Centre formation</div>
                        </div>
                        <span class="badge badge-status badge-active">Actif</span>
                    </div>
                    <div class="mini-event-card">
                        <div class="mini-event-icon"><i class="bi bi-trophy"></i></div>
                        <div class="flex-grow-1">
                            <div class="fw-bold small">Hackathon ESPRIT</div>
                            <div style="font-size:0.75rem; opacity:0.75">20 Juin • Terminé</div>
                        </div>
                        <span class="badge badge-status badge-done">Terminé</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section class="features">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-badge">✨ Fonctionnalités</div>
            <h2 style="font-size:2.2rem; font-weight:800; color:#1a237e;">Tout ce dont vous avez besoin</h2>
            <p class="text-muted mt-2">Une plateforme simple, puissante et intuitive</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=400&q=80" alt="Événements">
                    <div class="feature-icon" style="background:#e3f2fd;">
                        <i class="bi bi-calendar-plus" style="color:#1565c0;"></i>
                    </div>
                    <h5 class="fw-bold">Gestion des événements</h5>
                    <p class="text-muted">Créez, modifiez et supprimez vos événements facilement. Gérez les statuts : actif, annulé ou terminé.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <img src="https://images.unsplash.com/photo-1528605248644-14dd04022da1?w=400&q=80" alt="Participants">
                    <div class="feature-icon" style="background:#e8f5e9;">
                        <i class="bi bi-people" style="color:#43a047;"></i>
                    </div>
                    <h5 class="fw-bold">Inscription participants</h5>
                    <p class="text-muted">Inscrivez des participants, recherchez par nom ou email et gérez les places disponibles automatiquement.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&q=80" alt="Présence">
                    <div class="feature-icon" style="background:#fff3e0;">
                        <i class="bi bi-check2-circle" style="color:#f57c00;"></i>
                    </div>
                    <h5 class="fw-bold">Suivi de présence</h5>
                    <p class="text-muted">Marquez chaque participant comme inscrit, présent ou absent. Mise à jour rapide en un clic.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&q=80" alt="Dashboard">
                    <div class="feature-icon" style="background:#f3e5f5;">
                        <i class="bi bi-bar-chart" style="color:#7b1fa2;"></i>
                    </div>
                    <h5 class="fw-bold">Dashboard statistiques</h5>
                    <p class="text-muted">Visualisez le nombre total d'événements, de participants et le taux de présence global.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <img src="https://images.unsplash.com/photo-1599658880436-c61792e70672?w=400&q=80" alt="Export">
                    <div class="feature-icon" style="background:#fce4ec;">
                        <i class="bi bi-file-earmark-csv" style="color:#c62828;"></i>
                    </div>
                    <h5 class="fw-bold">Export CSV</h5>
                    <p class="text-muted">Exportez la liste des participants de chaque événement en fichier CSV en un seul clic.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?w=400&q=80" alt="Sécurité">
                    <div class="feature-icon" style="background:#e0f7fa;">
                        <i class="bi bi-shield-lock" style="color:#00838f;"></i>
                    </div>
                    <h5 class="fw-bold">Accès sécurisé</h5>
                    <p class="text-muted">Authentification complète avec login, register et protection de toutes les pages.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS -->
<section class="stats">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="number">100%</div>
                    <div class="label">Prototype fonctionnel</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="number">6</div>
                    <div class="label">Semaines de développement</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="number">Laravel</div>
                    <div class="label">Framework Backend</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="number">ESPRIT</div>
                    <div class="label">Stage d'été 2026</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="how">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-badge">🚀 Comment ça marche</div>
            <h2 style="font-size:2.2rem; font-weight:800; color:#1a237e;">Simple en 3 étapes</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="step-card">
                    <img src="https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=400&q=80"
                         class="step-img" alt="Créer un compte">
                    <div class="step-number">1</div>
                    <h5 class="fw-bold">Créez un compte</h5>
                    <p class="text-muted">Inscrivez-vous en quelques secondes et accédez immédiatement au tableau de bord.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=400&q=80"
                         class="step-img" alt="Créer événement">
                    <div class="step-number">2</div>
                    <h5 class="fw-bold">Créez vos événements</h5>
                    <p class="text-muted">Ajoutez vos événements avec toutes les informations et définissez le nombre de places.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=400&q=80"
                         class="step-img" alt="Gérer participants">
                    <div class="step-number">3</div>
                    <h5 class="fw-bold">Gérez les participants</h5>
                    <p class="text-muted">Inscrivez les participants, suivez leur présence et exportez les données en CSV.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="testimonial">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-badge">💬 Témoignages</div>
            <h2 style="font-size:2.2rem; font-weight:800; color:#1a237e;">Ils nous font confiance</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="mb-3 text-warning">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="text-muted fst-italic mb-4">"Une plateforme intuitive qui nous a permis de gérer notre conférence tech avec plus de 200 participants sans aucun problème."</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80"
                             class="avatar" alt="">
                        <div>
                            <div class="fw-bold">Ahmed Ben Salah</div>
                            <div class="text-muted small">Directeur IT, TechCorp Tunis</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="mb-3 text-warning">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="text-muted fst-italic mb-4">"L'export CSV et le suivi de présence en temps réel sont des fonctionnalités indispensables pour notre équipe RH."</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&q=80"
                             class="avatar" alt="">
                        <div>
                            <div class="fw-bold">Sana Trabelsi</div>
                            <div class="text-muted small">Responsable RH, ESPRIT</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="mb-3 text-warning">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>
                    <p class="text-muted fst-italic mb-4">"Simple à utiliser, rapide à déployer. Notre hackathon de 50 équipes a été géré en quelques clics seulement."</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&q=80"
                             class="avatar" alt="">
                        <div>
                            <div class="fw-bold">Mohamed Karim</div>
                            <div class="text-muted small">Chef de projet, Startup Hub</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta">
    <div class="container">
        <h2>Prêt à commencer ?</h2>
        <p class="mt-3 mb-4 fs-5" style="color:rgba(255,255,255,0.85);">
            Créez votre compte gratuitement et gérez vos événements dès aujourd'hui.
        </p>
        <a href="{{ route('register') }}" class="btn-cta me-3">
            <i class="bi bi-rocket-takeoff me-2"></i>Démarrer maintenant
        </a>
        <a href="{{ route('login') }}" class="btn-hero-secondary d-inline-block">
            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="brand mb-3">
                    <i class="bi bi-calendar-event-fill me-2"></i>Event Manager
                </div>
                <p class="small">Plateforme professionnelle de gestion d'événements et de participants développée avec Laravel & Bootstrap 5.</p>
            </div>
            <div class="col-md-4">
                <h6 class="text-white fw-bold mb-3">Navigation</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('login') }}"><i class="bi bi-chevron-right me-1"></i>Se connecter</a></li>
                    <li class="mb-2"><a href="{{ route('register') }}"><i class="bi bi-chevron-right me-1"></i>Créer un compte</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="text-white fw-bold mb-3">Projet</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><i class="bi bi-mortarboard me-2"></i>Stage d'été 2026</li>
                    <li class="mb-2"><i class="bi bi-building me-2"></i>ESPRIT – Tunis</li>
                    <li class="mb-2"><i class="bi bi-person me-2"></i>Kmar Srarfi</li>
                    <li class="mb-2"><i class="bi bi-person-badge me-2"></i>Encadreur : M. A. Yaakoubi</li>
                </ul>
            </div>
        </div>
        <hr style="border-color: rgba(255,255,255,0.1);">
        <p class="text-center small mb-0">
            © 2026 Event Manager • Développé avec
            <i class="bi bi-heart-fill text-danger mx-1"></i>
            par Kmar Srarfi • ESPRIT
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bandeau d'invite au son (les navigateurs bloquent la voix automatique tant qu'on n'a pas cliqué) -->
<div id="voice-prompt"
    style="position:fixed; top:90px; left:50%; transform:translateX(-50%) translateY(-20px);
           z-index:9999; background:#1a237e; color:white; padding:12px 22px;
           border-radius:30px; box-shadow:0 8px 24px rgba(26,35,126,0.35);
           font-size:0.9rem; font-weight:600; cursor:pointer; display:flex;
           align-items:center; gap:10px; opacity:0; transition:all 0.4s ease;">
    <i class="bi bi-volume-up-fill"></i>
    <span>Activer le message de bienvenue</span>
</div>

<!-- Bandeau de diagnostic (à retirer une fois que ça marche) -->
<div id="voice-debug"
    style="position:fixed; top:150px; left:50%; transform:translateX(-50%);
           z-index:9999; background:#111827; color:#a7f3d0; padding:10px 18px;
           border-radius:10px; font-size:0.78rem; font-family:monospace;
           max-width:90%; text-align:center; display:none;">
</div>

<!-- Bouton flottant pour rejouer le message vocal -->
<button id="voice-replay-btn" title="Rejouer le message vocal"
    style="position:fixed; bottom:24px; right:24px; z-index:9999; width:52px; height:52px;
           border-radius:50%; border:none; background:linear-gradient(135deg,#1a237e,#1565c0);
           color:white; font-size:1.3rem; box-shadow:0 6px 20px rgba(26,35,126,0.4);
           display:flex; align-items:center; justify-content:center; cursor:pointer;
           transition:transform 0.2s;">
    <i class="bi bi-volume-up-fill"></i>
</button>

<script>
(function () {
    const WELCOME_TEXT = "Bienvenue sur Event Manager, la plateforme de gestion de vos événements.";
    const replayBtn = document.getElementById('voice-replay-btn');
    const prompt = document.getElementById('voice-prompt');
    const debugBox = document.getElementById('voice-debug');
    let played = false;

    function debug(msg) {
        console.log('[voice]', msg);
        debugBox.style.display = 'block';
        debugBox.textContent = msg;
    }

    if (!('speechSynthesis' in window)) {
        debug('❌ Ce navigateur ne supporte pas speechSynthesis.');
        prompt.style.display = 'none';
        return;
    }

    function pickFrenchVoice() {
        const voices = window.speechSynthesis.getVoices();
        return voices.find(v => v.lang && v.lang.toLowerCase().startsWith('fr'));
    }

    function speakWelcome(source) {
        window.speechSynthesis.cancel();
        const utterance = new SpeechSynthesisUtterance(WELCOME_TEXT);
        utterance.lang = 'fr-FR';
        utterance.volume = 1;

        const voices = window.speechSynthesis.getVoices();
        const frVoice = pickFrenchVoice();
        if (frVoice) utterance.voice = frVoice;

        debug(`(${source}) ${voices.length} voix trouvée(s)` + (frVoice ? `, voix FR: ${frVoice.name}` : ', AUCUNE voix FR — voix par défaut utilisée'));

        utterance.onstart = () => debug(`▶️ Lecture démarrée (${source})`);
        utterance.onend   = () => debug(`✅ Lecture terminée (${source})`);
        utterance.onerror = (e) => debug(`❌ Erreur : ${e.error} (${source})`);

        window.speechSynthesis.speak(utterance);
    }

    function hidePrompt() {
        prompt.style.opacity = '0';
        prompt.style.transform = 'translateX(-50%) translateY(-20px)';
        setTimeout(() => prompt.style.display = 'none', 400);
    }

    function tryAutoplay() {
        const voices = window.speechSynthesis.getVoices();
        if (voices.length === 0) {
            debug('⚠️ Aucune voix chargée pour le moment (normal au tout premier chargement).');
        }

        window.speechSynthesis.cancel();
        const utterance = new SpeechSynthesisUtterance(WELCOME_TEXT);
        utterance.lang = 'fr-FR';
        const frVoice = pickFrenchVoice();
        if (frVoice) utterance.voice = frVoice;

        utterance.onstart = function () {
            played = true;
            debug(`▶️ Lecture auto démarrée, voix: ${frVoice ? frVoice.name : 'par défaut'}`);
            hidePrompt();
        };
        utterance.onerror = function (e) {
            debug(`⚠️ Autoplay bloqué (${e.error}) — clique sur le bandeau bleu.`);
        };
        window.speechSynthesis.speak(utterance);

        setTimeout(function () {
            if (!played) {
                prompt.style.display = 'flex';
                requestAnimationFrame(() => {
                    prompt.style.opacity = '1';
                    prompt.style.transform = 'translateX(-50%) translateY(0)';
                });
            }
        }, 500);
    }

    window.addEventListener('load', function () {
        if (window.speechSynthesis.getVoices().length === 0) {
            window.speechSynthesis.addEventListener('voiceschanged', tryAutoplay, { once: true });
            setTimeout(tryAutoplay, 300);
        } else {
            tryAutoplay();
        }
    });

    prompt.addEventListener('click', function () {
        played = true;
        speakWelcome('clic bandeau');
        hidePrompt();
    });

    replayBtn.addEventListener('click', function () {
        speakWelcome('clic bouton rejouer');
    });
})();
</script>
</body>
</html>