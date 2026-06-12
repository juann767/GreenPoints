@extends('layouts.app')
@section('title','Premios')

@section('content')
@php
    $imagenes = [
        1 => '/Imagenes/kit_siembra.jpeg',
        2 => '/Imagenes/bolsa_reutilizable.jpeg',
        3 => '/Imagenes/botella_reutilizable.png',
        4 => '/Imagenes/libro_ambiental.png',
        5 => '/Imagenes/certificado_eco.png',
    
    ];
@endphp

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="color:var(--gp-text);font-weight:700;margin:0;">Catálogo de premios</h4>
        <p style="color:var(--gp-muted);font-size:.85rem;margin:4px 0 0;">
            Canjea tus puntos por recompensas ecológicas.
        </p>
    </div>

    <div style="background:rgba(74,222,128,.1);border:1px solid rgba(74,222,128,.25);border-radius:10px;padding:8px 18px;text-align:right;">
        <div style="font-size:.72rem;color:var(--gp-muted);">Tus puntos</div>
        <div style="font-size:1.4rem;font-weight:800;color:#4ade80;line-height:1;">
            {{ $user->puntos }}
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    @forelse($premios as $p)

       @php
    $imagen = $imagenes[$p->id] ?? '/Imagenes/bolsa_reutilizable.jpeg';
@endphp

        <div class="col-sm-6 col-lg-4">
            <div class="gp-card h-100 d-flex flex-column">

                <div style="text-align:center;padding:0;margin-bottom:14px;">
                    <img
                        src="{{ $imagen }}"
                        alt="{{ $p->nombre }}"
                        style="
                            width:100%;
                            height:200px;
                            object-fit:cover;
                            border-radius:10px;
                            display:block;
                        ">
                </div>

                <div style="font-weight:700;font-size:.95rem;margin-bottom:4px;">
                    {{ $p->nombre }}
                </div>

                <div style="font-size:.82rem;color:var(--gp-muted);flex:1;line-height:1.5;">
                    {{ $p->descripcion }}
                </div>

                <div class="d-flex align-items-center justify-content-between mt-3">
                    <div>
                        <span style="color:#4ade80;font-weight:700;font-size:.95rem;">
                            {{ $p->puntos_requeridos }} pts
                        </span>

                        <span style="color:var(--gp-muted);font-size:.75rem;margin-left:6px;">
                            Stock: {{ $p->stock }}
                        </span>
                    </div>

                    @if($user->puntos >= $p->puntos_requeridos && $p->stock > 0)
                        <form method="POST"
                              action="{{ route('premios.canjear', $p->id) }}"
                              onsubmit="return confirm('¿Canjear «{{ $p->nombre }}» por {{ $p->puntos_requeridos }} puntos?')">
                            @csrf

                            <button type="submit"
                                    class="btn-gp"
                                    style="font-size:.82rem;padding:6px 14px;">
                                Canjear
                            </button>
                        </form>
                    @else
                        <button class="btn-gp-ghost"
                                style="font-size:.82rem;padding:6px 14px;opacity:.5;"
                                disabled>
                            {{ $p->stock <= 0 ? 'Sin stock' : 'Sin puntos' }}
                        </button>
                    @endif
                </div>

            </div>
        </div>

    @empty
        <div class="col-12">
            <div class="gp-card text-center py-4" style="color:var(--gp-muted);">
                No hay premios disponibles.
            </div>
        </div>
    @endforelse
</div>

{{-- Historial de canjes --}}
<div class="gp-card">
    <div class="gp-card-title">
        <i class="bi bi-clock-history"></i> Historial de canjes
    </div>

    @if($canjes->isEmpty())
        <p style="color:var(--gp-muted);font-size:.88rem;margin-top:8px;">
            No has canjeado ningún premio aún.
        </p>
    @else
        <table class="gp-table">
            <thead>
                <tr>
                    <th>Premio</th>
                    <th>Puntos usados</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($canjes as $c)
                    <tr>
                        <td style="font-weight:600;">
                            {{ $c->premio->nombre }}
                        </td>

                        <td style="color:#f87171;font-weight:700;">
                            -{{ $c->premio->puntos_requeridos }} pts
                        </td>

                        <td style="color:var(--gp-muted);font-size:.85rem;">
                            {{ \Carbon\Carbon::parse($c->fecha_canje)->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection