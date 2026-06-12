@extends('layouts.app')
@section('title','Gestión de Usuarios')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="color:var(--gp-text);font-weight:700;margin:0;">Usuarios registrados</h4>
        <p style="color:var(--gp-muted);font-size:.85rem;margin:4px 0 0;">Lista de todos los usuarios del sistema.</p>
    </div>
    <a href="{{ route('admin.index') }}" class="btn-gp-ghost">← Volver al panel</a>
</div>

<div class="gp-card">
    <table class="gp-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Puntos</th>
                <th>Registrado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $u)
                <tr>
                    <td style="color:var(--gp-muted);font-size:.82rem;">{{ $u->id }}</td>
                    <td style="font-weight:600;">{{ $u->nombre }}</td>
                    <td style="color:var(--gp-muted);font-size:.85rem;">{{ $u->email }}</td>
                    <td>
                        <span class="badge-{{ $u->role?->nombre ?? 'usuario' }}">
                            {{ ucfirst($u->role?->nombre ?? 'usuario') }}
                        </span>
                    </td>
                    <td style="color:var(--gp-accent);font-weight:700;">{{ $u->puntos }}</td>
                    <td style="color:var(--gp-muted);font-size:.82rem;">{{ $u->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;color:var(--gp-muted);padding:32px;">Sin usuarios registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
