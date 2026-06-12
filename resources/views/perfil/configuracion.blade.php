    @extends('layouts.app')
    @section('title', 'Configuración')

    @section('content')

    <div class="mb-4">
        <h3 class="fw-bold" style="color:var(--gp-green-dark);">
            <i class="bi bi-gear-fill me-2"></i>Configuración
        </h3>
    </div>

    <div class="gp-card" style="max-width:560px;">
        <div class="wip-banner mb-4">
            <i class="bi bi-tools"></i>
            <span>
                <strong>Pendiente de implementar:</strong> Esta sección requiere crear el modelo
                <code>ConfigNotificaciones</code> y su migración correspondiente.
            </span>
        </div>

        <h6 class="fw-bold mb-3" style="color:var(--gp-green-dark);">Notificaciones</h6>

        <div class="d-flex flex-column gap-3" style="opacity:.5;pointer-events:none;">
            @foreach([
                ['noti_metas',       'Notificaciones de metas',       'bi-bullseye'],
                ['noti_recompensas', 'Notificaciones de recompensas', 'bi-gift'],
                ['noti_niveles',     'Notificaciones de nivel',       'bi-bar-chart'],
            ] as [$key, $label, $icon])
                <div class="d-flex align-items-center justify-content-between p-3 rounded-3"
                    style="background:#f8f8f8;border:1px solid #eee;">
                    <label class="d-flex align-items-center gap-2 mb-0 fw-semibold">
                        <i class="bi {{ $icon }}" style="color:var(--gp-green);font-size:1.1rem;"></i>
                        {{ $label }}
                    </label>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" disabled>
                    </div>
                </div>
            @endforeach
        </div>

        <hr class="my-4">
        <h6 class="fw-bold mb-3" style="color:var(--gp-green-dark);">Apariencia</h6>
        <div class="d-flex align-items-center justify-content-between p-3 rounded-3"
            style="background:#f8f8f8;border:1px solid #eee;opacity:.5;">
            <label class="d-flex align-items-center gap-2 mb-0 fw-semibold">
                <i class="bi bi-moon" style="color:var(--gp-green);font-size:1.1rem;"></i>
                Modo oscuro
            </label>
            <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" disabled>
            </div>
        </div>
    </div>

    @endsection
