<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<style>
  body { margin:0; padding:0; background:#f0f7f0; font-family:'Segoe UI',Arial,sans-serif; }
  .wrap { max-width:580px; margin:32px auto; background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
  .header { background:linear-gradient(135deg,#1b5e20,#2e7d32); padding:36px 40px; text-align:center; }
  .header .logo { font-size:2.4rem; }
  .header h1 { color:#fff; font-size:1.5rem; font-weight:700; margin:10px 0 4px; }
  .header p { color:rgba(255,255,255,.8); font-size:.9rem; margin:0; }
  .body { padding:36px 40px; }
  .body h2 { color:#1b5e20; font-size:1.2rem; font-weight:700; margin-bottom:12px; }
  .body p { color:#444; font-size:.92rem; line-height:1.7; margin-bottom:14px; }
  .stat-row { display:flex; gap:12px; margin:20px 0; }
  .stat { flex:1; background:#e8f5e9; border-radius:10px; padding:14px; text-align:center; }
  .stat .val { font-size:1.4rem; font-weight:800; color:#2e7d32; }
  .stat .lbl { font-size:.75rem; color:#5a7360; margin-top:3px; }
  .btn { display:inline-block; background:#2e7d32; color:#fff !important; text-decoration:none; border-radius:8px; padding:12px 28px; font-weight:700; font-size:.95rem; margin:10px 0; }
  .footer { background:#f5f5f5; padding:18px 40px; text-align:center; font-size:.78rem; color:#999; border-top:1px solid #eee; }
  .tip { background:#f1f8e9; border-left:4px solid #66bb6a; padding:12px 16px; border-radius:0 8px 8px 0; margin:16px 0; font-size:.88rem; color:#33691e; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <div class="logo">🌱</div>
    <h1>¡Bienvenido a GreenPoints!</h1>
    <p>Plataforma de reciclaje y recompensas</p>
  </div>

  <div class="body">
    <h2>Hola, {{ $user->nombre }} 👋</h2>
    <p>¡Tu cuenta ha sido creada exitosamente! Ya formas parte de la comunidad GreenPoints. A partir de ahora puedes registrar tus acciones ecológicas, acumular puntos y canjearlos por premios.</p>

    <div class="stat-row">
      <div class="stat">
        <div class="val">0</div>
        <div class="lbl">Puntos iniciales</div>
      </div>
      <div class="stat">
        <div class="val">🌱</div>
        <div class="lbl">Nivel: Principiante</div>
      </div>
      <div class="stat">
        <div class="val">200</div>
        <div class="lbl">Pts para subir nivel</div>
      </div>
    </div>

    <div class="tip">
      💡 <strong>Tip:</strong> Registra tu primer reciclaje hoy para comenzar a ganar puntos. Reciclar papel y cartón te da +30 pts.
    </div>

    <p>Ingresa a la plataforma y comienza tu camino ecológico:</p>
    <a href="{{ config('app.url') }}/login" class="btn">Ir a GreenPoints →</a>

    <p style="font-size:.82rem;color:#888;margin-top:20px;">
      Tu correo registrado es: <strong>{{ $user->email }}</strong>
    </p>
  </div>

  <div class="footer">
    GreenPoints &copy; {{ date('Y') }} — Este correo fue enviado automáticamente. No respondas a este mensaje.
  </div>
</div>
</body>
</html>
