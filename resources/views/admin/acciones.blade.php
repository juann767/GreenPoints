@extends('layouts.app')
@section('title','Gestión de Acciones Ecológicas')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="color:var(--gp-text);font-weight:700;margin:0;">Acciones ecológicas</h4>
        <p style="color:var(--gp-muted);font-size:.85rem;margin:4px 0 0;">Gestiona los tipos de material reciclable y sus puntos.</p>
    </div>
    <a href="{{ route('admin.acciones.create') }}" class="btn-gp">
        <i class="bi bi-plus-circle me-1"></i> Nueva acción
    </a>
</div>

<div class="gp-card">
    <table class="gp-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Puntos otorgados</th>
                <th>Usos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($acciones as $a)
                <tr>
                    <td style="font-weight:600;">{{ $a->nombre }}</td>
                    <td style="color:var(--gp-muted);font-size:.85rem;">{{ Str::limit($a->descripcion, 55) }}</td>
                    <td><span style="color:#4ade80;font-weight:700;">+{{ $a->puntos_otorgados }} pts</span></td>
                    <td style="color:var(--gp-muted);">{{ $a->registros->count() }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.acciones.edit', $a->id) }}" class="btn-warning-gp" style="font-size:.8rem;padding:5px 12px;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.acciones.destroy', $a->id) }}"
                                  onsubmit="return confirm('¿Eliminar esta acción?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger-gp" style="font-size:.8rem;padding:5px 12px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;color:var(--gp-muted);padding:32px;">Sin acciones registradas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
