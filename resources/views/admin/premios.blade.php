@extends('layouts.app')
@section('title','Gestión de Premios')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="color:var(--gp-text);font-weight:700;margin:0;">Gestión de premios</h4>
        <p style="color:var(--gp-muted);font-size:.85rem;margin:4px 0 0;">Agrega, edita o elimina premios del catálogo.</p>
    </div>
    <a href="{{ route('admin.premios.create') }}" class="btn-gp">
        <i class="bi bi-plus-circle me-1"></i> Nuevo premio
    </a>
</div>

<div class="gp-card">
    <table class="gp-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Puntos requeridos</th>
                <th>Stock</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($premios as $p)
                <tr>
                    <td style="font-weight:600;">{{ $p->nombre }}</td>
                    <td style="color:var(--gp-muted);font-size:.85rem;">{{ Str::limit($p->descripcion, 50) }}</td>
                    <td style="color:var(--gp-accent);font-weight:700;">{{ $p->puntos_requeridos }} pts</td>
                    <td style="color:var(--gp-muted);">{{ $p->stock }}</td>
                    <td>
                        @if($p->activo)
                            <span class="badge-activo">Activo</span>
                        @else
                            <span class="badge-inactivo">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.premios.edit', $p->id) }}" class="btn-warning-gp" style="font-size:.8rem;padding:5px 12px;">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.premios.destroy', $p->id) }}"
                                  onsubmit="return confirm('¿Eliminar este premio?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger-gp" style="font-size:.8rem;padding:5px 12px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;color:var(--gp-muted);padding:32px;">No hay premios registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
