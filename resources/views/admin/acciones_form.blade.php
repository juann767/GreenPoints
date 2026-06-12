@extends('layouts.app')
@section('title', $accion ? 'Editar Acción' : 'Nueva Acción Ecológica')

@section('content')

<div class="mb-4">
    <h4 style="color:var(--gp-text);font-weight:700;margin:0;">
        {{ $accion ? 'Editar acción ecológica' : 'Nueva acción ecológica' }}
    </h4>
</div>

<div class="gp-card" style="max-width:520px;">
    <form method="POST"
          action="{{ $accion ? route('admin.acciones.update', $accion->id) : route('admin.acciones.store') }}">
        @csrf
        @if($accion) @method('PUT') @endif

        <div class="mb-3">
            <label class="form-label">Nombre de la acción *</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                   value="{{ old('nombre', $accion?->nombre) }}"
                   placeholder="Ej. Reciclaje de papel y cartón" required>
            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción *</label>
            <textarea name="descripcion" rows="2"
                      class="form-control @error('descripcion') is-invalid @enderror"
                      placeholder="Describe la acción ecológica..."
                      required>{{ old('descripcion', $accion?->descripcion) }}</textarea>
            @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Puntos otorgados *</label>
            <input type="number" name="puntos_otorgados" min="1"
                   class="form-control @error('puntos_otorgados') is-invalid @enderror"
                   value="{{ old('puntos_otorgados', $accion?->puntos_otorgados) }}"
                   placeholder="30" required>
            @error('puntos_otorgados')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-gp">
                <i class="bi bi-check2-circle me-1"></i>
                {{ $accion ? 'Guardar cambios' : 'Crear acción' }}
            </button>
            <a href="{{ route('admin.acciones') }}" class="btn-gp-ghost">Cancelar</a>
        </div>
    </form>
</div>

@endsection
