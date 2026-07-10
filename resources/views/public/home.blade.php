<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Manager – Découvrez nos événements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/intro.js/minified/introjs.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f0f2f8; overflow-x: hidden; }

        /* ===== NAVBAR ===== */
        .navbar {
            background: rgba(255,255,255,0.98);
            backdrop-filter: blur(20px);
            box-shadow: 0 1px 30px rgba(26,35,126,0.08);
            padding: 0.9rem 0;
            position: sticky; top: 0; z-index: 1000;
            width: 100%;
        }
        .navbar .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: nowrap;
        }
        .navbar-brand {
            font-size: 1.35rem; font-weight: 800;
            color: #1a237e !important; display: flex; align-items: center; gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
            white-space: nowrap;
        }
        .brand-icon {
            width: 38px; height: 38px; flex-shrink: 0;
            background: linear-gradient(135deg, #1a237e, #1565c0);
            border-radius: 10px; display: flex; align-items: center;
            justify-content: center; color: white; font-size: 1rem;
        }
        .nav-links { display: flex; align-items: center; gap: 24px; flex-shrink: 0; }
        .nav-links a { color: #555; font-weight: 500; text-decoration: none; font-size: 0.9rem; transition: color 0.2s; white-space: nowrap; }
        .nav-links a:hover { color: #1a237e; }
        .btn-login {
            border: 2px solid #1a237e; color: #1a237e; border-radius: 30px;
            padding: 9px 22px; font-weight: 700; font-size: 0.88rem;
            transition: all 0.3s; text-decoration: none; white-space: nowrap;
        }
        .btn-login:hover { background: #1a237e; color: white; }
        .btn-start {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white; border-radius: 30px; padding: 9px 22px;
            font-weight: 700; font-size: 0.88rem;
            text-decoration: none; transition: all 0.3s; white-space: nowrap;
            box-shadow: 0 4px 15px rgba(37,99,235,0.35);
        }
        .btn-start:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(37,99,235,0.5); color: white; background: linear-gradient(135deg, #1d4ed8, #2563eb); }

        @media (max-width: 860px) {
            .navbar .container { flex-wrap: wrap; row-gap: 12px; }
            .nav-links { width: 100%; justify-content: center; flex-wrap: wrap; }
        }

        /* ===== EFFET 3D : cartes inclinables + profondeur ===== */
        .tilt-3d {
            transform-style: preserve-3d;
            transition: transform 0.15s ease-out, box-shadow 0.3s ease;
            will-change: transform;
        }
        .tilt-3d .tilt-inner { transform: translateZ(30px); transform-style: preserve-3d; }

        /* Orbes flottantes en arrière-plan du hero (profondeur) */
        .hero-orb {
            position: absolute; border-radius: 50%;
            filter: blur(50px); opacity: 0.35; pointer-events: none;
            animation: orbFloat 9s ease-in-out infinite;
        }
        .hero-orb.o1 { width: 320px; height: 320px; background: radial-gradient(circle, #4fc3f7, transparent 70%); top: -60px; left: -60px; animation-delay: 0s; }
        .hero-orb.o2 { width: 260px; height: 260px; background: radial-gradient(circle, #7c4dff, transparent 70%); bottom: -40px; right: 10%; animation-delay: 3s; }
        .hero-orb.o3 { width: 180px; height: 180px; background: radial-gradient(circle, #90caf9, transparent 70%); top: 40%; right: -40px; animation-delay: 6s; }
        @keyframes orbFloat {
            0%, 100% { transform: translate(0,0) scale(1); }
            50% { transform: translate(15px,-25px) scale(1.08); }
        }

        /* Ombres 3D en couches pour un effet de profondeur plus riche */
        .ecard.tilt-3d:hover, .floating-card.tilt-3d:hover, .step-card.tilt-3d:hover, .tcard.tilt-3d:hover {
            box-shadow:
                0 2px 4px rgba(13,27,75,0.06),
                0 8px 16px rgba(13,27,75,0.08),
                0 24px 48px rgba(13,27,75,0.16);
        }


        .hero {
            min-height: 100vh;
            position: relative; overflow: hidden;
            display: flex; align-items: center;
        }
        .hero-bg {
            position: absolute; inset: 0;
            background: linear-gradient(135deg, #0d1b4b 0%, #1a237e 40%, #1565c0 75%, #1976d2 100%);
        }
        .hero-bg-img {
            position: absolute; inset: 0;
            background: url('https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=1920&q=85') center/cover no-repeat;
            opacity: 0.18; mix-blend-mode: luminosity;
        }
        .hero-pattern {
            position: absolute; inset: 0;
            background-image: radial-gradient(circle at 20% 80%, rgba(144,202,249,0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.05) 0%, transparent 50%);
        }
        .hero-content { position: relative; z-index: 2; padding: 100px 0 80px; width: 100%; }
        .hero-tag {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.1); color: #90caf9;
            border: 1px solid rgba(144,202,249,0.3); border-radius: 30px;
            padding: 8px 20px; font-size: 0.82rem; font-weight: 600;
            margin-bottom: 28px; backdrop-filter: blur(10px);
        }
        .hero-tag .dot { width: 7px; height: 7px; background: #4fc3f7; border-radius: 50%; animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.5;transform:scale(1.3)} }
        .hero h1 {
            font-size: 4.2rem; font-weight: 900; color: white;
            line-height: 1.08; letter-spacing: -1px; margin-bottom: 24px;
        }
        .hero h1 em { font-style: normal; color: #90caf9; }
        .hero-desc { font-size: 1.1rem; color: rgba(255,255,255,0.75); line-height: 1.75; max-width: 520px; margin-bottom: 45px; }

        /* Search Bar */
        .search-bar {
            background: white; border-radius: 18px;
            padding: 8px; display: flex; align-items: center;
            max-width: 580px; margin-bottom: 50px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.25);
            gap: 8px;
        }
        .search-bar-inner { flex: 1; padding: 8px 15px; }
        .search-bar-inner label { font-size: 0.7rem; font-weight: 700; color: #9e9e9e; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 4px; }
        .search-bar-inner input { border: none; outline: none; font-size: 0.95rem; color: #1a237e; font-weight: 600; width: 100%; }
        .search-bar-divider { width: 1px; height: 40px; background: #e0e0e0; flex-shrink: 0; }
        .search-bar-btn {
            background: linear-gradient(135deg, #1a237e, #1565c0);
            color: white; border: none; border-radius: 12px;
            padding: 14px 28px; font-weight: 700; font-size: 0.9rem;
            display: flex; align-items: center; gap: 8px;
            transition: all 0.3s; white-space: nowrap; flex-shrink: 0;
        }
        .search-bar-btn:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(21,101,192,0.4); }

        /* Hero Stats */
        .hero-stats-row {
            display: flex; gap: 0;
            background: rgba(255,255,255,0.08); border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(10px); overflow: hidden;
            max-width: 480px;
        }
        .hero-stat { padding: 18px 28px; flex: 1; border-right: 1px solid rgba(255,255,255,0.1); }
        .hero-stat:last-child { border-right: none; }
        .hero-stat .val { font-size: 1.8rem; font-weight: 900; color: #90caf9; line-height: 1; }
        .hero-stat .lbl { font-size: 0.72rem; color: rgba(255,255,255,0.55); margin-top: 5px; }

        /* Hero Right Side */
        .hero-right { position: relative; }
        .floating-card {
            background: rgba(255,255,255,0.1); backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2); border-radius: 20px;
            padding: 25px; color: white; margin-bottom: 15px;
            transition: transform 0.3s;
        }
        .floating-card:hover { transform: translateY(-5px); }
        .fc-header { display: flex; align-items: center; gap: 12px; margin-bottom: 15px; }
        .fc-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
        .fc-title { font-weight: 700; font-size: 0.95rem; }
        .fc-sub { font-size: 0.75rem; opacity: 0.65; }
        .fc-badge { font-size: 0.7rem; padding: 4px 12px; border-radius: 15px; font-weight: 700; }
        .mini-progress { background: rgba(255,255,255,0.15); border-radius: 10px; height: 5px; margin-top: 12px; }
        .mini-progress-fill { background: linear-gradient(90deg, #4fc3f7, #90caf9); border-radius: 10px; height: 5px; }

        /* Scroll indicator */
        .scroll-down {
            position: absolute; bottom: 35px; left: 50%;
            transform: translateX(-50%); color: rgba(255,255,255,0.4);
            font-size: 1.3rem; animation: scrollBounce 2s infinite;
            display: flex; flex-direction: column; align-items: center; gap: 5px;
        }
        .scroll-down span { font-size: 0.7rem; letter-spacing: 2px; text-transform: uppercase; }
        @keyframes scrollBounce { 0%,100%{transform:translateX(-50%) translateY(0)} 50%{transform:translateX(-50%) translateY(8px)} }

        /* ===== TRUST BAR ===== */
        .trust-bar { background: white; padding: 25px 0; border-bottom: 1px solid #e8eaf6; }
        .trust-item { display: flex; align-items: center; gap: 10px; color: #555; font-size: 0.88rem; font-weight: 600; }
        .trust-item i { color: #1565c0; font-size: 1.1rem; }

        /* ===== CATEGORIES ===== */
        .section { padding: 90px 0; }
        .section-label { font-size: 0.78rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; color: #1565c0; margin-bottom: 12px; }
        .section-title { font-size: 2.2rem; font-weight: 900; color: #0d1b4b; letter-spacing: -0.5px; margin-bottom: 10px; }
        .section-sub { color: #757575; font-size: 1rem; }
        .cat-card {
            border-radius: 20px; padding: 35px 25px; text-align: center;
            transition: all 0.3s; text-decoration: none; display: block;
            border: 2px solid transparent; position: relative; overflow: hidden;
        }
        .cat-card::before {
            content: ''; position: absolute; inset: 0;
            opacity: 0; transition: opacity 0.3s;
            background: linear-gradient(135deg, rgba(255,255,255,0.5), transparent);
        }
        .cat-card:hover { transform: translateY(-8px); border-color: currentColor; }
        .cat-card:hover::before { opacity: 1; }
        .cat-icon { width: 75px; height: 75px; border-radius: 22px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 18px; transition: transform 0.3s; }
        .cat-card:hover .cat-icon { transform: scale(1.1) rotate(-5deg); }
        .cat-card h6 { font-weight: 800; font-size: 1rem; margin-bottom: 6px; }
        .cat-card p { font-size: 0.8rem; opacity: 0.65; margin: 0; line-height: 1.4; }
        .c1 { background: #eff6ff; color: #1e40af; } .c1 .cat-icon { background: #dbeafe; }
        .c2 { background: #f0fdf4; color: #166534; } .c2 .cat-icon { background: #dcfce7; }
        .c3 { background: #fdf4ff; color: #7e22ce; } .c3 .cat-icon { background: #f3e8ff; }
        .c4 { background: #fff7ed; color: #9a3412; } .c4 .cat-icon { background: #fed7aa; }

        /* ===== FEATURED ===== */
        .featured-section { background: #0d1b4b; padding: 90px 0; }
        .featured-inner {
            border-radius: 30px; overflow: hidden;
            position: relative; min-height: 420px;
            display: flex; align-items: center;
        }
        .featured-bg {
            position: absolute; inset: 0;
            background: url('https://images.unsplash.com/photo-1511578314322-379afb476865?w=1400&q=85') center/cover no-repeat;
            filter: brightness(0.25);
        }
        .featured-content { position: relative; z-index: 2; padding: 60px; color: white; }
        .featured-tag { background: #fbbf24; color: #78350f; border-radius: 20px; padding: 5px 16px; font-size: 0.75rem; font-weight: 800; display: inline-block; margin-bottom: 22px; }
        .featured-content h2 { font-size: 2.5rem; font-weight: 900; margin-bottom: 15px; letter-spacing: -0.5px; }
        .featured-content p { color: rgba(255,255,255,0.8); font-size: 1rem; max-width: 480px; line-height: 1.7; margin-bottom: 30px; }
        .featured-meta { display: flex; gap: 25px; margin-bottom: 35px; flex-wrap: wrap; }
        .featured-meta span { display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.75); font-size: 0.88rem; }
        .featured-meta i { color: #90caf9; }
        .btn-join {
            background: white; color: #1a237e; border-radius: 30px;
            padding: 14px 35px; font-weight: 800; font-size: 0.95rem;
            text-decoration: none; display: inline-flex; align-items: center; gap: 10px;
            transition: all 0.3s;
        }
        .btn-join:hover { background: #90caf9; color: #0d1b4b; transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,0,0,0.3); }

        /* ===== EVENTS ===== */
        .events-section { background: #f0f2f8; padding: 90px 0; }
        .filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; }
        .ftab {
            border: 2px solid #e0e0e0; background: white; color: #666;
            border-radius: 30px; padding: 9px 22px; font-size: 0.84rem;
            font-weight: 700; cursor: pointer; transition: all 0.2s; text-decoration: none;
        }
        .ftab:hover, .ftab.active { border-color: #1a237e; background: #1a237e; color: white; }
        .ecard {
            background: white; border-radius: 22px; overflow: hidden;
            border: 1px solid #e8eaf6; transition: all 0.35s;
            height: 100%; display: flex; flex-direction: column;
        }
        .ecard:hover { transform: translateY(-10px); box-shadow: 0 30px 70px rgba(26,35,126,0.14); border-color: #90caf9; }
        .ecard-img { width: 100%; height: 210px; object-fit: cover; display: block; transition: transform 0.4s; }
        .ecard:hover .ecard-img { transform: scale(1.04); }
        .ecard-img-wrap { overflow: hidden; position: relative; }
        .sbadge {
            position: absolute; top: 14px; right: 14px;
            border-radius: 20px; padding: 5px 14px;
            font-size: 0.72rem; font-weight: 800;
            backdrop-filter: blur(10px);
        }
        .s-up { background: rgba(219,234,254,0.95); color: #1e40af; }
        .s-on { background: rgba(220,252,231,0.95); color: #166534; }
        .s-co { background: rgba(243,232,255,0.95); color: #7e22ce; }
        .s-ca { background: rgba(254,226,226,0.95); color: #991b1b; }
        .ecard-body { padding: 24px; flex: 1; display: flex; flex-direction: column; }
        .ecard-date { background: #eff6ff; color: #1e40af; border-radius: 8px; padding: 5px 12px; font-size: 0.76rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 13px; }
        .ecard h5 { font-size: 1.05rem; font-weight: 800; color: #0d1b4b; margin-bottom: 8px; line-height: 1.3; }
        .ecard p { font-size: 0.84rem; color: #757575; line-height: 1.65; margin-bottom: 15px; flex: 1; }
        .ecard-meta { display: flex; flex-wrap: wrap; gap: 12px; font-size: 0.78rem; color: #9e9e9e; margin-bottom: 15px; }
        .ecard-meta i { color: #1565c0; }
        .prog-wrap { background: #e8eaf6; border-radius: 10px; height: 6px; margin-bottom: 7px; overflow: hidden; }
        .prog-fill { background: linear-gradient(90deg, #1a237e, #1565c0); border-radius: 10px; height: 6px; transition: width 0.6s ease; }
        .prog-text { font-size: 0.75rem; color: #9e9e9e; margin-bottom: 16px; }
        .btn-reg {
            background: linear-gradient(135deg, #1a237e, #1565c0); color: white;
            border: none; border-radius: 25px; padding: 12px 25px;
            font-weight: 700; font-size: 0.88rem; width: 100%;
            transition: all 0.3s; text-decoration: none; display: block; text-align: center;
        }
        .btn-reg:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(21,101,192,0.4); color: white; }
        .btn-reg-full { background: #f5f5f5; color: #bdbdbd; border: none; border-radius: 25px; padding: 12px 25px; font-weight: 700; font-size: 0.88rem; width: 100%; display: block; text-align: center; cursor: not-allowed; }
        .btn-det { background: transparent; color: #1a237e; border: 2px solid #1a237e; border-radius: 25px; padding: 11px 25px; font-weight: 700; font-size: 0.88rem; width: 100%; display: block; text-align: center; text-decoration: none; transition: all 0.3s; margin-top: 8px; }
        .btn-det:hover { background: #1a237e; color: white; }

        /* ===== HOW ===== */
        .how-section { background: white; padding: 90px 0; }
        .step-card { border-radius: 22px; overflow: hidden; border: 1px solid #e8eaf6; transition: all 0.3s; background: white; }
        .step-card:hover { transform: translateY(-8px); box-shadow: 0 20px 50px rgba(26,35,126,0.1); }
        .step-img { width: 100%; height: 180px; object-fit: cover; }
        .step-body { padding: 28px; }
        .step-num { width: 50px; height: 50px; background: linear-gradient(135deg, #1a237e, #1565c0); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; font-weight: 900; margin-bottom: 15px; }
        .step-body h5 { font-weight: 800; color: #0d1b4b; margin-bottom: 8px; }
        .step-body p { color: #757575; font-size: 0.88rem; line-height: 1.65; margin: 0; }

        /* ===== TESTIMONIALS ===== */
        .testi-section { background: #0d1b4b; padding: 90px 0; }
        .tcard { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 22px; padding: 35px; backdrop-filter: blur(10px); transition: all 0.3s; height: 100%; }
        .tcard:hover { background: rgba(255,255,255,0.1); transform: translateY(-5px); }
        .tcard .stars { color: #fbbf24; margin-bottom: 18px; font-size: 0.9rem; }
        .tcard p { color: rgba(255,255,255,0.8); font-size: 0.92rem; line-height: 1.75; margin-bottom: 25px; font-style: italic; }
        .tcard .avatar { width: 52px; height: 52px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(144,202,249,0.4); }
        .tcard .name { font-weight: 700; color: white; font-size: 0.92rem; }
        .tcard .role { font-size: 0.78rem; color: rgba(255,255,255,0.5); }

        /* ===== NEWSLETTER ===== */
        .nl-section {
            background: linear-gradient(135deg, #1565c0, #1a237e);
            padding: 90px 0; text-align: center;
            position: relative; overflow: hidden;
        }
        .nl-section::before {
            content: ''; position: absolute; inset: 0;
            background: url('https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=1600&q=70') center/cover;
            opacity: 0.07;
        }
        .nl-section .container { position: relative; z-index: 2; }
        .nl-section h2 { font-size: 2.2rem; font-weight: 900; color: white; margin-bottom: 14px; }
        .nl-section p { color: rgba(255,255,255,0.8); font-size: 1rem; margin-bottom: 40px; }
        .nl-form { display: flex; gap: 10px; max-width: 480px; margin: 0 auto 20px; }
        .nl-form input { flex: 1; border: none; border-radius: 30px; padding: 15px 25px; font-size: 0.95rem; outline: none; font-family: 'Inter', sans-serif; }
        .nl-form button { background: white; color: #1a237e; border: none; border-radius: 30px; padding: 15px 28px; font-weight: 800; font-size: 0.88rem; transition: all 0.3s; font-family: 'Inter', sans-serif; white-space: nowrap; }
        .nl-form button:hover { background: #90caf9; transform: translateY(-2px); }
        .nl-note { color: rgba(255,255,255,0.45); font-size: 0.78rem; }

        /* ===== FOOTER ===== */
        footer { background: #060d2a; color: rgba(255,255,255,0.6); padding: 70px 0 30px; }
        footer .brand { color: white; font-weight: 800; font-size: 1.25rem; display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        footer .brand-icon { width: 36px; height: 36px; background: linear-gradient(135deg, #1a237e, #1565c0); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.95rem; }
        footer p { font-size: 0.85rem; line-height: 1.7; max-width: 280px; }
        footer h6 { color: white; font-weight: 700; margin-bottom: 18px; font-size: 0.9rem; letter-spacing: 0.5px; }
        footer ul { list-style: none; padding: 0; margin: 0; }
        footer ul li { margin-bottom: 10px; }
        footer ul li a { color: rgba(255,255,255,0.55); text-decoration: none; font-size: 0.87rem; transition: color 0.2s; display: flex; align-items: center; gap: 6px; }
        footer ul li a:hover { color: #90caf9; }
        footer ul li a i { font-size: 0.7rem; }
        .social-links { display: flex; gap: 10px; margin-top: 20px; }
        .social-links a { width: 38px; height: 38px; background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.6); font-size: 1rem; transition: all 0.2s; text-decoration: none; }
        .social-links a:hover { background: #1565c0; color: white; border-color: #1565c0; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.06); margin-top: 50px; padding-top: 25px; text-align: center; font-size: 0.82rem; }

        /* ===== MISC ===== */
        .empty-state { text-align: center; padding: 80px 20px; }
        .empty-state i { font-size: 5rem; color: #ddd; display: block; margin-bottom: 20px; }
        .fade-in { opacity: 0; animation: fi 0.5s ease forwards; }
        @keyframes fi { to { opacity: 1; transform: translateY(0); } }
        .fade-in { transform: translateY(20px); }

        /* ===== BOUTON D'AIDE FLOTTANT + TOUR GUIDÉ ===== */
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
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}"
           data-intro="👋 Bienvenue sur <strong>Event Manager</strong> ! Je vais te montrer en quelques étapes comment trouver un événement et t'y inscrire."
           data-step="1"
           data-title="Bienvenue !">
            <div class="brand-icon"><i class="bi bi-calendar-event-fill"></i></div>
            Event Manager
        </a>
        <div class="nav-links">
            <a href="#events">Événements</a>
            <a href="#how">Comment ça marche</a>
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('participant.dashboard') }}" class="btn-login">
                    <i class="bi bi-speedometer2 me-1"></i>{{ auth()->user()->isAdmin() ? 'Dashboard' : 'Mon espace' }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                    @csrf
                    <button type="submit" class="btn-login" style="background:transparent;border:1px solid rgba(255,255,255,0.4);cursor:pointer;">
                        <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-login"
                   data-intro="Tu as déjà un compte ? Clique ici pour te connecter et retrouver tes inscriptions."
                   data-step="6"
                   data-title="Se connecter">Se connecter</a>
                <a href="{{ route('register') }}" class="btn-start">Commencer <i class="bi bi-arrow-right"></i></a>
            @endauth
        </div>
    </div>
</nav>

<!-- ===== HERO ===== -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-bg-img"></div>
    <div class="hero-pattern"></div>
    <div class="hero-orb o1"></div>
    <div class="hero-orb o2"></div>
    <div class="hero-orb o3"></div>

    <div class="container hero-content">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-tag">
                    <span class="dot"></span>
                    Plateforme événementielle — ESPRIT 2026
                </div>
                <h1>Vivez des<br><em>expériences</em><br>inoubliables</h1>
                <p class="hero-desc">Découvrez, inscrivez-vous et participez aux meilleurs événements tech, business et culturels de Tunisie. Simple, rapide, gratuit.</p>

                <div class="search-bar"
                     data-intro="Utilise la barre de recherche pour trouver rapidement un événement par son nom ou son lieu."
                     data-step="2"
                     data-title="Rechercher un événement">
                    <div class="search-bar-inner">
                        <label>Rechercher</label>
                        <input type="text" id="searchInput" placeholder="Conférence, workshop, hackathon...">
                    </div>
                    <div class="search-bar-divider"></div>
                    <button class="search-bar-btn" onclick="filterEvents()">
                        <i class="bi bi-search"></i> Rechercher
                    </button>
                </div>

                <div class="hero-stats-row">
                    <div class="hero-stat">
                        <div class="val">{{ $events->total() }}+</div>
                        <div class="lbl">Événements</div>
                    </div>
                    <div class="hero-stat">
                        <div class="val">100%</div>
                        <div class="lbl">Gratuit</div>
                    </div>
                    <div class="hero-stat">
                        <div class="val">24/7</div>
                        <div class="lbl">Disponible</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="floating-card tilt-3d">
                    <div class="fc-header">
                        <div class="fc-icon" style="background:rgba(144,202,249,0.2);">
                            <i class="bi bi-laptop" style="color:#90caf9;"></i>
                        </div>
                        <div>
                            <div class="fc-title">Conférence Tech 2026</div>
                            <div class="fc-sub">10 Juil • ESPRIT Tunis</div>
                        </div>
                        <span class="fc-badge ms-auto" style="background:#dcfce7;color:#166534;">À venir</span>
                    </div>
                    <div class="d-flex justify-content-between" style="font-size:0.78rem; color:rgba(255,255,255,0.65);">
                        <span><i class="bi bi-people me-1"></i>45 / 100 inscrits</span>
                        <span>45%</span>
                    </div>
                    <div class="mini-progress"><div class="mini-progress-fill" style="width:45%"></div></div>
                </div>

                <div class="floating-card tilt-3d">
                    <div class="fc-header">
                        <div class="fc-icon" style="background:rgba(251,191,36,0.2);">
                            <i class="bi bi-trophy" style="color:#fbbf24;"></i>
                        </div>
                        <div>
                            <div class="fc-title">Hackathon ESPRIT</div>
                            <div class="fc-sub">20 Juin • Salle informatique</div>
                        </div>
                        <span class="fc-badge ms-auto" style="background:#fef3c7;color:#92400e;">En cours</span>
                    </div>
                    <div class="d-flex justify-content-between" style="font-size:0.78rem; color:rgba(255,255,255,0.65);">
                        <span><i class="bi bi-people me-1"></i>480 / 500 inscrits</span>
                        <span>96%</span>
                    </div>
                    <div class="mini-progress"><div class="mini-progress-fill" style="width:96%; background:linear-gradient(90deg,#fbbf24,#f59e0b);"></div></div>
                </div>

                <div class="floating-card tilt-3d">
                    <div class="fc-header">
                        <div class="fc-icon" style="background:rgba(167,139,250,0.2);">
                            <i class="bi bi-code-slash" style="color:#a78bfa;"></i>
                        </div>
                        <div>
                            <div class="fc-title">Workshop Laravel</div>
                            <div class="fc-sub">15 Juil • Centre formation</div>
                        </div>
                        <span class="fc-badge ms-auto" style="background:#dbeafe;color:#1e40af;">À venir</span>
                    </div>
                    <div class="d-flex justify-content-between" style="font-size:0.78rem; color:rgba(255,255,255,0.65);">
                        <span><i class="bi bi-people me-1"></i>12 / 30 inscrits</span>
                        <span>40%</span>
                    </div>
                    <div class="mini-progress"><div class="mini-progress-fill" style="width:40%; background:linear-gradient(90deg,#a78bfa,#818cf8);"></div></div>
                </div>
            </div>
        </div>
    </div>

    <div class="scroll-down">
        <i class="bi bi-chevron-down"></i>
        <span>Scroll</span>
    </div>
</section>

<!-- ===== TRUST BAR ===== -->
<div class="trust-bar">
    <div class="container">
        <div class="row g-3 justify-content-center text-center">
            <div class="col-6 col-md-3">
                <div class="trust-item justify-content-center">
                    <i class="bi bi-shield-check"></i>
                    <span>Inscription sécurisée</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-item justify-content-center">
                    <i class="bi bi-lightning-charge"></i>
                    <span>Confirmation instantanée</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-item justify-content-center">
                    <i class="bi bi-gift"></i>
                    <span>100% Gratuit</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-item justify-content-center">
                    <i class="bi bi-phone"></i>
                    <span>Accessible partout</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== CATEGORIES ===== -->
<section class="section" style="background:white;">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label">Catégories</div>
            <h2 class="section-title">Explorez par thème</h2>
            <p class="section-sub">Trouvez l'événement qui vous correspond parmi nos catégories</p>
        </div>
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <a href="#events" class="cat-card tilt-3d c1">
                    <div class="cat-icon"><i class="bi bi-laptop"></i></div>
                    <h6>Technologie</h6>
                    <p>Conférences, workshops & hackathons</p>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="#events" class="cat-card tilt-3d c2">
                    <div class="cat-icon"><i class="bi bi-briefcase"></i></div>
                    <h6>Business</h6>
                    <p>Networking, séminaires & formations</p>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="#events" class="cat-card tilt-3d c3">
                    <div class="cat-icon"><i class="bi bi-palette"></i></div>
                    <h6>Culture & Art</h6>
                    <p>Expositions, concerts & festivals</p>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="#events" class="cat-card tilt-3d c4">
                    <div class="cat-icon"><i class="bi bi-trophy"></i></div>
                    <h6>Sport</h6>
                    <p>Compétitions, marathons & tournois</p>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===== FEATURED ===== -->
<section class="featured-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label" style="color:#fbbf24;">À la une</div>
            <h2 class="section-title" style="color:white;">Événement vedette</h2>
        </div>
        <div class="featured-inner">
            <div class="featured-bg"></div>
            <div class="featured-content">
                <div class="featured-tag">⭐ Événement vedette</div>
                <h2>Conférence Tech 2026<br>— ESPRIT Tunis</h2>
                <p>Rejoignez les plus grands experts du numérique pour deux jours d'innovation, de networking et de partage de connaissances.</p>
                <div class="featured-meta">
                    <span><i class="bi bi-calendar3"></i> 10 Juillet 2026</span>
                    <span><i class="bi bi-geo-alt"></i> ESPRIT, Tunis</span>
                    <span><i class="bi bi-people"></i> 100 places</span>
                    <span><i class="bi bi-clock"></i> 9h00 – 18h00</span>
                </div>
                <a href="{{ route('home') }}" class="btn-join">
                    <i class="bi bi-person-plus"></i> S'inscrire maintenant
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ===== EVENTS ===== -->
<section class="events-section" id="events"
         data-intro="Voici la liste de tous les événements disponibles. Tu peux filtrer par statut avec ces onglets."
         data-step="3"
         data-title="Les événements">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-5">
            <div>
                <div class="section-label">Événements</div>
                <h2 class="section-title">Tous les événements</h2>
                <p class="section-sub">{{ $events->total() }} événement(s) disponible(s)</p>
            </div>
            <div class="filter-tabs">
                <a href="{{ route('home') }}" class="ftab {{ !request('status') ? 'active' : '' }}">Tous</a>
                <a href="{{ route('home', ['status' => 'upcoming']) }}" class="ftab {{ request('status') == 'upcoming' ? 'active' : '' }}">À venir</a>
                <a href="{{ route('home', ['status' => 'ongoing']) }}" class="ftab {{ request('status') == 'ongoing' ? 'active' : '' }}">En cours</a>
            </div>
        </div>

        @php
        $imgs = [
            'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=600&q=80',
            'https://images.unsplash.com/photo-1528605248644-14dd04022da1?w=600&q=80',
            'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&q=80',
            'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=600&q=80',
            'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&q=80',
            'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=600&q=80',
            'https://images.unsplash.com/photo-1511578314322-379afb476865?w=600&q=80',
            'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=600&q=80',
        ];
        @endphp

        @if($events->count() > 0)
        <div class="row g-4" id="eventsGrid">
            @foreach($events as $i => $event)
            @php
                $pct = $event->max_participants > 0 ? min(100, round(($event->participants_count / $event->max_participants) * 100)) : 0;
                $spots = $event->max_participants - $event->participants_count;
            @endphp
            <div class="col-md-6 col-lg-4 event-item"
                 data-name="{{ strtolower($event->name) }}"
                 data-location="{{ strtolower($event->location) }}">
                <div class="ecard tilt-3d fade-in"
                     @if($i === 0)
                     data-intro="Voici une carte événement : tu y trouves la date, le lieu, le nombre de places restantes et une barre de remplissage."
                     data-step="4"
                     data-title="Une carte événement"
                     @endif>
                    <div class="ecard-img-wrap">
                        <img src="{{ $imgs[$i % count($imgs)] }}" class="ecard-img" alt="{{ $event->name }}">
                        <span class="sbadge
                            @if($event->status==='upcoming') s-up
                            @elseif($event->status==='ongoing') s-on
                            @elseif($event->status==='completed') s-co
                            @else s-ca @endif">
                            @if($event->status==='upcoming') <i class="bi bi-clock me-1"></i>À venir
                            @elseif($event->status==='ongoing') <i class="bi bi-lightning me-1"></i>En cours
                            @elseif($event->status==='completed') <i class="bi bi-check me-1"></i>Terminé
                            @else <i class="bi bi-x me-1"></i>Annulé @endif
                        </span>
                    </div>
                    <div class="ecard-body">
                        <div class="ecard-date">
                            <i class="bi bi-calendar3"></i>
                            {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y • H:i') }}
                        </div>
                        <h5>{{ $event->name }}</h5>
                        <p>{{ Str::limit($event->description ?? 'Rejoignez cet événement exceptionnel et vivez une expérience unique.', 85) }}</p>
                        <div class="ecard-meta">
                            <span><i class="bi bi-geo-alt-fill me-1"></i>{{ $event->location }}</span>
                            <span><i class="bi bi-people-fill me-1"></i>{{ $event->participants_count }} inscrits</span>
                        </div>
                        <div class="prog-wrap">
                            <div class="prog-fill" style="width:{{ $pct }}%"></div>
                        </div>
                        <div class="prog-text">
                            @if($spots > 0)
                                <i class="bi bi-check-circle-fill text-success me-1"></i>
                                <strong>{{ $spots }}</strong> place(s) restante(s) sur {{ $event->max_participants }}
                            @else
                                <i class="bi bi-x-circle-fill text-danger me-1"></i><strong>Complet</strong>
                            @endif
                        </div>
                        @if($spots > 0 && in_array($event->status, ['upcoming','ongoing']))
                            <a href="{{ route('public.events.show', $event) }}" class="btn-reg"
                               @if($i === 0)
                               data-intro="Clique ici pour t'inscrire directement à cet événement. Un formulaire guidé en 3 étapes s'ouvrira."
                               data-step="5"
                               data-title="S'inscrire"
                               @endif>
                                <i class="bi bi-person-plus me-2"></i>S'inscrire
                            </a>
                        @else
                            <span class="btn-reg-full">
                                <i class="bi bi-lock me-2"></i>{{ $spots <= 0 ? 'Complet' : 'Inscriptions fermées' }}
                            </span>
                        @endif
                        <a href="{{ route('public.events.show', $event) }}" class="btn-det">
                            <i class="bi bi-eye me-2"></i>Voir les détails
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-5 d-flex justify-content-center">{{ $events->links() }}</div>
        @else
        <div class="empty-state">
            <i class="bi bi-calendar-x"></i>
            <h4 class="fw-bold text-muted">Aucun événement disponible</h4>
            <p class="text-muted">Revenez bientôt !</p>
        </div>
        @endif
    </div>
</section>

<!-- ===== HOW IT WORKS ===== -->
<section class="how-section" id="how">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label">Processus</div>
            <h2 class="section-title">Simple en 3 étapes</h2>
            <p class="section-sub">Inscrivez-vous à un événement en moins de 2 minutes</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="step-card tilt-3d">
                    <img src="https://images.unsplash.com/photo-1432888622747-4eb9a8efeb07?w=500&q=80" class="step-img" alt="">
                    <div class="step-body">
                        <div class="step-num">1</div>
                        <h5>Parcourez les événements</h5>
                        <p>Explorez notre catalogue et filtrez par catégorie, date ou lieu pour trouver l'événement idéal.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card tilt-3d">
                    <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=500&q=80" class="step-img" alt="">
                    <div class="step-body">
                        <div class="step-num">2</div>
                        <h5>Inscrivez-vous en 1 clic</h5>
                        <p>Remplissez le formulaire rapide. Aucun compte requis. Confirmation immédiate !</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card tilt-3d">
                    <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=500&q=80" class="step-img" alt="">
                    <div class="step-body">
                        <div class="step-num">3</div>
                        <h5>Participez & profitez</h5>
                        <p>Rejoignez l'événement ! Votre présence est suivie en temps réel par les organisateurs.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<section class="testi-section">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label" style="color:#fbbf24;">Témoignages</div>
            <h2 class="section-title" style="color:white;">Ils nous font confiance</h2>
            <p class="section-sub" style="color:rgba(255,255,255,0.55);">Des centaines de participants satisfaits chaque mois</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="tcard tilt-3d">
                    <div class="stars">★★★★★</div>
                    <p>"Une plateforme incroyable ! Je me suis inscrit à la conférence tech en moins d'une minute. Interface intuitive et moderne."</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80" class="avatar" alt="">
                        <div>
                            <div class="name">Ahmed Ben Salah</div>
                            <div class="role">Développeur Full Stack, Tunis</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tcard tilt-3d">
                    <div class="stars">★★★★★</div>
                    <p>"Le suivi de présence en temps réel est fantastique. Notre équipe a géré 200 participants sans aucun problème !"</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&q=80" class="avatar" alt="">
                        <div>
                            <div class="name">Sana Trabelsi</div>
                            <div class="role">Chef de projet, ESPRIT</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tcard tilt-3d">
                    <div class="stars">★★★★½</div>
                    <p>"J'utilise Event Manager pour tous mes workshops. L'export CSV est un gain de temps énorme pour notre département RH."</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&q=80" class="avatar" alt="">
                        <div>
                            <div class="name">Mohamed Karim</div>
                            <div class="role">Responsable formation, Sfax</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== NEWSLETTER ===== -->
<section class="nl-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-label" style="color:#90caf9;">Newsletter</div>
                <h2>Ne manquez aucun événement !</h2>
                <p>Soyez le premier informé des nouveaux événements et des inscriptions ouvertes.</p>
                <div class="nl-form">
                    <input type="email" placeholder="votre@email.com">
                    <button><i class="bi bi-send me-2"></i>S'abonner</button>
                </div>
                <p class="nl-note"><i class="bi bi-shield-check me-1"></i>Pas de spam. Désabonnement en 1 clic.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer>
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div class="brand">
                    <div class="brand-icon"><i class="bi bi-calendar-event-fill"></i></div>
                    Event Manager
                </div>
                <p>Plateforme professionnelle de gestion d'événements développée dans le cadre du stage d'été 2026 à ESPRIT Tunis.</p>
                <div class="social-links">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                    <a href="#"><i class="bi bi-twitter-x"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h6>Navigation</h6>
                <ul>
                    <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right"></i>Accueil</a></li>
                    <li><a href="#events"><i class="bi bi-chevron-right"></i>Événements</a></li>
                    <li><a href="{{ route('login') }}"><i class="bi bi-chevron-right"></i>Connexion</a></li>
                    <li><a href="{{ route('register') }}"><i class="bi bi-chevron-right"></i>Inscription</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-3">
                <h6>Catégories</h6>
                <ul>
                    <li><a href="#"><i class="bi bi-chevron-right"></i>Technologie</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i>Business</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i>Culture & Art</a></li>
                    <li><a href="#"><i class="bi bi-chevron-right"></i>Sport</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6>Projet</h6>
                <ul>
                    <li><a href="#"><i class="bi bi-mortarboard"></i>Stage d'été 2026</a></li>
                    <li><a href="#"><i class="bi bi-building"></i>ESPRIT – Tunis</a></li>
                    <li><a href="#"><i class="bi bi-person"></i>Kmar Srarfi</a></li>
                    <li><a href="#"><i class="bi bi-person-badge"></i>M. A. Yaakoubi</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 Event Manager • Développé avec <i class="bi bi-heart-fill text-danger mx-1"></i> par Kmar Srarfi • ESPRIT Tunis</p>
        </div>
    </div>
</footer>

<!-- ===== BOUTON D'AIDE FLOTTANT ===== -->
<button class="help-float-btn" id="helpTourBtn" title="Besoin d'aide ? Lancer la visite guidée" onclick="startGuidedTour()">
    <i class="bi bi-question-lg"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intro.js/minified/intro.min.js"></script>
<script>
function filterEvents() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.event-item').forEach(el => {
        const match = el.dataset.name.includes(q) || el.dataset.location.includes(q);
        el.style.display = match ? '' : 'none';
    });
}
document.getElementById('searchInput').addEventListener('keyup', e => { if(e.key==='Enter') filterEvents(); });
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const t = document.querySelector(a.getAttribute('href'));
        if(t) { e.preventDefault(); t.scrollIntoView({behavior:'smooth'}); }
    });
});

// ===== Effet 3D : inclinaison des cartes selon la position de la souris =====
(function () {
    const cards = document.querySelectorAll('.tilt-3d');
    const isTouch = window.matchMedia('(hover: none)').matches;
    if (isTouch) return; // pas d'effet sur mobile/tactile

    cards.forEach(card => {
        card.style.perspective = '1000px';

        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = ((y - centerY) / centerY) * -6;
            const rotateY = ((x - centerX) / centerX) * 6;
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-6px) scale(1.01)`;
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0) scale(1)';
        });
    });
})();

// ===== Tour guidé Intro.js =====
function startGuidedTour() {
    // Sur mobile, on ferme la barre de navigation étendue avant de lancer, au cas où
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

// Lance automatiquement le tour au tout premier passage d'un visiteur (une seule fois par navigateur)
document.addEventListener('DOMContentLoaded', function () {
    if (!localStorage.getItem('evt_tour_seen')) {
        setTimeout(startGuidedTour, 700);
        localStorage.setItem('evt_tour_seen', '1');
    }
});
</script>
</body>
</html>