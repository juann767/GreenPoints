@extends('layouts.app')
@section('title', 'Registrar Dispositivo')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold" style="color:var(--gp-green-dark);">
        <i class="bi bi-cpu me-2"></i>Registrar Dispositivo
    </h3>
    <p style="color:var(--gp-muted);">Registra un nuevo punto de reciclaje. Se generará un código único que se enviará al correo indicado.</p>
</div>

<div class="gp-card" style="max-width:580px;">

    {{-- TODO: Correo automático pendiente de configurar (Mailable Laravel) --}}
    <div class="wip-banner">
        <i class="bi bi-envelope"></i>
        <span><strong>Pendiente:</strong> El envío de correo automático aún no está configurado en esta versión.</span>
    </div>

    <form method="POST" action="{{ route('dispositivo.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Nombre del dispositivo</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                   value="{{ old('nombre') }}" placeholder="Ej. Contenedor Parque Central" required>
            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Ubicación</label>
            <input type="text" name="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror"
                   value="{{ old('ubicacion') }}" placeholder="Ej. San Salvador, zona 1" required>
            @error('ubicacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Dirección completa</label>
            <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror"
                   value="{{ old('direccion') }}" placeholder="Calle, colonia, número..." required>
            @error('direccion')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Correo para recibir el código</label>
            <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror"
                   value="{{ old('correo') }}" placeholder="responsable@correo.com" required>
            @error('correo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-gp">
                <i class="bi bi-send me-1"></i> Registrar dispositivo
            </button>
            <a href="{{ route('inicio') }}" class="btn btn-gp-outline">Cancelar</a>
        </div>
    </form>
</div>

@endsection
