<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Event Manager - Nouveau mot de passe</title>

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
</style>
</head>
<body>

<div class="card-box"
     data-intro="Choisis ton nouveau mot de passe (8 caractères minimum) et confirme-le."
     data-step="1"
     data-title="Nouveau mot de passe">

    <div class="logo"><i class="bi bi-shield-lock"></i></div>

    <div class="title">
        <h2>Nouveau mot de passe</h2>
        <p>Choisissez un nouveau mot de passe pour votre compte.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label class="form-label fw-semibold">Adresse Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" value="{{ old('email', $request->email) }}"
                       class="form-control @error('email') is-invalid @enderror"
                       required autofocus autocomplete="username">
            </div>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Nouveau mot de passe</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="********" required autocomplete="new-password">
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Confirmer le mot de passe</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                <input type="password" name="password_confirmation"
                       class="form-control @error('password_confirmation') is-invalid @enderror"
                       placeholder="********" required autocomplete="new-password">
            </div>
            @error('password_confirmation')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-action w-100"
                data-intro="Clique ici pour valider. Tu pourras ensuite te connecter avec ce nouveau mot de passe."
                data-step="2"
                data-title="Valider">
            <i class="bi bi-check-circle me-2"></i>Réinitialiser le mot de passe
        </button>
    </form>
</div>

@include('partials.tour-widget')

</body>
</html>
