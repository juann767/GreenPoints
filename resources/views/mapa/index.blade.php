@extends('layouts.app')
@section('title','Mapa de Dispositivos')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 style="color:var(--gp-text);font-weight:700;margin:0;">
            <i class="bi bi-map-fill me-2" style="color:var(--gp-accent);"></i>Mapa de puntos ecológicos
        </h4>
        <p style="color:var(--gp-muted);font-size:.85rem;margin:4px 0 0;">
            Ubica el punto de reciclaje más cercano a ti.
        </p>
    </div>
    <a href="{{ route('dispositivos.create') }}" class="btn-gp">
        <i class="bi bi-plus-circle me-1"></i> Nuevo dispositivo
    </a>
</div>

{{-- Badges de resumen --}}
<div class="d-flex gap-2 mb-3 flex-wrap">
    <div style="background:rgba(74,222,128,.12);border:1px solid rgba(74,222,128,.3);border-radius:20px;padding:5px 14px;font-size:.82rem;color:#4ade80;font-weight:600;">
        <i class="bi bi-circle-fill me-1" style="font-size:.55rem;"></i> {{ $totalActivos }} activos
    </div>
    <div style="background:rgba(251,191,36,.12);border:1px solid rgba(251,191,36,.3);border-radius:20px;padding:5px 14px;font-size:.82rem;color:#fbbf24;font-weight:600;">
        <i class="bi bi-circle-fill me-1" style="font-size:.55rem;"></i> {{ $totalMantenimiento }} en mantenimiento
    </div>
    <div style="background:rgba(248,113,113,.12);border:1px solid rgba(248,113,113,.3);border-radius:20px;padding:5px 14px;font-size:.82rem;color:#f87171;font-weight:600;">
        <i class="bi bi-circle-fill me-1" style="font-size:.55rem;"></i> {{ $totalInactivos }} inactivos
    </div>
</div>

<div class="row g-3">
    {{-- Mapa principal --}}
    <div class="col-lg-8">
        <div class="gp-card" style="padding:0;overflow:hidden;">
            <div id="mapa-leaflet" style="height:480px;width:100%;"></div>
        </div>
    </div>

    {{-- Panel lateral --}}
    <div class="col-lg-4">

        {{-- Info del dispositivo seleccionado --}}
        <div class="gp-card mb-3" id="panel-dispositivo">
            <div class="gp-card-title">
                <i class="bi bi-cursor-fill"></i> Selecciona un punto
            </div>
            <div id="panel-vacio" style="color:var(--gp-muted);font-size:.88rem;padding:12px 0;">
                Haz clic en cualquier marcador del mapa para ver su información.
            </div>
            <div id="panel-info" style="display:none;">
                <div style="font-size:1rem;font-weight:700;color:var(--gp-text);margin-bottom:6px;" id="info-nombre"></div>
                <div style="font-size:.83rem;color:var(--gp-muted);margin-bottom:8px;display:flex;align-items:center;gap:5px;">
                    <i class="bi bi-geo-alt"></i>
                    <span id="info-ubicacion"></span>
                </div>
                <span id="info-estado-badge" class="mb-2 d-inline-block"></span>
                <p id="info-desc" style="font-size:.83rem;color:var(--gp-muted);margin:10px 0 14px;"></p>
                <a id="info-btn-usar" href="#" class="btn-gp" style="text-align:center;display:block;font-size:.85rem;">
                    <i class="bi bi-recycle me-1"></i> Usar este dispositivo
                </a>
            </div>
        </div>

        {{-- Lista de dispositivos --}}
        <div class="gp-card">
            <div class="gp-card-title"><i class="bi bi-list-ul"></i> Todos los puntos</div>
            <div id="lista-dispositivos" style="display:flex;flex-direction:column;gap:4px;max-height:260px;overflow-y:auto;">
                <div style="color:var(--gp-muted);font-size:.82rem;padding:8px 0;">Cargando...</div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css"/>
<style>
    /* Fix z-index de Leaflet dentro del layout */
    .leaflet-pane,
    .leaflet-top,
    .leaflet-bottom { z-index: 10 !important; }
    .leaflet-control { z-index: 11 !important; }

    /* Scrollbar lista */
    #lista-dispositivos::-webkit-scrollbar { width:4px; }
    #lista-dispositivos::-webkit-scrollbar-thumb { background:var(--gp-border);border-radius:2px; }

    /* Item de lista */
    .lista-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 10px;
        border-radius: 8px;
        cursor: pointer;
        transition: background .18s;
        border: 1px solid transparent;
    }
    .lista-item:hover { background: var(--gp-card2); }
    .lista-item.activo-item { border-color: rgba(74,222,128,.3); }

    .dot-activo        { width:8px;height:8px;border-radius:50%;background:#4ade80;flex-shrink:0; }
    .dot-mantenimiento { width:8px;height:8px;border-radius:50%;background:#fbbf24;flex-shrink:0; }
    .dot-inactivo      { width:8px;height:8px;border-radius:50%;background:#f87171;flex-shrink:0; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.js"></script>
<script>
// ── Inicializar mapa centrado en San Salvador ──────────────
const map = L.map('mapa-leaflet', { zoomControl: true }).setView([13.4833, -88.1820], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://openstreetmap.org">OpenStreetMap</a>',
    maxZoom: 19,
}).addTo(map);

// ── Íconos personalizados ─────────────────────────────────
function makeIcon(estado) {
    const colors = {
        activo:        { fill: '#1B8A3E', text: '#1B8A3E' },
        mantenimiento: { fill: '#d97706', text: '#d97706' },
        inactivo:      { fill: '#dc2626', text: '#dc2626' },
    };
    const c = colors[estado] || colors.activo;

    const svg = `
        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="44" viewBox="0 0 34 44">
            <filter id="shadow">
                <feDropShadow dx="0" dy="2" stdDeviation="2" flood-opacity="0.3"/>
            </filter>
            <path d="M17 1C8.4 1 1 8.4 1 17c0 13.5 16 26 16 26S33 30.5 33 17C33 8.4 25.6 1 17 1z"
                  fill="${c.fill}" filter="url(#shadow)"/>
            <circle cx="17" cy="17" r="9" fill="white"/>
            <text x="17" y="22" text-anchor="middle" font-size="13" font-weight="bold" fill="${c.text}">♻</text>
        </svg>`;

    return L.divIcon({
        html: svg,
        iconSize:    [34, 44],
        iconAnchor:  [17, 44],
        popupAnchor: [0, -46],
        className:   '',
    });
}

// ── Cargar dispositivos desde el endpoint JSON ────────────
let marcadores = {};

fetch('{{ route("mapa.datos") }}')
    .then(r => r.json())
    .then(dispositivos => {
        const lista = document.getElementById('lista-dispositivos');
        lista.innerHTML = '';

        if (dispositivos.length === 0) {
            lista.innerHTML = '<div style="color:var(--gp-muted);font-size:.82rem;padding:8px 0;">Sin dispositivos con coordenadas registradas.</div>';
            return;
        }

        dispositivos.forEach(d => {
            const marker = L.marker([d.latitud, d.longitud], { icon: makeIcon(d.estado) }).addTo(map);

            marker.on('click', () => mostrarInfo(d, marker));
            marcadores[d.id] = { marker, datos: d };

            // Item en la lista lateral
            const item = document.createElement('div');
            item.className = `lista-item ${d.estado === 'activo' ? 'activo-item' : ''}`;
            item.innerHTML = `
                <div class="dot-${d.estado}"></div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:.85rem;font-weight:600;color:var(--gp-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        ${d.nombre}
                    </div>
                    <div style="font-size:.75rem;color:var(--gp-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        ${d.ubicacion}
                    </div>
                </div>
            `;
            item.addEventListener('click', () => {
                map.flyTo([d.latitud, d.longitud], 16, { duration: 1 });
                setTimeout(() => mostrarInfo(d, marker), 400);
            });
            lista.appendChild(item);
        });
    })
    .catch(() => {
        document.getElementById('lista-dispositivos').innerHTML =
            '<div style="color:#f87171;font-size:.82rem;">Error cargando dispositivos.</div>';
    });

// ── Mostrar info en panel lateral ─────────────────────────
function mostrarInfo(d, marker) {
    document.getElementById('panel-vacio').style.display = 'none';
    document.getElementById('panel-info').style.display  = 'block';
    document.getElementById('info-nombre').textContent    = d.nombre;
    document.getElementById('info-ubicacion').textContent = d.ubicacion;
    document.getElementById('info-desc').textContent      = d.descripcion || '';

    const badge = document.getElementById('info-estado-badge');
    const badges = {
        activo:        { cls: 'badge-activo',        txt: '✅ Activo' },
        mantenimiento: { cls: 'badge-mantenimiento',  txt: '⚙️ Mantenimiento' },
        inactivo:      { cls: 'badge-inactivo',       txt: '❌ Inactivo' },
    };
    const b = badges[d.estado] || badges.activo;
    badge.className = b.cls;
    badge.textContent = b.txt;

    // Botón "Usar este dispositivo" lleva al formulario de reciclaje con el dispositivo preseleccionado
    const btn = document.getElementById('info-btn-usar');
    if (d.estado === 'activo') {
        btn.href  = `{{ url('/reciclaje/crear') }}?dispositivo_id=${d.id}`;
        btn.style.opacity    = '1';
        btn.style.pointerEvents = 'auto';
    } else {
        btn.href  = '#';
        btn.style.opacity    = '0.4';
        btn.style.pointerEvents = 'none';
    }

    // Abrir popup en el mapa
    marker.bindPopup(`
        <div style="font-family:'Segoe UI',sans-serif;min-width:160px;">
            <div style="font-weight:700;font-size:.9rem;margin-bottom:3px;">${d.nombre}</div>
            <div style="font-size:.78rem;color:#5a7360;">${d.ubicacion}</div>
        </div>
    `).openPopup();
}
</script>
@endpush

@endsection
