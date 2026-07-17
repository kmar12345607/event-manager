<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Event Manager - Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
}

body{
background:#f4f7fc;
overflow-x:hidden;
}

.left-side{
min-height:100vh;
background:
linear-gradient(
rgba(26,35,126,.85),
rgba(21,101,192,.85)
),
url('https://images.unsplash.com/photo-1551434678-e076c223a692?q=80&w=1200');background-size:cover;
background-position:center;
display:flex;
align-items:center;
justify-content:center;
padding:50px;
color:white;
}

.hero-content{
max-width:550px;
}

.hero-content h1{
font-size:3rem;
font-weight:800;
margin-bottom:20px;
}

.hero-content p{
font-size:1.1rem;
line-height:1.8;
opacity:.9;
margin-bottom:40px;
}

.stats-grid{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:15px;
}

.stat-card{
background:rgba(255,255,255,.15);
backdrop-filter:blur(10px);
padding:20px;
border-radius:15px;
text-align:center;
}

.stat-card h3{
font-weight:800;
margin-bottom:5px;
}

.stat-card span{
font-size:.9rem;
opacity:.8;
}

.right-side{
min-height:100vh;
display:flex;
align-items:center;
justify-content:center;
padding:40px;
background:#f8f9fc;
}

.login-card{
background:white;
width:100%;
max-width:500px;
padding:40px;
border-radius:25px;
box-shadow:0 15px 50px rgba(0,0,0,.1);
}

.logo{
width:90px;
height:90px;
border-radius:50%;
background:linear-gradient(135deg,#1a237e,#1565c0);
display:flex;
align-items:center;
justify-content:center;
margin:auto;
color:white;
font-size:35px;
margin-bottom:20px;
}

.title{
text-align:center;
margin-bottom:35px;
}

.title h2{
font-weight:700;
color:#1a237e;
}

.title p{
color:#6c757d;
}

.form-control{
height:55px;
border-radius:12px;
border:2px solid #e6e9f0;
}

.form-control:focus{
border-color:#1565c0;
box-shadow:none;
}

.input-group-text{
border-radius:12px 0 0 12px;
border:2px solid #e6e9f0;
background:#f7f8fb;
color:#1565c0;
}

.btn-login{
height:55px;
border:none;
border-radius:12px;
background:linear-gradient(
135deg,
#1a237e,
#1565c0
);
font-weight:600;
font-size:16px;
transition:.3s;
}

.btn-login:hover{
transform:translateY(-2px);
box-shadow:0 10px 25px rgba(21,101,192,.35);
}

.login-link{
text-align:center;
margin-top:20px;
}

.login-link a{
text-decoration:none;
font-weight:600;
}

.form-check-input:checked{
background-color:#1565c0;
border-color:#1565c0;
}

@media(max-width:991px){

.left-side{
display:none;
}

.right-side{
padding:20px;
}

.login-card{
padding:30px;
}

}

</style>

</head>

<body>

<div class="container-fluid">

<div class="row">

<!-- LEFT SIDE -->

<div class="col-lg-6 left-side">

<div class="hero-content">

<h1>
Event Registration &
Participant Management
</h1>

<p>
Gérez facilement vos événements,
les inscriptions des participants,
la présence et les statistiques
depuis une seule plateforme moderne.
</p>

<div class="stats-grid">

<div class="stat-card">
<h3>500+</h3>
<span>Participants</span>
</div>

<div class="stat-card">
<h3>50+</h3>
<span>Événements</span>
</div>

<div class="stat-card">
<h3>98%</h3>
<span>Satisfaction</span>
</div>

</div>

</div>

</div>

<!-- RIGHT SIDE -->

<div class="col-lg-6 right-side">

<div class="login-card" data-intro="Connecte-toi ici avec ton email et ton mot de passe pour retrouver ton espace personnel." data-step="1" data-title="Se connecter">

<div class="logo">
<i class="bi bi-box-arrow-in-right"></i>
</div>

<div class="title">
<h2>Connexion</h2>
<p>Accédez à votre espace de gestion</p>
</div>

<form method="POST" action="{{ route('login') }}">
@csrf

<input type="hidden" name="redirect_to" value="{{ request('redirect_to') }}">

<div class="mb-3">

<label class="form-label fw-semibold">
Adresse Email
</label>

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-envelope"></i>
</span>

<input
type="email"
name="email"
value="{{ old('email') }}"
class="form-control @error('email') is-invalid @enderror"
placeholder="exemple@email.com"
required
autofocus>

</div>

@error('email')
<div class="text-danger small mt-1">
{{ $message }}
</div>
@enderror

</div>

<div class="mb-3">

<label class="form-label fw-semibold">
Mot de passe
</label>

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-lock"></i>
</span>

<input
type="password"
name="password"
class="form-control @error('password') is-invalid @enderror"
placeholder="********"
required>

</div>

@error('password')
<div class="text-danger small mt-1">
{{ $message }}
</div>
@enderror

</div>

<div class="d-flex justify-content-between align-items-center mb-4">

<div class="form-check">

<input
class="form-check-input"
type="checkbox"
name="remember"
id="remember">

<label
class="form-check-label"
for="remember">

Se souvenir de moi

</label>

</div>

@if (Route::has('password.request'))

<a
href="{{ route('password.request') }}"
class="text-decoration-none"
data-intro="Mot de passe oublié ? Clique ici, tu recevras un lien de réinitialisation par email."
data-step="2"
data-title="Mot de passe oublié">

Mot de passe oublié ?

</a>

@endif

</div>

<div class="mb-4 d-flex justify-content-center"
     data-intro="Coche simplement la case pour prouver que tu n'es pas un robot."
     data-step="3"
     data-title="Vérification">

@if(config('services.recaptcha.site_key'))
<div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
@endif

@error('g-recaptcha-response')
<div class="text-danger small mt-1 text-center">
{{ $message }}
</div>
@enderror

</div>

<button
type="submit"
class="btn btn-primary btn-login w-100">

<i class="bi bi-box-arrow-in-right me-2"></i>

Se connecter

</button>

<div class="login-link" data-intro="Pas encore de compte ? Clique ici pour en créer un gratuitement en moins d'une minute." data-step="4" data-title="Créer un compte">

Pas encore de compte ?

<a href="{{ route('register', ['redirect_to' => request('redirect_to')]) }}">
Créer un compte
</a>

</div>

</form>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

document.addEventListener('DOMContentLoaded', function () {

    const inputs = document.querySelectorAll('input');

    inputs.forEach(input => {

        input.addEventListener('input', function () {

            if(this.value.trim() === ''){
                this.classList.remove('is-valid');
                this.classList.remove('is-invalid');
                return;
            }

            if(this.type === 'email'){

                const emailPattern =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if(emailPattern.test(this.value)){
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                }else{
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                }

            }

        });

    });

});

</script>

@include('partials.tour-widget')

</body>
</html>