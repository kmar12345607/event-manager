<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Event Manager - Mot de passe oublié</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#f4f7fc;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;}
.card-box{background:white;width:100%;max-width:480px;padding:40px;border-radius:25px;box-shadow:0 15px 50px rgba(0,0,0,.1);}
.logo{width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,#1a237e,#1565c0);display:flex;align-items:center;justify-content:center;margin:auto;color:white;font-size:35px;margin-bottom:20px;}
.title{text-align:center;margin-bottom:30px;}
.title h2{font-weight:700;color:#1a237e;}
.title p{color:#6c757d;font-size:.92rem;}
.form-control{height:55px;border-radius:12px;border:2px solid #e6e9f0;}
.form-control:focus{border-color:#1565c0;box-shadow:none;}
.input-group-text{border-radius:12px 0 0 12px;border:2px solid #e6e9f0;background:#f7f8fb;color:#1565c0;}
.btn-action{height:55px;border:none;border-radius:12px;background:linear-gradient(135deg,#1a237e,#1565c0);font-weight:600;font-size:16px;color:white;transition:.3s;}
.btn-action:hover{transform:translateY(-2px);box-shadow:0 10px 25px rgba(21,101,192,.35);color:white;}
.back-link{text-align:center;margin-top:20px;}
.back-link a{text-decoration:none;font-weight:600;color:#1565c0;}
</style>
</head>
<body>

<div class="card-box"
     data-intro="Indique l'adresse email de ton compte : tu recevras un lien pour choisir un nouveau mot de passe."
     data-step="1"
     data-title="Mot de passe oublié">

    <div class="logo"><i class="bi bi-key"></i></div>

    <div class="title">
        <h2>Mot de passe oublié</h2>
        <p>Indiquez votre email, nous vous enverrons un lien de réinitialisation.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label class="form-label fw-semibold">Adresse Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="exemple@email.com" required autofocus>
            </div>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-action w-100"
                data-intro="Clique ici : un email contenant le lien de réinitialisation part immédiatement."
                data-step="2"
                data-title="Envoyer le lien">
            <i class="bi bi-send me-2"></i>Envoyer le lien de réinitialisation
        </button>

        <div class="back-link">
            <a href="{{ route('login') }}"><i class="bi bi-arrow-left me-1"></i>Retour à la connexion</a>
        </div>
    </form>
</div>

@include('partials.tour-widget')

</body>
</html>
