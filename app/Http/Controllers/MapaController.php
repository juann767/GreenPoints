<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use Illuminate\Http\JsonResponse;

class MapaController extends Controller
{
    /**
     * Vista principal del mapa con Leaflet.js.
     */
    public function index()
    {
        $totalActivos      = Dispositivo::where('estado', 'activo')->count();
        $totalMantenimiento = Dispositivo::where('estado', 'mantenimiento')->count();
        $totalInactivos    = Dispositivo::where('estado', 'inactivo')->count();

        return view('mapa.index', compact(
            'totalActivos',
            'totalMantenimiento',
            'totalInactivos'
        ));
    }

    /**
     * Retorna los dispositivos como JSON para Leaflet.
     * Solo los que tienen coordenadas registradas.
     */
    public function datos(): JsonResponse
    {
        $dispositivos = Dispositivo::whereNotNull('latitud')
            ->whereNotNull('longitud')
            ->whereIn('estado', ['activo', 'mantenimiento'])
            ->get(['id', 'nombre', 'ubicacion', 'descripcion', 'estado', 'latitud', 'longitud']);

        return response()->json($dispositivos);
    }
}
