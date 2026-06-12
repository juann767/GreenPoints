@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="mb-4">
    <h3 class="fw-bold" style="color:var(--gp-green-dark);">
        <i class="bi bi-speedometer2 me-2"></i>Dashboard
    </h3>
    <p style="color:var(--gp-muted);">Resumen de impacto ambiental y consejos de reciclaje.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="gp-card h-100">
            <h6 class="fw-bold mb-3" style="color:var(--gp-green-dark);">
                🌍 Impacto ambiental
            </h6>
            <div class="wip-banner">
                <i class="bi bi-tools"></i>
                <span>Métricas de impacto (árboles salvados, CO₂ reducido) <strong>pendientes</strong> de calcular con datos reales.</span>
            </div>
            <div class="d-flex flex-column gap-3 mt-3" style="opacity:.6;">
                <div>
                    <div class="d-flex justify-content-between mb-1" style="font-size:.85rem;">
                        <span>🌳 Árboles equivalentes</span><span>—</span>
                    </div>
                    <div class="progress" style="height:8px;">
                        <div class="progress-bar bg-success" style="width:0%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-1" style="font-size:.85rem;">
                        <span>🌫️ CO₂ reducido (kg)</span><span>—</span>
                    </div>
                    <div class="progress" style="height:8px;">
                        <div class="progress-bar bg-info" style="width:0%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="gp-card h-100">
            <h6 class="fw-bold mb-3" style="color:var(--gp-green-dark);">
                💡 Tips de reciclaje
            </h6>

            <div id="tipBox" class="p-3 rounded-3" style="background:#e8f5e9;border:1px solid var(--gp-border);">
                <div class="fw-semibold" id="tipTitle">♻️ Separa correctamente</div>
                <p class="mb-0 mt-1" id="tipText" style="font-size:.88rem;color:var(--gp-muted);">
                    Clasifica tus residuos en: orgánicos, plásticos, papel y vidrio.
                </p>
            </div>

            <button onclick="nextTip()" class="btn btn-gp btn-sm mt-3">
                Siguiente tip →
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const tips = [
        { title: '♻️ Separa correctamente', text: 'Clasifica tus residuos en: orgánicos, plásticos, papel y vidrio.' },
        { title: '🧴 Limpia los envases', text: 'Enjuaga plásticos y vidrios antes de colocarlos en el contenedor.' },
        { title: '📦 Aplana el cartón', text: 'Aplana las cajas de cartón para ahorrar espacio y facilitar el transporte.' },
        { title: '🔋 Pilas y electrónicos', text: 'Nunca los mezcles con basura común. Llévalos a puntos de recolección especiales.' },
    ];
    let idx = 0;
    function nextTip() {
        idx = (idx + 1) % tips.length;
        document.getElementById('tipTitle').textContent = tips[idx].title;
        document.getElementById('tipText').textContent = tips[idx].text;
    }
</script>
@endpush

@endsection
