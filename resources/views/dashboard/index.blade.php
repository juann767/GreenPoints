@extends('layouts.app')
@section('title','Dashboard')

@section('content')

<div class="mb-3 d-flex align-items-center justify-content-between">
    <div>
        <h4 style="color:var(--gp-text);font-weight:700;margin:0;">¡Hola, {{ Auth::user()->nombre }}! 👋</h4>
        <p style="color:var(--gp-muted);font-size:.85rem;margin:2px 0 0;">Panel de datos de tu actividad ecológica.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('reciclaje.create') }}" class="btn-gp" style="font-size:.85rem;padding:7px 14px;">
            <i class="bi bi-plus-circle me-1"></i> Registrar reciclaje
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="gp-card">
            <div class="gp-card-title"><i class="bi bi-star-fill"></i> Puntos</div>
            <div class="gp-stat-val">{{ $user->puntos }}</div>
            <div class="gp-stat-lbl">acumulados</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="gp-card">
            <div class="gp-card-title"><i class="bi bi-recycle"></i> Reciclajes</div>
            <div class="gp-stat-val">{{ $totalRegistros }}</div>
            <div class="gp-stat-lbl">registrados</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="gp-card">
            <div class="gp-card-title"><i class="bi bi-cloud"></i> CO₂ reducido</div>
            <div class="gp-stat-val" style="font-size:1.5rem;">{{ $co2Reducido }} kg</div>
            <div class="gp-stat-lbl">estimado</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="gp-card">
            <div class="gp-card-title"><i class="bi bi-tree"></i> Árboles equiv.</div>
            <div class="gp-stat-val" style="font-size:1.5rem;">{{ $arboles }}</div>
            <div class="gp-stat-lbl">equivalentes salvados</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    {{-- Gráfico de dona — materiales --}}
    <div class="col-md-5">
        <div class="gp-card h-100">
            <div class="gp-card-title"><i class="bi bi-pie-chart-fill"></i> Materiales reciclados</div>
            @if($materialesDona->isEmpty())
                <p style="color:var(--gp-muted);font-size:.85rem;text-align:center;padding:32px 0;">
                    Aún no has registrado acciones.
                </p>
            @else
                <canvas id="donaChart" height="200"></canvas>
                <div id="dona-legend" style="margin-top:12px;display:flex;flex-wrap:wrap;gap:8px;"></div>
            @endif
        </div>
    </div>

    {{-- Gráfico de barras — actividad mensual --}}
    <div class="col-md-7">
        <div class="gp-card h-100">
            <div class="gp-card-title"><i class="bi bi-bar-chart-fill"></i> Actividad últimos 6 meses</div>
            <canvas id="barChart" height="180"></canvas>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Últimos reciclajes --}}
    <div class="col-md-7">
        <div class="gp-card">
            <div class="gp-card-title"><i class="bi bi-clock-history"></i> Últimas acciones</div>

            @forelse($ultimosRegistros as $r)
                <div class="d-flex align-items-center justify-content-between py-2"
                     style="border-bottom:1px solid var(--gp-border);">
                    <div>
                        <div style="font-weight:600;font-size:.9rem;">{{ $r->accion->nombre }}</div>
                        <div style="font-size:.76rem;color:var(--gp-muted);">
                            {{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }}
                            @if($r->cantidad_kg) · {{ $r->cantidad_kg }} kg @endif
                        </div>
                    </div>
                    <span style="background:rgba(74,222,128,.15);color:#4ade80;border-radius:20px;padding:3px 12px;font-size:.8rem;font-weight:700;">
                        +{{ $r->accion->puntos_otorgados }} pts
                    </span>
                </div>
            @empty
                <p style="color:var(--gp-muted);font-size:.88rem;margin-top:8px;">
                    Aún no has registrado ninguna acción.
                    <a href="{{ route('reciclaje.create') }}" style="color:#4ade80;">¡Comienza aquí!</a>
                </p>
            @endforelse

            <div class="mt-3">
                <a href="{{ route('reciclaje.index') }}" class="btn-gp-ghost" style="font-size:.82rem;">Ver todos →</a>
            </div>
        </div>
    </div>

    {{-- Nivel y acciones rápidas --}}
    <div class="col-md-5">
        <div class="gp-card mb-3">
            <div class="gp-card-title"><i class="bi bi-bar-chart-fill"></i> Nivel actual</div>
            @php
                $siguiente = $user->puntos < 200 ? 200 : ($user->puntos < 500 ? 500 : 1000);
                $pct = min(100, round($user->puntos / $siguiente * 100));
                $nivel = $user->puntos >= 500 ? '🌳 Sembrador' : ($user->puntos >= 200 ? '🌿 Guardabosques' : '🌱 Principiante');
            @endphp
            <div style="font-size:.95rem;font-weight:600;color:var(--gp-accent);margin-bottom:8px;">{{ $nivel }}</div>
            <div style="background:var(--gp-bg);border-radius:10px;height:8px;overflow:hidden;">
                <div style="background:var(--gp-green);height:100%;width:{{ $pct }}%;border-radius:10px;transition:width .6s;"></div>
            </div>
            <div style="font-size:.75rem;color:var(--gp-muted);margin-top:5px;">
                {{ $user->puntos }} / {{ $siguiente }} pts para el siguiente nivel
            </div>
        </div>

        <div class="gp-card">
            <div class="gp-card-title"><i class="bi bi-lightning-charge-fill"></i> Acciones rápidas</div>
            <div class="d-flex flex-column gap-2 mt-1">
                <a href="{{ route('reciclaje.create') }}" class="btn-gp" style="text-align:center;font-size:.88rem;">
                    <i class="bi bi-recycle me-1"></i> Registrar reciclaje
                </a>
                <a href="{{ route('premios.index') }}" class="btn-gp-ghost" style="text-align:center;font-size:.88rem;">
                    <i class="bi bi-gift me-1"></i> Ver premios ({{ $user->puntos }} pts)
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
// ── Gráfico de dona ──────────────────────────────────
@if(!$materialesDona->isEmpty())
const donaLabels  = @json($materialesDona->pluck('material'));
const donaData    = @json($materialesDona->pluck('total'));
const donaColors  = ['#4ade80','#22d3ee','#fbbf24','#f87171','#a78bfa','#fb923c'];

const donaCtx = document.getElementById('donaChart').getContext('2d');
new Chart(donaCtx, {
    type: 'doughnut',
    data: {
        labels: donaLabels,
        datasets: [{
            data: donaData,
            backgroundColor: donaColors.slice(0, donaData.length),
            borderWidth: 0,
            hoverOffset: 6,
        }]
    },
    options: {
        cutout: '65%',
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.label}: ${ctx.raw} registros`
                }
            }
        }
    }
});

// Leyenda manual
const legend = document.getElementById('dona-legend');
donaLabels.forEach((l, i) => {
    legend.innerHTML += `<div style="display:flex;align-items:center;gap:5px;font-size:.75rem;color:var(--gp-muted);">
        <div style="width:10px;height:10px;border-radius:50%;background:${donaColors[i]};flex-shrink:0;"></div>${l}
    </div>`;
});
@endif

// ── Gráfico de barras ────────────────────────────────
const barLabels = @json(collect($actividadMensual)->pluck('mes'));
const barData   = @json(collect($actividadMensual)->pluck('total'));

const barCtx = document.getElementById('barChart').getContext('2d');
new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: barLabels,
        datasets: [{
            label: 'Reciclajes',
            data: barData,
            backgroundColor: 'rgba(27,138,62,.7)',
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
        },
        scales: {
            x: { ticks: { color: '#7aaa88', font: { size: 11 } }, grid: { color: 'rgba(255,255,255,.04)' } },
            y: { ticks: { color: '#7aaa88', font: { size: 11 }, stepSize: 1 }, grid: { color: 'rgba(255,255,255,.06)' }, beginAtZero: true }
        }
    }
});
</script>
@endpush

@endsection
