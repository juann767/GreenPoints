@extends('layouts.app')
@section('title','Editar Dispositivo')

@section('content')

<div class="mb-4">
    <h4 style="color:var(--gp-text);font-weight:700;margin:0;">Editar dispositivo</h4>
    <p style="color:var(--gp-muted);font-size:.85rem;margin:4px 0 0;">Modifica la información y reposiciona el marcador en el mapa.</p>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="gp-card">
            <form method="POST" action="{{ route('dispositivos.update', $dispositivo->id) }}">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre', $dispositivo->nombre) }}" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ubicación *</label>
                    <input type="text" name="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror"
                           value="{{ old('ubicacion', $dispositivo->ubicacion) }}" required>
                    @error('ubicacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="2">{{ old('descripcion', $dispositivo->descripcion) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado *</label>
                    <select name="estado" class="form-select" required>
                        <option value="activo"        {{ old('estado', $dispositivo->estado) === 'activo'        ? 'selected' : '' }}>✅ Activo</option>
                        <option value="mantenimiento" {{ old('estado', $dispositivo->estado) === 'mantenimiento' ? 'selected' : '' }}>⚙️ En mantenimiento</option>
                        <option value="inactivo"      {{ old('estado', $dispositivo->estado) === 'inactivo'      ? 'selected' : '' }}>❌ Inactivo</option>
                    </select>
                </div>

                {{-- Coordenadas --}}
                <div style="background:var(--gp-bg);border:1px solid var(--gp-border);border-radius:10px;padding:14px;margin-bottom:16px;">
                    <div style="font-size:.8rem;color:var(--gp-muted);font-weight:600;margin-bottom:10px;text-transform:uppercase;letter-spacing:.04em;">
                        <i class="bi bi-geo-alt-fill me-1" style="color:var(--gp-accent);"></i> Coordenadas del mapa
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label">Latitud</label>
                            <input type="number" name="latitud" id="inp-lat" class="form-control"
                                   step="0.0000001" value="{{ old('latitud', $dispositivo->latitud) }}" placeholder="13.7034">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Longitud</label>
                            <input type="number" name="longitud" id="inp-lng" class="form-control"
                                   step="0.0000001" value="{{ old('longitud', $dispositivo->longitud) }}" placeholder="-89.2182">
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-gp">
                        <i class="bi bi-save me-1"></i> Guardar cambios
                    </button>
                    <a href="{{ route('dispositivos.index') }}" class="btn-gp-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Mini mapa --}}
    <div class="col-lg-6">
        <div class="gp-card" style="padding:0;overflow:hidden;">
            <div style="padding:12px 16px;border-bottom:1px solid var(--gp-border);">
                <div style="font-size:.82rem;color:var(--gp-muted);">
                    <i class="bi bi-cursor-fill me-1" style="color:var(--gp-accent);"></i>
                    Arrastra el marcador o haz clic para reposicionar
                </div>
            </div>
            <div id="mini-mapa" style="height:420px;"></div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css"/>
<style>
    .leaflet-pane, .leaflet-top, .leaflet-bottom { z-index:10 !important; }
    .leaflet-control { z-index:11 !important; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.js"></script>
<script>
const initLat = {{ $dispositivo->latitud ?? 13.4833 }};
const initLng = {{ $dispositivo->longitud ?? -88.1820 }};
const hasCoords = {{ $dispositivo->tieneCoordenadas() ? 'true' : 'false' }};

const miniMap = L.map('mini-mapa').setView([initLat, initLng], hasCoords ? 15 : 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap', maxZoom: 19
}).addTo(miniMap);

const iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="34" height="44" viewBox="0 0 34 44">
    <path d="M17 1C8.4 1 1 8.4 1 17c0 13.5 16 26 16 26S33 30.5 33 17C33 8.4 25.6 1 17 1z" fill="#1B8A3E"/>
    <circle cx="17" cy="17" r="9" fill="white"/>
    <text x="17" y="22" text-anchor="middle" font-size="13" font-weight="bold" fill="#1B8A3E">♻</text>
</svg>`;

const customIcon = L.divIcon({ html:iconSvg, iconSize:[34,44], iconAnchor:[17,44], className:'' });

let marker = null;
if (hasCoords) {
    marker = L.marker([initLat, initLng], { icon: customIcon, draggable: true }).addTo(miniMap);
    marker.on('dragend', e => {
        const pos = e.target.getLatLng();
        document.getElementById('inp-lat').value = pos.lat.toFixed(7);
        document.getElementById('inp-lng').value = pos.lng.toFixed(7);
    });
}

miniMap.on('click', e => {
    const { lat, lng } = e.latlng;
    document.getElementById('inp-lat').value = lat.toFixed(7);
    document.getElementById('inp-lng').value = lng.toFixed(7);
    if (marker) { marker.setLatLng([lat, lng]); }
    else {
        marker = L.marker([lat, lng], { icon: customIcon, draggable: true }).addTo(miniMap);
        marker.on('dragend', ev => {
            const p = ev.target.getLatLng();
            document.getElementById('inp-lat').value = p.lat.toFixed(7);
            document.getElementById('inp-lng').value = p.lng.toFixed(7);
        });
    }
});
</script>
@endpush

@endsection
