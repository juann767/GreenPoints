<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<style>
  body { margin:0; padding:0; background:#f0f7f0; font-family:'Segoe UI',Arial,sans-serif; }
  .wrap { max-width:580px; margin:32px auto; background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
  .header { background:linear-gradient(135deg,#1b5e20,#388e3c); padding:32px 40px; text-align:center; }
  .header .logo { font-size:2.2rem; }
  .header h1 { color:#fff; font-size:1.3rem; font-weight:700; margin:8px 0 4px; }
  .header p { color:rgba(255,255,255,.8); font-size:.88rem; margin:0; }
  .body { padding:32px 40px; }
  .body h2 { color:#1b5e20; font-size:1.1rem; font-weight:700; margin-bottom:12px; }
  .body p { color:#444; font-size:.92rem; line-height:1.7; margin-bottom:12px; }
  .premio-card { background:#e8f5e9; border:1px solid #c8e6c9; border-radius:12px; padding:20px 24px; margin:16px 0; }
  .premio-card .nombre { font-size:1.15rem; font-weight:700; color:#1b5e20; margin-bottom:6px; }
  .premio-card .desc { font-size:.85rem; color:#5a7360; }
  .pts-used { font-size:1.6rem; font-weight:800; color:#e53935; }
  .pts-left { font-size:1.6rem; font-weight:800; color:#2e7d32; }
  .row { display:flex; justify-content:space-between; padding:9px 0; border-bottom:1px solid #f0f0f0; font-size:.88rem; }
  .row .key { color:#888; }
  .row .val { font-weight:600; color:#333; }
  .btn { display:inline-block; background:#2e7d32; color:#fff !important; text-decoration:none; border-radius:8px; padding:11px 26px; font-weight:700; font-size:.9rem; margin:16px 0; }
  .footer { background:#f5f5f5; padding:16px 40px; text-align:center; font-size:.78rem; color:#999; border-top:1px solid #eee; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <div class="logo">🎁</div>
    <h1>¡Canje realizado con éxito!</h1>
    <p>Tu recompensa está confirmada</p>
  </div>

  <div class="body">
    <h2>¡Felicidades, {{ $user->nombre }}!</h2>
    <p>Has canjeado exitosamente el siguiente premio con tus puntos GreenPoints:</p>

    <div class="premio-card">
      <div class="nombre">🎁 {{ $canje->premio->nombre }}</div>
      <div class="desc">{{ $canje->premio->descripcion }}</div>
    </div>

    <div class="row"><span class="key">Puntos utilizados</span><span class="val"><span class="pts-used">-{{ $canje->premio->puntos_requeridos }} pts</span></span></div>
    <div class="row"><span class="key">Fecha del canje</span><span class="val">{{ \Carbon\Carbon::parse($canje->fecha_canje)->format('d/m/Y H:i') }}</span></div>
    <div class="row" style="border-bottom:none;"><span class="key">Puntos restantes</span><span class="val"><span class="pts-left">{{ $user->puntos }} pts</span></span></div>

    <p style="margin-top:18px;font-size:.85rem;color:#666;">
      Para hacer efectivo tu premio, preséntate en el punto de canje correspondiente con este correo como comprobante.
    </p>

    <a href="{{ config('app.url') }}/dashboard" class="btn">Ver mi dashboard →</a>
  </div>

  <div class="footer">
    GreenPoints &copy; {{ date('Y') }} — Notificación automática del sistema.
  </div>
</div>
</body>
</html>
