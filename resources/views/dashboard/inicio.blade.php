@extends('layouts.app')
@section('title', 'Inicio')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold mb-1" style="color:var(--gp-green-dark);">
        ¡Hola, {{ Auth::user()->name }}! 👋
    </h2>
    <p style="color:var(--gp-muted);">Aquí tienes un resumen de tu actividad en GreenPoints.</p>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="gp-stat">
            <div class="value">{{ $puntosDisponibles }}</div>
            <div class="label">Puntos disponibles</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="gp-stat" style="background:linear-gradient(135deg,#1565c0,#1976d2);">
            <div class="value">{{ $puntosTotal }}</div>
            <div class="label">Puntos totales</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="gp-stat" style="background:linear-gradient(135deg,#6a1b9a,#7b1fa2);">
            <div class="value">{{ $totalReciclajes }}</div>
            <div class="label">Reciclajes</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="gp-stat" style="background:linear-gradient(135deg,#e65100,#ef6c00);">
            <div class="value">{{ $puntosGastados }}</div>
            <div class="label">Puntos usados</div>
        </div>
    </div>
</div>

{{-- Acciones rápidas --}}
<div class="gp-card mb-4">
    <h5 class="fw-bold mb-3" style="color:var(--gp-green-dark);">
        <i class="bi bi-lightning-charge-fill me-1"></i> Acciones rápidas
    </h5>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('dispositivo.create') }}" class="btn btn-gp">
            <i class="bi bi-cpu me-1"></i> Registrar dispositivo
        </a>
        <a href="{{ route('reciclaje.create') }}" class="btn btn-gp">
            <i class="bi bi-recycle me-1"></i> Registrar reciclaje
        </a>
        <a href="{{ route('premios.index') }}" class="btn-gp-outline btn">
            <i class="bi bi-gift me-1"></i> Ver premios
        </a>
    </div>
</div>

{{-- Últimos reciclajes --}}
<div class="gp-card">
    <h5 class="fw-bold mb-3" style="color:var(--gp-green-dark);">
        <i class="bi bi-clock-history me-1"></i> Últimos reciclajes
    </h5>

    @forelse($ultimosReciclajes as $r)
        <div class="d-flex align-items-center justify-content-between py-2"
             style="border-bottom: 1px dashed var(--gp-border);">
            <div>
                <div class="fw-semibold">{{ $r->tipo_material }}</div>
                <div style="font-size:.8rem;color:var(--gp-muted);">
                    {{ $r->created_at->diffForHumans() }}
                    @if($r->peso_kg) · {{ $r->peso_kg }} kg @endif
                </div>
            </div>
            <span class="badge" style="background:var(--gp-green);font-size:.85rem;">
                +{{ $r->puntos }} pts
            </span>
        </div>
    @empty
        <p style="color:var(--gp-muted);font-size:.9rem;">
            Aún no has registrado ningún reciclaje.
            <a href="{{ route('reciclaje.create') }}">¡Comienza aquí!</a>
        </p>
    @endforelse

    @if($ultimosReciclajes->isNotEmpty())
        <div class="mt-3">
            <a href="{{ route('actividad') }}" class="btn-gp-outline btn btn-sm">
                Ver toda la actividad →
            </a>
        </div>
    @endif
</div>

@endsection
