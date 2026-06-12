@extends('layouts.app')
@section('title','Mis Reciclajes')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="color:var(--gp-text);font-weight:700;margin:0;">Mis acciones ecológicas</h4>
        <p style="color:var(--gp-muted);font-size:.85rem;margin:4px 0 0;">Historial de reciclajes. Descarga tu comprobante QR en cualquier registro.</p>
    </div>
    <a href="{{ route('reciclaje.create') }}" class="btn-gp">
        <i class="bi bi-plus-circle me-1"></i> Nueva acción
    </a>
</div>

<div class="gp-card">
    @if($registros->isEmpty())
        <p style="color:var(--gp-muted);text-align:center;padding:32px 0;">
            No has registrado ninguna acción aún.
            <a href="{{ route('reciclaje.create') }}" style="color:#4ade80;">¡Registra tu primera acción!</a>
        </p>
    @else
        <table class="gp-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Acción ecológica</th>
                    <th>Dispositivo</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Puntos</th>
                    <th>Comprobante</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($registros as $r)
                    <tr>
                        <td style="color:var(--gp-muted);font-size:.78rem;font-family:monospace;">
                            GP-{{ str_pad($r->id, 6, '0', STR_PAD_LEFT) }}
                        </td>
                        <td style="font-weight:600;">{{ $r->accion->nombre }}</td>
                        <td style="color:var(--gp-muted);font-size:.83rem;">{{ $r->dispositivo?->nombre ?? '—' }}</td>
                        <td style="color:var(--gp-muted);">{{ $r->cantidad_kg ? $r->cantidad_kg . ' kg' : '—' }}</td>
                        <td style="color:var(--gp-muted);font-size:.83rem;">
                            {{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }}
                        </td>
                        <td>
                            <span style="color:#4ade80;font-weight:700;">+{{ $r->accion->puntos_otorgados }}</span>
                        </td>
                        <td>
                            {{-- Botón comprobante QR --}}
                            <a href="{{ route('comprobante.show', $r->id) }}"
                               target="_blank"
                               style="display:inline-flex;align-items:center;gap:5px;background:rgba(74,222,128,.1);border:1px solid rgba(74,222,128,.3);color:#4ade80;border-radius:7px;padding:4px 11px;font-size:.78rem;font-weight:600;text-decoration:none;transition:background .18s;"
                               onmouseover="this.style.background='rgba(74,222,128,.2)'"
                               onmouseout="this.style.background='rgba(74,222,128,.1)'">
                                <i class="bi bi-qr-code"></i> QR
                            </a>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('reciclaje.destroy', $r->id) }}"
                                  onsubmit="return confirm('¿Eliminar este registro?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        style="background:none;border:none;color:#f87171;cursor:pointer;font-size:.85rem;padding:4px 8px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
