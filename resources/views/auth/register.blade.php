<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Event Manager - Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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
url('https://images.unsplash.com/photo-1511578314322-379afb476865?q=80&w=1200');

background-size:cover;
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

.register-card{
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

.btn-register{
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

.btn-register:hover{
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

@media(max-width:991px){

.left-side{
display:none;
}

.right-side{
padding:20px;
}

.register-card{
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

<div class="register-card">

<div class="logo">
<i class="bi bi-calendar-event-fill"></i>
</div>

<div class="title">
<h2>Créer un compte</h2>
<p>Commencez à gérer vos événements</p>
</div>

<form method="POST" action="{{ route('register') }}">
@csrf

<div class="mb-3">
<label class="form-label fw-semibold">
Nom complet
</label>

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-person"></i>
</span>

<input
type="text"
name="name"
class="form-control @error('name') is-invalid @enderror"
placeholder="Votre nom complet"
required>

</div>

@error('name')
<div class="text-danger small mt-1">
{{ $message }}
</div>
@enderror

</div>

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
class="form-control @error('email') is-invalid @enderror"
placeholder="exemple@email.com"
required>

</div>

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
class="form-control"
placeholder="********"
required>

</div>

</div>

<div class="mb-4">

<label class="form-label fw-semibold">
Confirmer le mot de passe
</label>

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-shield-lock"></i>
</span>

<input
type="password"
name="password_confirmation"
class="form-control"
placeholder="********"
required>

</div>

</div>

<button
type="submit"
class="btn btn-primary btn-register w-100">

<i class="bi bi-person-plus-fill me-2"></i>

Créer mon compte

</button>

<div class="login-link">

Déjà inscrit ?

<a href="{{ route('login') }}">
Se connecter
</a>

</div>

</form>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>