@extends('layouts.app')
@section('title', 'Actividad Reciente')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold" style="color:var(--gp-green-dark);">
        <i class="bi bi-clock-history me-2"></i>Actividad reciente
    </h3>
</div>

<div class="row g-3">
    {{-- Reciclajes --}}
    <div class="col-md-6">
        <div class="gp-card h-100">
            <h6 class="fw-bold mb-3" style="color:var(--gp-green-dark);">
                <i class="bi bi-recycle me-1"></i> Mis reciclajes
            </h6>

            @forelse($reciclajes as $r)
                <div class="d-flex align-items-start gap-3 py-2"
                     style="border-bottom:1px dashed var(--gp-border);">
                    <div style="width:36px;height:36px;background:#e8f5e9;border-radius:8px;
                                display:flex;align-items:center;justify-content:center;font-size:1.2rem;">
                        ♻️
                    </div>
                    <div style="flex:1;">
                        <div class="fw-semibold" style="font-size:.9rem;">{{ $r->tipo_material }}</div>
                        <div style="font-size:.78rem;color:var(--gp-muted);">
                            {{ $r->created_at->format('d/m/Y H:i') }}
                            @if($r->peso_kg) · {{ $r->peso_kg }} kg @endif
                        </div>
                        <div style="font-size:.78rem;color:var(--gp-muted);">
                            Código: <code>{{ $r->codigo_canje }}</code>
                        </div>
                    </div>
                    <span class="badge" style="background:var(--gp-green);">+{{ $r->puntos }} pts</span>
                </div>
            @empty
                <p style="color:var(--gp-muted);font-size:.88rem;">Sin reciclajes aún.</p>
            @endforelse
        </div>
    </div>

    {{-- Canjes --}}
    <div class="col-md-6">
        <div class="gp-card h-100">
            <h6 class="fw-bold mb-3" style="color:var(--gp-green-dark);">
                <i class="bi bi-gift me-1"></i> Mis canjes
            </h6>

            @forelse($canjes as $c)
                <div class="d-flex align-items-start gap-3 py-2"
                     style="border-bottom:1px dashed var(--gp-border);">
                    <div style="width:36px;height:36px;background:#fff3e0;border-radius:8px;
                                display:flex;align-items:center;justify-content:center;font-size:1.2rem;">
                        🎁
                    </div>
                    <div style="flex:1;">
                        <div class="fw-semibold" style="font-size:.9rem;">{{ $c->premio->nombre }}</div>
                        <div style="font-size:.78rem;color:var(--gp-muted);">
                            {{ $c->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <span class="badge bg-warning text-dark">-{{ $c->puntos_usados }} pts</span>
                </div>
            @empty
                <p style="color:var(--gp-muted);font-size:.88rem;">No has canjeado premios aún.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection
