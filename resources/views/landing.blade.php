<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1"/>
    <title>GreenPoints — Recicla y Gana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#0f2318; color:#e8f5e9; font-family:'Segoe UI',system-ui,sans-serif; margin:0; }
        nav { background:#0a1a0f; border-bottom:1px solid #2a4030; padding:14px 40px; display:flex; align-items:center; justify-content:space-between; }
        .brand { font-size:1.2rem; font-weight:800; color:#e8f5e9; text-decoration:none; }
        .hero { padding:90px 40px 80px; text-align:center; background:linear-gradient(145deg,#0f2318 0%,#1B8A3E 100%); }
        .hero h1 { font-size:clamp(1.8rem,5vw,3rem); font-weight:800; margin-bottom:16px; }
        .hero p { color:rgba(232,245,233,.7); max-width:500px; margin:0 auto 32px; line-height:1.7; }
        .btn-main { background:#fff; color:#0f2318; border-radius:10px; padding:12px 28px; font-weight:700; text-decoration:none; font-size:.95rem; transition:opacity .2s; }
        .btn-main:hover { opacity:.88; color:#0f2318; }
        .btn-ghost { background:transparent; border:1.5px solid rgba(255,255,255,.4); color:#e8f5e9; border-radius:10px; padding:10px 24px; font-weight:600; text-decoration:none; font-size:.95rem; margin-left:10px; }
        .btn-ghost:hover { border-color:#4ade80; color:#4ade80; }
        .steps { padding:64px 40px; display:flex; justify-content:center; gap:24px; flex-wrap:wrap; }
        .step { background:#1a2d1f; border:1px solid #2a4030; border-radius:14px; padding:28px 22px; width:220px; text-align:center; }
        .step .icon { font-size:2.2rem; margin-bottom:12px; }
        .step h3 { font-size:.95rem; font-weight:700; color:#4ade80; margin-bottom:8px; }
        .step p { font-size:.82rem; color:#7aaa88; line-height:1.5; margin:0; }
        .cta { background:#1B8A3E; text-align:center; padding:60px 40px; }
        .cta h2 { font-size:1.8rem; font-weight:700; margin-bottom:10px; }
        .cta p { opacity:.8; margin-bottom:24px; }
        footer { background:#0a1a0f; text-align:center; padding:18px; color:#4a7060; font-size:.78rem; border-top:1px solid #2a4030; }
        .nav-btns a { background:transparent; border:1px solid #2a4030; color:#7aaa88; border-radius:8px; padding:7px 16px; text-decoration:none; font-size:.85rem; margin-left:8px; transition:border-color .18s,color .18s; }
        .nav-btns a:hover { border-color:#1B8A3E; color:#4ade80; }
        .nav-btns a.solid { background:#1B8A3E; color:#fff; border-color:#1B8A3E; }
    </style>
</head>
<body>

<nav>
    <a href="/" class="brand">♻️ GreenPoints</a>
    <div class="nav-btns">
        <a href="{{ route('login') }}">Iniciar sesión</a>
        <a href="{{ route('register') }}" class="solid">Registrarse</a>
    </div>
</nav>

<section class="hero">
    <h1>Recicla hoy.<br>Gana puntos.<br>Cuida el planeta.</h1>
    <p>GreenPoints te premia por cada acción ecológica. Registra tus reciclajes, acumula puntos y canjéalos por recompensas.</p>
    <a href="{{ route('register') }}" class="btn-main">Comenzar gratis 🌱</a>
    <a href="{{ route('login') }}" class="btn-ghost">Iniciar sesión</a>
</section>

<section class="steps">
    <div class="step"><div class="icon">📱</div><h3>1. Regístrate</h3><p>Crea tu cuenta gratuita y accede a tu panel personal.</p></div>
    <div class="step"><div class="icon">♻️</div><h3>2. Recicla</h3><p>Registra tus acciones ecológicas seleccionando el tipo de material y el dispositivo.</p></div>
    <div class="step"><div class="icon">⭐</div><h3>3. Acumula</h3><p>Cada acción registrada suma puntos a tu cuenta automáticamente.</p></div>
    <div class="step"><div class="icon">🎁</div><h3>4. Canjea</h3><p>Usa tus puntos para obtener premios ecológicos del catálogo.</p></div>
</section>

<section class="cta">
    <h2>¿Listo para empezar?</h2>
    <p>Únete a la comunidad verde de GreenPoints.</p>
    <a href="{{ route('register') }}" class="btn-main">Crear mi cuenta</a>
</section>

<footer>GreenPoints © {{ date('Y') }} — Proyecto académico UGB</footer>

</body>
</html>
