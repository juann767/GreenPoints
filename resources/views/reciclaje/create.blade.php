@extends('layouts.app')
@section('title','Registrar Reciclaje')

@section('content')

<div class="mb-4">
    <h4 style="color:var(--gp-text);font-weight:700;margin:0;">Registrar acción ecológica</h4>
    <p style="color:var(--gp-muted);font-size:.85rem;margin:4px 0 0;">Selecciona el tipo de material y el dispositivo donde lo depositaste.</p>
</div>

<div class="row g-3">
    {{-- Formulario --}}
    <div class="col-md-7">
        <div class="gp-card">
            <form method="POST" action="{{ route('reciclaje.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Tipo de acción ecológica *</label>
                    <select name="accion_id" id="accion_id" class="form-select" required onchange="updatePuntos(this)">
                        <option value="">— Selecciona una acción —</option>
                        @foreach($acciones as $a)
                            <option value="{{ $a->id }}"
                                    data-puntos="{{ $a->puntos_otorgados }}"
                                    {{ old('accion_id') == $a->id ? 'selected' : '' }}>
                                {{ $a->nombre }} (+{{ $a->puntos_otorgados }} pts)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Dispositivo / Punto ecológico <a href="{{ route('mapa.index') }}" target="_blank" style="color:var(--gp-accent);font-size:.75rem;margin-left:6px;"><i class="bi bi-map me-1"></i>Ver mapa</a></label>
                    <select name="dispositivo_id" class="form-select">
                        <option value="">— Sin dispositivo específico —</option>
                        @foreach($dispositivos as $d)
                            <option value="{{ $d->id }}" {{ old('dispositivo_id') == $d->id ? 'selected' : '' }}>
                                {{ $d->nombre }} — {{ $d->ubicacion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Cantidad (kg) <span style="opacity:.6;">opcional</span></label>
                        <input type="number" name="cantidad_kg" class="form-control"
                               step="0.01" min="0" value="{{ old('cantidad_kg') }}" placeholder="2.5">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha *</label>
                        <input type="date" name="fecha" class="form-control"
                               value="{{ old('fecha', date('Y-m-d')) }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Observaciones <span style="opacity:.6;">opcional</span></label>
                    <textarea name="observaciones" class="form-control" rows="2"
                              placeholder="Notas adicionales...">{{ old('observaciones') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-gp">
                        <i class="bi bi-check2-circle me-1"></i> Registrar acción
                    </button>
                    <a href="{{ route('reciclaje.index') }}" class="btn-gp-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Panel puntos a ganar --}}
    <div class="col-md-5">
        <div class="gp-card" style="text-align:center;padding:28px;">
            <div style="color:var(--gp-muted);font-size:.8rem;text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px;">
                <i class="bi bi-star-fill me-1" style="color:#4ade80;"></i> Puntos a ganar
            </div>
            <div id="pts-display" style="font-size:3rem;font-weight:800;color:#4ade80;line-height:1;">—</div>
            <div style="font-size:.8rem;color:var(--gp-muted);margin-top:6px;">por esta acción</div>
        </div>

        <div class="gp-card mt-3">
            <div class="gp-card-title"><i class="bi bi-list-check"></i> Acciones disponibles</div>
            @foreach($acciones as $a)
                <div class="d-flex justify-content-between align-items-center py-2"
                     style="border-bottom:1px solid var(--gp-border);">
                    <span style="font-size:.88rem;">{{ $a->nombre }}</span>
                    <span style="color:#4ade80;font-size:.8rem;font-weight:700;">+{{ $a->puntos_otorgados }} pts</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
function updatePuntos(sel) {
    const opt = sel.options[sel.selectedIndex];
    const pts = opt.dataset.puntos;
    document.getElementById('pts-display').textContent = pts ? '+' + pts + ' pts' : '—';
}
</script>
@endpush

@endsection
