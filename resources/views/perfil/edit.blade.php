@extends('layouts.app')
@section('title','Editar Perfil')

@section('content')

<div class="mb-4">
    <h4 style="color:var(--gp-text);font-weight:700;margin:0;">Editar perfil</h4>
    <p style="color:var(--gp-muted);font-size:.85rem;margin:4px 0 0;">Actualiza tu información personal y foto de perfil.</p>
</div>

<div class="gp-card" style="max-width:520px;">
    <form method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- Avatar actual + subida --}}
        <div class="mb-4 text-center">
            <div id="avatar-preview" style="width:80px;height:80px;border-radius:50%;overflow:hidden;margin:0 auto 12px;border:3px solid var(--gp-green);background:var(--gp-bg);display:flex;align-items:center;justify-content:center;">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" style="width:100%;height:100%;object-fit:cover;" id="avatar-img">
                @else
                    <span id="avatar-initial" style="font-size:1.8rem;font-weight:700;color:var(--gp-accent);">
                        {{ strtoupper(substr($user->nombre, 0, 1)) }}
                    </span>
                @endif
            </div>

            <label for="avatar" style="cursor:pointer;" class="btn-gp-ghost" style="font-size:.82rem;padding:6px 14px;">
                <i class="bi bi-camera me-1"></i> Cambiar foto
            </label>
            <input type="file" name="avatar" id="avatar" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
            <div style="font-size:.75rem;color:var(--gp-muted);margin-top:6px;">JPG, PNG o WEBP — máx. 2MB</div>
            @error('avatar')<div style="color:#f87171;font-size:.8rem;margin-top:4px;">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre completo *</label>
            <input type="text" name="nombre"
                   class="form-control @error('nombre') is-invalid @enderror"
                   value="{{ old('nombre', $user->nombre) }}" required>
            @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Correo electrónico *</label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $user->email) }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-gp">
                <i class="bi bi-save me-1"></i> Guardar cambios
            </button>
            <a href="{{ route('perfil.show') }}" class="btn-gp-ghost">Cancelar</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('avatar-preview');
            preview.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection
