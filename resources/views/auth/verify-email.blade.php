<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Event Manager - Vérifiez votre email</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#f4f7fc;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;}
.card-box{background:white;width:100%;max-width:480px;padding:40px;border-radius:25px;box-shadow:0 15px 50px rgba(0,0,0,.1);text-align:center;}
.logo{width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,#1a237e,#1565c0);display:flex;align-items:center;justify-content:center;margin:auto;color:white;font-size:35px;margin-bottom:20px;}
.title h2{font-weight:700;color:#1a237e;margin-bottom:8px;}
.title p{color:#6c757d;font-size:.92rem;margin-bottom:25px;}
.email-chip{display:inline-flex;align-items:center;gap:8px;background:#eff6ff;color:#1565c0;font-weight:600;padding:8px 18px;border-radius:30px;font-size:.9rem;margin-bottom:25px;}
.btn-action{height:52px;border:none;border-radius:12px;background:linear-gradient(135deg,#1a237e,#1565c0);font-weight:600;font-size:15px;color:white;transition:.3s;width:100%;}
.btn-action:hover{transform:translateY(-2px);box-shadow:0 10px 25px rgba(21,101,192,.35);color:white;}
.btn-logout{background:none;border:none;color:#6c757d;font-size:.88rem;text-decoration:underline;margin-top:18px;}
.btn-logout:hover{color:#dc3545;}
</style>
</head>
<body>

<div class="card-box"
     data-intro="Un email de confirmation vient d'être envoyé. Cette étape protège ton compte : elle prouve que l'adresse t'appartient bien."
     data-step="1"
     data-title="Vérifie ton email">

    <div class="logo"><i class="bi bi-envelope-check"></i></div>

    <div class="title">
        <h2>Vérifiez votre email</h2>
        <p>Un lien de confirmation a été envoyé à l'adresse ci-dessous. Cliquez dessus pour activer votre compte.</p>
    </div>

    <div class="email-chip"><i class="bi bi-envelope"></i> {{ auth()->user()->email }}</div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-1"></i>
            Un nouveau lien de vérification a été envoyé à votre adresse email.
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle me-1"></i>
            {{ session('error') }}
        </div>
    @endif

    <p class="text-muted mb-3" style="font-size:.85rem;">
        Vous ne trouvez pas l'email ? Vérifiez vos spams, ou renvoyez-en un nouveau.
    </p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn-action"
                data-intro="Rien reçu après quelques minutes ? Clique ici pour renvoyer l'email de vérification."
                data-step="2"
                data-title="Renvoyer l'email">
            <i class="bi bi-arrow-clockwise me-2"></i>Renvoyer l'email de vérification
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">
            <i class="bi bi-box-arrow-right me-1"></i>Se déconnecter
        </button>
    </form>
</div>

@include('partials.tour-widget')

</body>
</html>