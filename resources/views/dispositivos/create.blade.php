@extends('layouts.app')
@section('title','Registrar Dispositivo')

@section('content')

<div class="mb-4">
    <h4 style="color:var(--gp-text);font-weight:700;margin:0;">Registrar nuevo dispositivo</h4>
    <p style="color:var(--gp-muted);font-size:.85rem;margin:4px 0 0;">Agrega un nuevo punto ecológico. Puedes marcar su ubicación en el mapa.</p>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="gp-card">
            <form method="POST" action="{{ route('dispositivos.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre del dispositivo *</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre') }}" placeholder="Ej. Punto Verde — UES Central" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ubicación *</label>
                    <input type="text" name="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror"
                           value="{{ old('ubicacion') }}" placeholder="Ej. Blvd. Los Héroes, San Salvador" required>
                    @error('ubicacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción <span style="opacity:.6;">opcional</span></label>
                    <textarea name="descripcion" class="form-control" rows="2"
                              placeholder="Materiales que acepta, horario, etc.">{{ old('descripcion') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado *</label>
                    <select name="estado" class="form-select" required>
                        <option value="activo"        {{ old('estado') === 'activo'        ? 'selected' : '' }}>✅ Activo</option>
                        <option value="mantenimiento" {{ old('estado') === 'mantenimiento' ? 'selected' : '' }}>⚙️ En mantenimiento</option>
                        <option value="inactivo"      {{ old('estado') === 'inactivo'      ? 'selected' : '' }}>❌ Inactivo</option>
                    </select>
                </div>

                {{-- Coordenadas --}}
                <div style="background:var(--gp-bg);border:1px solid var(--gp-border);border-radius:10px;padding:14px;margin-bottom:16px;">
                    <div style="font-size:.8rem;color:var(--gp-muted);font-weight:600;margin-bottom:10px;text-transform:uppercase;letter-spacing:.04em;">
                        <i class="bi bi-geo-alt-fill me-1" style="color:var(--gp-accent);"></i> Coordenadas del mapa
                    </div>
                    <p style="font-size:.78rem;color:var(--gp-muted);margin-bottom:10px;">
                        Haz clic en el mapa de la derecha para colocar el marcador, o ingresa las coordenadas manualmente.
                    </p>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label">Latitud</label>
                            <input type="number" name="latitud" id="inp-lat" class="form-control"
                                   step="0.0000001" value="{{ old('latitud') }}" placeholder="13.7034">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Longitud</label>
                            <input type="number" name="longitud" id="inp-lng" class="form-control"
                                   step="0.0000001" value="{{ old('longitud') }}" placeholder="-89.2182">
                        </div>
                    </div>
                    <div style="font-size:.74rem;color:var(--gp-muted);margin-top:6px;">
                        💡 Puedes obtener coordenadas en <a href="https://www.openstreetmap.org" target="_blank" style="color:var(--gp-accent);">OpenStreetMap</a> haciendo clic derecho → "Mostrar dirección".
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn-gp">
                        <i class="bi bi-check2-circle me-1"></i> Guardar dispositivo
                    </button>
                    <a href="{{ route('dispositivos.index') }}" class="btn-gp-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Mini mapa para seleccionar coordenadas --}}
    <div class="col-lg-6">
        <div class="gp-card" style="padding:0;overflow:hidden;">
            <div style="padding:12px 16px;border-bottom:1px solid var(--gp-border);">
                <div style="font-size:.82rem;color:var(--gp-muted);">
                    <i class="bi bi-cursor-fill me-1" style="color:var(--gp-accent);"></i>
                    Haz clic en el mapa para colocar el marcador
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
const miniMap = L.map('mini-mapa').setView([13.4833, -88.1820], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap', maxZoom: 19
}).addTo(miniMap);

let marker = null;

const iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" width="34" height="44" viewBox="0 0 34 44">
    <path d="M17 1C8.4 1 1 8.4 1 17c0 13.5 16 26 16 26S33 30.5 33 17C33 8.4 25.6 1 17 1z" fill="#1B8A3E"/>
    <circle cx="17" cy="17" r="9" fill="white"/>
    <text x="17" y="22" text-anchor="middle" font-size="13" font-weight="bold" fill="#1B8A3E">♻</text>
</svg>`;

const customIcon = L.divIcon({
    html: iconSvg, iconSize:[34,44], iconAnchor:[17,44], className:''
});

// Si ya hay coordenadas (old values), poner marcador
const oldLat = parseFloat('{{ old("latitud", "") }}');
const oldLng = parseFloat('{{ old("longitud", "") }}');
if (oldLat && oldLng) {
    marker = L.marker([oldLat, oldLng], { icon: customIcon, draggable: true }).addTo(miniMap);
    miniMap.setView([oldLat, oldLng], 15);
    marker.on('dragend', e => {
        const pos = e.target.getLatLng();
        document.getElementById('inp-lat').value = pos.lat.toFixed(7);
        document.getElementById('inp-lng').value = pos.lng.toFixed(7);
    });
}

// Clic en el mapa → colocar/mover marcador
miniMap.on('click', e => {
    const { lat, lng } = e.latlng;

    document.getElementById('inp-lat').value = lat.toFixed(7);
    document.getElementById('inp-lng').value = lng.toFixed(7);

    if (marker) {
        marker.setLatLng([lat, lng]);
    } else {
        marker = L.marker([lat, lng], { icon: customIcon, draggable: true }).addTo(miniMap);
        marker.on('dragend', ev => {
            const pos = ev.target.getLatLng();
            document.getElementById('inp-lat').value = pos.lat.toFixed(7);
            document.getElementById('inp-lng').value = pos.lng.toFixed(7);
        });
    }
});

// Sync inputs → mapa
['inp-lat','inp-lng'].forEach(id => {
    document.getElementById(id).addEventListener('change', () => {
        const lat = parseFloat(document.getElementById('inp-lat').value);
        const lng = parseFloat(document.getElementById('inp-lng').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            if (marker) { marker.setLatLng([lat, lng]); }
            else { marker = L.marker([lat, lng], { icon: customIcon, draggable: true }).addTo(miniMap); }
            miniMap.flyTo([lat, lng], 15);
        }
    });
});
</script>
@endpush

@endsection
