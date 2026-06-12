@extends('layouts.app')
@section('title','Panel de Administración')

@section('content')

<div class="mb-4">
    <h4 style="color:var(--gp-text);font-weight:700;margin:0;">Panel de Administración</h4>
    <p style="color:var(--gp-muted);font-size:.85rem;margin:4px 0 0;">Estadísticas globales del sistema GreenPoints.</p>
</div>

{{-- Stats globales --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="gp-card">
            <div class="gp-card-title"><i class="bi bi-people-fill"></i> Usuarios</div>
            <div class="gp-stat-val">{{ $totalUsuarios }}</div>
            <div class="gp-stat-lbl">registrados</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="gp-card">
            <div class="gp-card-title"><i class="bi bi-recycle"></i> Acciones</div>
            <div class="gp-stat-val">{{ $totalAcciones }}</div>
            <div class="gp-stat-lbl">registradas en total</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="gp-card">
            <div class="gp-card-title"><i class="bi bi-gift"></i> Canjes</div>
            <div class="gp-stat-val">{{ $totalCanjes }}</div>
            <div class="gp-stat-lbl">premios canjeados</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="gp-card">
            <div class="gp-card-title"><i class="bi bi-cpu"></i> Dispositivos</div>
            <div class="gp-stat-val">{{ $dispositivosActivos }}</div>
            <div class="gp-stat-lbl">activos</div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Últimos usuarios --}}
    <div class="col-md-6">
        <div class="gp-card">
            <div class="gp-card-title"><i class="bi bi-person-lines-fill"></i> Últimos usuarios registrados</div>

            @forelse($ultimosUsuarios as $u)
                <div class="d-flex align-items-center justify-content-between py-2"
                     style="border-bottom:1px solid var(--gp-border);">
                    <div>
                        <div style="font-weight:600;font-size:.9rem;">{{ $u->nombre }}</div>
                        <div style="font-size:.75rem;color:var(--gp-muted);">{{ $u->email }}</div>
                    </div>
                    <span style="background:rgba(74,222,128,.15);color:#4ade80;border-radius:20px;padding:3px 12px;font-size:.8rem;font-weight:700;">
                        {{ $u->puntos }} pts
                    </span>
                </div>
            @empty
                <p style="color:var(--gp-muted);font-size:.88rem;">Sin usuarios registrados.</p>
            @endforelse

            <div class="mt-3">
                <a href="{{ route('admin.usuarios') }}" class="btn-gp-ghost" style="font-size:.82rem;">Ver todos →</a>
            </div>
        </div>
    </div>

    {{-- Materiales más reciclados --}}
    <div class="col-md-6">
        <div class="gp-card">
            <div class="gp-card-title"><i class="bi bi-bar-chart-fill"></i> Materiales más reciclados</div>

            @forelse($materiales as $m)
                @php $max = $materiales->max('total_registros'); @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:.85rem;font-weight:500;">{{ $m->nombre }}</span>
                        <span style="font-size:.8rem;color:var(--gp-muted);">
                            {{ $m->total_registros }} registros
                            @if($m->total_kg) · {{ number_format($m->total_kg, 1) }} kg @endif
                        </span>
                    </div>
                    <div style="background:var(--gp-bg);border-radius:6px;height:7px;overflow:hidden;">
                        <div style="background:var(--gp-green);height:100%;width:{{ $max > 0 ? round($m->total_registros / $max * 100) : 0 }}%;border-radius:6px;"></div>
                    </div>
                </div>
            @empty
                <p style="color:var(--gp-muted);font-size:.88rem;">Sin datos de reciclaje aún.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Accesos rápidos admin --}}
<div class="row g-3 mt-1">
    <div class="col-12">
        <div class="gp-card">
            <div class="gp-card-title"><i class="bi bi-lightning-charge-fill"></i> Gestión rápida</div>
            <div class="d-flex flex-wrap gap-2 mt-1">
                <a href="{{ route('admin.premios.create') }}" class="btn-gp"><i class="bi bi-plus-circle me-1"></i> Nuevo premio</a>
                <a href="{{ route('admin.acciones.create') }}" class="btn-gp"><i class="bi bi-plus-circle me-1"></i> Nueva acción ecológica</a>
                <a href="{{ route('admin.premios') }}" class="btn-gp-ghost"><i class="bi bi-tag me-1"></i> Gestionar premios</a>
                <a href="{{ route('admin.acciones') }}" class="btn-gp-ghost"><i class="bi bi-leaf me-1"></i> Gestionar acciones</a>
                <a href="{{ route('dispositivos.create') }}" class="btn-gp-ghost"><i class="bi bi-cpu me-1"></i> Nuevo dispositivo</a>
            </div>
        </div>
    </div>
</div>

@endsection
