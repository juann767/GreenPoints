@extends('layouts.app')
@section('title','Dispositivos')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="color:var(--gp-text);font-weight:700;margin:0;">Puntos ecológicos</h4>
        <p style="color:var(--gp-muted);font-size:.85rem;margin:4px 0 0;">Dispositivos de reciclaje registrados en la plataforma.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('mapa.index') }}" class="btn-gp-ghost">
            <i class="bi bi-map me-1"></i> Ver mapa
        </a>
        <a href="{{ route('dispositivos.create') }}" class="btn-gp">
            <i class="bi bi-plus-circle me-1"></i> Registrar
        </a>
    </div>
</div>

<div class="row g-3">
    @forelse($dispositivos as $d)
        <div class="col-md-6 col-lg-4">
            <div class="gp-card h-100">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div style="font-size:1.3rem;">♻️</div>
                    <span class="badge-{{ $d->estado }}">{{ ucfirst($d->estado) }}</span>
                </div>
                <div style="font-weight:700;font-size:.95rem;margin-bottom:4px;">{{ $d->nombre }}</div>
                <div style="font-size:.82rem;color:var(--gp-muted);margin-bottom:6px;">
                    <i class="bi bi-geo-alt me-1"></i>{{ $d->ubicacion }}
                </div>
                @if($d->descripcion)
                    <div style="font-size:.8rem;color:var(--gp-muted);margin-bottom:10px;">{{ $d->descripcion }}</div>
                @endif

                {{-- Coordenadas --}}
                @if($d->tieneCoordenadas())
                    <div style="font-size:.75rem;color:var(--gp-accent);margin-bottom:10px;font-family:monospace;">
                        <i class="bi bi-pin-map me-1"></i>
                        {{ number_format($d->latitud, 4) }}, {{ number_format($d->longitud, 4) }}
                    </div>
                @else
                    <div style="font-size:.75rem;color:var(--gp-muted);margin-bottom:10px;opacity:.6;">
                        <i class="bi bi-pin-map me-1"></i> Sin coordenadas
                    </div>
                @endif

                <div class="d-flex gap-2 mt-auto flex-wrap">
                    @if($d->tieneCoordenadas())
                        <a href="{{ route('mapa.index') }}" class="btn-gp-ghost" style="font-size:.78rem;padding:5px 10px;">
                            <i class="bi bi-map"></i> Ver en mapa
                        </a>
                    @endif
                    <a href="{{ route('dispositivos.edit', $d->id) }}" class="btn-warning-gp" style="font-size:.78rem;padding:5px 10px;">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('dispositivos.destroy', $d->id) }}"
                          onsubmit="return confirm('¿Eliminar este dispositivo?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger-gp" style="font-size:.78rem;padding:5px 10px;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="gp-card text-center py-4" style="color:var(--gp-muted);">
                No hay dispositivos registrados.
                <a href="{{ route('dispositivos.create') }}" style="color:#4ade80;">Registra el primero.</a>
            </div>
        </div>
    @endforelse
</div>

@endsection
