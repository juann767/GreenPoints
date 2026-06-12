@extends('layouts.app')
@section('title', 'Registrar Reciclaje')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold" style="color:var(--gp-green-dark);">
        <i class="bi bi-recycle me-2"></i>Registrar Reciclaje
    </h3>
    <p style="color:var(--gp-muted);">Ingresa el código de tu dispositivo y completa el formulario para ganar puntos.</p>
</div>

<div class="gp-card" style="max-width:620px;">

    <div class="wip-banner">
        <i class="bi bi-envelope"></i>
        <span><strong>Pendiente:</strong> Envío de código de canje por correo aún no implementado.</span>
    </div>

    <form method="POST" action="{{ route('reciclaje.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Código del dispositivo --}}
        <div class="mb-4 p-3 rounded-3" style="background:#e8f5e9;border:1px solid #c8e6c9;">
            <label class="form-label fw-bold" style="color:var(--gp-green-dark);">
                🔑 Código del dispositivo
            </label>
            <input type="text" name="codigo_dispositivo"
                   class="form-control form-control-lg @error('codigo_dispositivo') is-invalid @enderror"
                   value="{{ old('codigo_dispositivo') }}"
                   placeholder="Ej. A3F7B2C1D9" style="text-transform:uppercase;letter-spacing:.1em;" required>
            <div class="form-text">El código fue enviado al correo al registrar el dispositivo.</div>
            @error('codigo_dispositivo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <hr class="my-3">
        <p class="fw-semibold mb-3" style="color:var(--gp-green-dark);">Datos personales</p>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nombre</label>
                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre') }}" required>
                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Apellido</label>
                <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                       value="{{ old('apellido') }}" required>
                @error('apellido')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Correo</label>
                <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror"
                       value="{{ old('correo') }}" required>
                @error('correo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Teléfono</label>
                <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                       value="{{ old('telefono') }}" required>
                @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <hr class="my-3">
        <p class="fw-semibold mb-3" style="color:var(--gp-green-dark);">Material reciclado</p>

        <div class="mb-3">
            <label class="form-label fw-semibold">Tipo de material</label>
            <select name="tipo_material" class="form-select @error('tipo_material') is-invalid @enderror" required>
                <option value="">— Selecciona —</option>
                <option value="Plástico"   {{ old('tipo_material') === 'Plástico'   ? 'selected' : '' }}>♻️ Plástico</option>
                <option value="Papel"      {{ old('tipo_material') === 'Papel'      ? 'selected' : '' }}>📄 Papel / Cartón</option>
                <option value="Vidrio"     {{ old('tipo_material') === 'Vidrio'     ? 'selected' : '' }}>🍶 Vidrio</option>
                <option value="Metal"      {{ old('tipo_material') === 'Metal'      ? 'selected' : '' }}>🔩 Metal</option>
                <option value="Electrónico"{{ old('tipo_material') === 'Electrónico'? 'selected' : '' }}>💻 Electrónico</option>
                <option value="Orgánico"   {{ old('tipo_material') === 'Orgánico'   ? 'selected' : '' }}>🌿 Orgánico</option>
            </select>
            @error('tipo_material')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Peso (kg) <span class="text-muted fw-normal">(opcional)</span></label>
                <input type="number" name="peso_kg" class="form-control" step="0.01" min="0"
                       value="{{ old('peso_kg') }}" placeholder="0.00">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Cantidad <span class="text-muted fw-normal">(opcional)</span></label>
                <input type="number" name="cantidad" class="form-control" step="0.01" min="0"
                       value="{{ old('cantidad') }}" placeholder="0">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Foto / Evidencia <span class="text-muted fw-normal">(opcional)</span></label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-gp">
                <i class="bi bi-check2-circle me-1"></i> Registrar reciclaje
            </button>
            <a href="{{ route('inicio') }}" class="btn btn-gp-outline">Cancelar</a>
        </div>
    </form>
</div>

@endsection
