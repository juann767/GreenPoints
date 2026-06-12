<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\RegistroAccion;
use App\Models\Canje;
use App\Models\AccionEcologica;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalRegistros = RegistroAccion::where('user_id', $user->id)->count();
        $totalCanjes    = Canje::where('user_id', $user->id)->count();

        $ultimosRegistros = RegistroAccion::where('user_id', $user->id)
            ->with('accion')
            ->orderByDesc('fecha')
            ->take(5)
            ->get();

        // Datos para gráfico de dona — materiales reciclados por el usuario
        $materialesDona = RegistroAccion::where('user_id', $user->id)
            ->join('acciones_ecologicas', 'registros_acciones.accion_id', '=', 'acciones_ecologicas.id')
            ->selectRaw('acciones_ecologicas.nombre as material, COUNT(*) as total')
            ->groupBy('acciones_ecologicas.nombre')
            ->get();

        // Métricas de impacto ambiental
        // Fórmulas simplificadas para fines educativos:
        // 1 kg reciclado = 0.5 kg CO2 reducido (promedio)
        // 100 kg reciclados = 1 árbol equivalente
        $totalKg = RegistroAccion::where('user_id', $user->id)->sum('cantidad_kg');
        $co2Reducido   = round($totalKg * 0.5, 1);
        $arboles       = round($totalKg / 100, 2);

        // Actividad mensual (últimos 6 meses) para gráfico de barras
        $actividadMensual = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes   = now()->subMonths($i);
            $count = RegistroAccion::where('user_id', $user->id)
                ->whereYear('fecha', $mes->year)
                ->whereMonth('fecha', $mes->month)
                ->count();
            $actividadMensual[] = [
                'mes'   => $mes->format('M'),
                'total' => $count,
            ];
        }

        return view('dashboard.index', compact(
            'user', 'totalRegistros', 'totalCanjes',
            'ultimosRegistros', 'materialesDona',
            'co2Reducido', 'arboles', 'actividadMensual'
        ));
        
    }

    public function ranking()
{
    $usuarios = \App\Models\User::orderByDesc('puntos')
        ->take(10)
        ->get();

    return view('ranking', compact('usuarios'));
}
}
