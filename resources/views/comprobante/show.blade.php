<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Comprobante #{{ str_pad($registro->id, 6, '0', STR_PAD_LEFT) }} — GreenPoints</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --gp-green:  #1B5E20;
            --gp-green2: #2e7d32;
            --gp-light:  #e8f5e9;
            --gp-border: #c8e6c9;
        }

        body {
            background: #f0f7f0;
            font-family: 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 32px 16px;
        }

        /* ── Barra de acciones (no se imprime) ── */
        .action-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 520px;
            margin-bottom: 20px;
        }

        .btn-back {
            background: transparent;
            border: 1px solid #c8e6c9;
            color: var(--gp-green);
            border-radius: 8px;
            padding: 8px 16px;
            font-size: .88rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background .18s;
        }
        .btn-back:hover { background: var(--gp-light); color: var(--gp-green); }

        .btn-print {
            background: var(--gp-green);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 9px 20px;
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background .18s;
        }
        .btn-print:hover { background: var(--gp-green2); }

        /* ── Comprobante ── */
        .comprobante {
            background: #fff;
            border-radius: 18px;
            width: 100%;
            max-width: 520px;
            overflow: hidden;
            box-shadow: 0 4px 32px rgba(27,94,32,.12);
        }

        .comp-header {
            background: linear-gradient(135deg, var(--gp-green), var(--gp-green2));
            padding: 28px 32px;
            color: #fff;
            text-align: center;
        }

        .comp-header .logo { font-size: 2rem; margin-bottom: 6px; }
        .comp-header h1 { font-size: 1.2rem; font-weight: 700; margin: 0 0 4px; }
        .comp-header .codigo {
            display: inline-block;
            background: rgba(255,255,255,.18);
            border: 1px solid rgba(255,255,255,.35);
            border-radius: 20px;
            padding: 4px 16px;
            font-size: .85rem;
            font-family: monospace;
            letter-spacing: .08em;
            margin-top: 8px;
        }

        /* ── QR ── */
        .comp-qr {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 28px;
            background: var(--gp-light);
            border-bottom: 2px dashed var(--gp-border);
        }

        .comp-qr img {
            width: 180px;
            height: 180px;
            border-radius: 12px;
            border: 3px solid #fff;
            box-shadow: 0 2px 16px rgba(27,94,32,.15);
        }

        .comp-qr .qr-label {
            font-size: .78rem;
            color: #5a7360;
            margin-top: 10px;
            text-align: center;
        }

        /* ── Detalles ── */
        .comp-body { padding: 24px 32px; }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px dashed #e8f5e9;
            font-size: .9rem;
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-row .key { color: #7aaa88; min-width: 130px; }
        .detail-row .val { font-weight: 600; color: #1c2b1c; text-align: right; }

        /* ── Puntos ── */
        .pts-box {
            background: var(--gp-light);
            border: 1px solid var(--gp-border);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            margin: 20px 0 0;
        }
        .pts-box .pts-val {
            font-size: 2.4rem;
            font-weight: 800;
            color: var(--gp-green);
            line-height: 1;
        }
        .pts-box .pts-lbl { font-size: .8rem; color: #5a7360; margin-top: 4px; }

        /* ── Footer ── */
        .comp-footer {
            background: #f8fdf8;
            border-top: 1px solid var(--gp-border);
            padding: 16px 32px;
            text-align: center;
            font-size: .75rem;
            color: #7aaa88;
        }

        /* ── Sello de validez ── */
        .sello {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e8f5e9;
            border: 1px solid #a5d6a7;
            border-radius: 20px;
            padding: 4px 14px;
            font-size: .78rem;
            color: var(--gp-green);
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* ── PRINT ── */
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .action-bar { display: none !important; }
            .comprobante {
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
            }
            .btn-print { display: none; }
        }
    </style>
</head>
<body>

{{-- Barra de acciones --}}
<div class="action-bar">
    <a href="{{ route('reciclaje.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
    <div class="d-flex gap-2">
        <button class="btn-print" onclick="window.print()">
            <i class="bi bi-printer"></i> Imprimir
        </button>
    </div>
</div>

{{-- Comprobante --}}
<div class="comprobante">

    {{-- Cabecera --}}
    <div class="comp-header">
        <div class="logo">🌱</div>
        <h1>Comprobante de Reciclaje</h1>
        <p style="opacity:.8;font-size:.85rem;margin:4px 0 0;">GreenPoints — Plataforma de reciclaje y recompensas</p>
        <div class="codigo">
            #{{ str_pad($registro->id, 6, '0', STR_PAD_LEFT) }}
        </div>
    </div>

    {{-- QR --}}
    <div class="comp-qr">
        <img src="{{ $qrBase64 }}" alt="Código QR del comprobante">
        <div class="qr-label">
            Escanea para verificar este comprobante<br>
            <span style="font-family:monospace;font-size:.82rem;color:var(--gp-green);font-weight:600;">
                GP-{{ str_pad($registro->id, 6, '0', STR_PAD_LEFT) }}
            </span>
        </div>
    </div>

    {{-- Detalle --}}
    <div class="comp-body">

        <div class="sello">
            <i class="bi bi-patch-check-fill" style="color:#2e7d32;"></i>
            Acción registrada y verificada
        </div>

        <div class="detail-row">
            <span class="key"><i class="bi bi-person me-1"></i> Reciclador</span>
            <span class="val">{{ $registro->usuario->nombre }}</span>
        </div>

        <div class="detail-row">
            <span class="key"><i class="bi bi-recycle me-1"></i> Tipo de acción</span>
            <span class="val">{{ $registro->accion->nombre }}</span>
        </div>

        @if($registro->dispositivo)
        <div class="detail-row">
            <span class="key"><i class="bi bi-geo-alt me-1"></i> Dispositivo</span>
            <span class="val">{{ $registro->dispositivo->nombre }}</span>
        </div>
        <div class="detail-row">
            <span class="key"><i class="bi bi-map me-1"></i> Ubicación</span>
            <span class="val">{{ $registro->dispositivo->ubicacion }}</span>
        </div>
        @endif

        @if($registro->cantidad_kg)
        <div class="detail-row">
            <span class="key"><i class="bi bi-box-seam me-1"></i> Cantidad</span>
            <span class="val">{{ $registro->cantidad_kg }} kg</span>
        </div>
        @endif

        <div class="detail-row">
            <span class="key"><i class="bi bi-calendar me-1"></i> Fecha</span>
            <span class="val">{{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</span>
        </div>

        <div class="detail-row">
            <span class="key"><i class="bi bi-clock me-1"></i> Registrado</span>
            <span class="val">{{ $registro->created_at->format('d/m/Y H:i') }}</span>
        </div>

        @if($registro->observaciones)
        <div class="detail-row">
            <span class="key"><i class="bi bi-chat-text me-1"></i> Notas</span>
            <span class="val" style="font-weight:400;max-width:220px;text-align:right;">{{ $registro->observaciones }}</span>
        </div>
        @endif

        {{-- Puntos ganados --}}
        <div class="pts-box">
            <div class="pts-val">+{{ $registro->accion->puntos_otorgados }}</div>
            <div class="pts-lbl">puntos GreenPoints acreditados</div>
        </div>

    </div>

    {{-- Footer --}}
    <div class="comp-footer">
        <div>Presenta este comprobante en el punto de reciclaje para validación física.</div>
        <div style="margin-top:6px;">
            GreenPoints &copy; {{ date('Y') }} —
            Emitido el {{ now()->format('d/m/Y \a \l\a\s H:i') }}
        </div>
    </div>

</div>

</body>
</html>
