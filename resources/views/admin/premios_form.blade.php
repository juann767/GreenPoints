@extends('layouts.app')
@section('title', $premio ? 'Editar Premio' : 'Nuevo Premio')

@section('content')

<div class="mb-4">
    <h4 style="color:var(--gp-text);font-weight:700;margin:0;">
        {{ $premio ? 'Editar premio' : 'Crear nuevo premio' }}
    </h4>
    <p style="color:var(--gp-muted);font-size:.85rem;margin:4px 0 0;">
        {{ $premio ? 'Modifica la información del premio.' : 'Agrega un nuevo premio al catálogo.' }}
    </p>
</div>

<div class="gp-card" style="max-width:560px;">
    <form method="POST"
          action="{{ $premio ? route('admin.premios.update', $premio->id) : route('admin.premios.store') }}">
        @csrf
        @if($premio) @method('PUT') @endif

        <div class="mb-3">
            <label class="form-label">Nombre del premio *</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                   value="{{ old('nombre', $premio?->nombre) }}" required>
            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción *</label>
            <textarea name="descripcion" rows="3"
                      class="form-control @error('descripcion') is-invalid @enderror"
                      required>{{ old('descripcion', $premio?->descripcion) }}</textarea>
            @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Puntos requeridos *</label>
                <input type="number" name="puntos_requeridos" min="1"
                       class="form-control @error('puntos_requeridos') is-invalid @enderror"
                       value="{{ old('puntos_requeridos', $premio?->puntos_requeridos) }}" required>
                @error('puntos_requeridos')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Stock disponible *</label>
                <input type="number" name="stock" min="0"
                       class="form-control @error('stock') is-invalid @enderror"
                       value="{{ old('stock', $premio?->stock ?? 0) }}" required>
                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        @if($premio)
            <div class="mb-4">
                <div class="form-check" style="display:flex;align-items:center;gap:10px;">
                    <input type="checkbox" name="activo" id="activo"
                           class="form-check-input"
                           style="width:18px;height:18px;accent-color:var(--gp-green);"
                           {{ old('activo', $premio->activo) ? 'checked' : '' }}>
                    <label for="activo" class="form-label mb-0">Premio activo (visible para usuarios)</label>
                </div>
            </div>
        @endif

        <div class="d-flex gap-2">
            <button type="submit" class="btn-gp">
                <i class="bi bi-check2-circle me-1"></i>
                {{ $premio ? 'Guardar cambios' : 'Crear premio' }}
            </button>
            <a href="{{ route('admin.premios') }}" class="btn-gp-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
