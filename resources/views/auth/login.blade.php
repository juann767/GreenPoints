<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1"/>
    <title>GreenPoints — Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background:#0f2318; min-height:100vh; display:flex; align-items:center; justify-content:center; font-family:'Segoe UI',system-ui,sans-serif; }
        .auth-wrap { display:flex; width:100%; max-width:820px; border-radius:18px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.5); }
        .auth-left { background:linear-gradient(145deg,#0f2318,#1B8A3E); padding:50px 40px; flex:1; display:flex; flex-direction:column; justify-content:center; color:#fff; }
        .auth-left .brand { font-size:1.6rem; font-weight:800; margin-bottom:8px; }
        .auth-left p { color:rgba(255,255,255,.65); font-size:.9rem; line-height:1.6; }
        .auth-right { background:#111c15; padding:40px 36px; width:360px; }
        .auth-right h2 { color:#e8f5e9; font-size:1.2rem; font-weight:700; margin-bottom:6px; }
        .auth-right p { color:#7aaa88; font-size:.83rem; margin-bottom:24px; }
        .form-control { background:#0f2318 !important; border:1px solid #2a4030 !important; color:#e8f5e9 !important; border-radius:8px; padding:10px 14px; }
        .form-control::placeholder { color:#4a7060 !important; }
        .form-control:focus { border-color:#1B8A3E !important; box-shadow:0 0 0 .2rem rgba(27,138,62,.25) !important; }
        .form-label { color:#7aaa88; font-size:.82rem; font-weight:500; }
        .btn-login { background:#1B8A3E; color:#fff; border:none; border-radius:8px; padding:11px; width:100%; font-weight:700; font-size:.95rem; transition:background .18s; }
        .btn-login:hover { background:#22a84e; color:#fff; }
        .auth-link { color:#4ade80; text-decoration:none; font-size:.83rem; }
        .err-box { background:rgba(248,113,113,.1); border:1px solid rgba(248,113,113,.3); color:#f87171; border-radius:8px; padding:10px 14px; font-size:.85rem; margin-bottom:16px; }
    </style>
</head>
<body>
<div class="auth-wrap">
    <div class="auth-left">
        <div class="brand">♻️ GreenPoints</div>
        <div style="font-size:1rem;font-weight:600;margin-bottom:12px;opacity:.9;">Plataforma de reciclaje y recompensas</div>
        <p>Registra tus acciones ecológicas, acumula puntos y canjéalos por premios. Juntos construimos un planeta más limpio.</p>
    </div>
    <div class="auth-right">
        <h2>Iniciar sesión</h2>
        <p>Ingresa tus credenciales para continuar</p>

        @if($errors->any())
            <div class="err-box"><i class="bi bi-exclamation-circle me-1"></i> {{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="usuario@email.com" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-login">Iniciar sesión</button>
        </form>

        <p class="text-center mt-4 mb-0" style="font-size:.83rem;color:#7aaa88;">
            ¿No tienes cuenta? <a href="{{ route('register') }}" class="auth-link">Regístrate aquí</a>
        </p>
    </div>
</div>
</body>
</html>
