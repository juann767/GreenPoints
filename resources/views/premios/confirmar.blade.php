@extends('layouts.app')
@section('title', 'Confirmar Canje')

@section('content')

<div class="gp-card" style="max-width:480px;margin:0 auto;text-align:center;">
    <div style="font-size:3rem;">🎁</div>
    <h4 class="fw-bold mt-2 mb-1" style="color:var(--gp-green-dark);">Confirmar canje</h4>

    <p style="color:var(--gp-muted);font-size:.9rem;">
        Estás por canjear el siguiente premio:
    </p>

    <div class="p-3 rounded-3 mb-4" style="background:#e8f5e9;border:1px solid var(--gp-border);">
        <div class="fw-bold fs-5">{{ $premio->nombre }}</div>
        <div style="font-size:.85rem;color:var(--gp-muted);">{{ $premio->descripcion }}</div>
        <div class="mt-2">
            <span class="badge" style="background:var(--gp-green);font-size:1rem;">
                {{ $premio->puntos_necesarios }} puntos
            </span>
        </div>
    </div>

    <div class="mb-4" style="font-size:.9rem;color:var(--gp-muted);">
        Tus puntos disponibles: <strong style="color:var(--gp-green-dark);">{{ $puntosDisponibles }}</strong>
    </div>

    <form method="POST" action="{{ route('premios.canjear', $premio->id) }}">
        @csrf
        <div class="d-flex gap-2 justify-content-center">
            <button type="submit" class="btn btn-gp">
                <i class="bi bi-check-circle me-1"></i> Confirmar canje
            </button>
            <a href="{{ route('premios.index') }}" class="btn btn-gp-outline">Cancelar</a>
        </div>
    </form>
</div>

@endsection
