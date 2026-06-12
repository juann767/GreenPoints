<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<style>
  body { margin:0; padding:0; background:#f0f7f0; font-family:'Segoe UI',Arial,sans-serif; }
  .wrap { max-width:580px; margin:32px auto; background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
  .header { background:linear-gradient(135deg,#1b5e20,#2e7d32); padding:32px 40px; text-align:center; }
  .header .logo { font-size:2rem; }
  .header h1 { color:#fff; font-size:1.3rem; font-weight:700; margin:8px 0 4px; }
  .header p { color:rgba(255,255,255,.8); font-size:.88rem; margin:0; }
  .pts-big { background:#e8f5e9; border-radius:12px; padding:20px; text-align:center; margin:20px 0; }
  .pts-big .val { font-size:2.8rem; font-weight:800; color:#2e7d32; line-height:1; }
  .pts-big .lbl { font-size:.85rem; color:#5a7360; margin-top:4px; }
  .body { padding:32px 40px; }
  .body h2 { color:#1b5e20; font-size:1.1rem; font-weight:700; margin-bottom:12px; }
  .body p { color:#444; font-size:.92rem; line-height:1.7; margin-bottom:12px; }
  .detail-row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #f0f0f0; font-size:.88rem; }
  .detail-row .key { color:#888; }
  .detail-row .val { font-weight:600; color:#333; }
  .btn { display:inline-block; background:#2e7d32; color:#fff !important; text-decoration:none; border-radius:8px; padding:11px 26px; font-weight:700; font-size:.9rem; margin:16px 0; }
  .footer { background:#f5f5f5; padding:16px 40px; text-align:center; font-size:.78rem; color:#999; border-top:1px solid #eee; }
  .progress-wrap { background:#e0e0e0; border-radius:8px; height:10px; overflow:hidden; margin:8px 0; }
  .progress-bar { background:#2e7d32; height:100%; border-radius:8px; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <div class="logo">♻️</div>
    <h1>¡Reciclaje registrado con éxito!</h1>
    <p>Tu contribución al planeta cuenta</p>
  </div>

  <div class="body">
    <h2>¡Bien hecho, {{ $user->nombre }}!</h2>
    <p>Has registrado una nueva acción ecológica. Los puntos ya fueron acreditados a tu cuenta.</p>

    <div class="pts-big">
      <div class="val">+{{ $registro->accion->puntos_otorgados }} pts</div>
      <div class="lbl">ganados en esta acción</div>
    </div>

    <div class="detail-row"><span class="key">Acción realizada</span><span class="val">{{ $registro->accion->nombre }}</span></div>
    <div class="detail-row"><span class="key">Fecha</span><span class="val">{{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</span></div>
    @if($registro->cantidad_kg)
    <div class="detail-row"><span class="key">Cantidad</span><span class="val">{{ $registro->cantidad_kg }} kg</span></div>
    @endif
    @if($registro->dispositivo)
    <div class="detail-row"><span class="key">Dispositivo</span><span class="val">{{ $registro->dispositivo->nombre }}</span></div>
    @endif
    <div class="detail-row" style="border-bottom:none;"><span class="key">Puntos totales acumulados</span><span class="val" style="color:#2e7d32;font-size:1rem;">{{ $user->puntos }} pts</span></div>

    @php
      $siguiente = $user->puntos < 200 ? 200 : ($user->puntos < 500 ? 500 : 1000);
      $pct = min(100, round($user->puntos / $siguiente * 100));
      $nivel = $user->puntos >= 500 ? '🌳 Sembrador' : ($user->puntos >= 200 ? '🌿 Guardabosques' : '🌱 Principiante');
    @endphp

    <p style="margin-top:20px;margin-bottom:6px;font-size:.85rem;color:#555;">
      Nivel actual: <strong>{{ $nivel }}</strong> — {{ $user->puntos }}/{{ $siguiente }} pts
    </p>
    <div class="progress-wrap">
      <div class="progress-bar" style="width:{{ $pct }}%;"></div>
    </div>

    <a href="{{ config('app.url') }}/premios" class="btn">Ver premios disponibles →</a>
  </div>

  <div class="footer">
    GreenPoints &copy; {{ date('Y') }} — Notificación automática del sistema.
  </div>
</div>
</body>
</html>
