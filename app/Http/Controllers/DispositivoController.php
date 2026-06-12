<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dispositivo;

class DispositivoController extends Controller
{
    public function index()
    {
        $dispositivos = Dispositivo::orderBy('nombre')->get();
        return view('dispositivos.index', compact('dispositivos'));
    }

    public function create()
    {
        return view('dispositivos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'ubicacion' => 'required|string|max:255',
            'descripcion'=> 'nullable|string',
            'estado'    => 'required|in:activo,mantenimiento,inactivo',
            'latitud'   => 'nullable|numeric|between:-90,90',
            'longitud'  => 'nullable|numeric|between:-180,180',
        ]);

        Dispositivo::create($request->only(
            'nombre', 'ubicacion', 'descripcion', 'estado', 'latitud', 'longitud'
        ));

        return redirect()->route('dispositivos.index')
            ->with('success', 'Dispositivo registrado correctamente. <a href="' . route('mapa.index') . '" style="color:#4ade80;font-weight:700;">Ver en el mapa →</a>');
    }

    public function edit($id)
    {
        $dispositivo = Dispositivo::findOrFail($id);
        return view('dispositivos.edit', compact('dispositivo'));
    }

    public function update(Request $request, $id)
    {
        $dispositivo = Dispositivo::findOrFail($id);

        $request->validate([
            'nombre'     => 'required|string|max:100',
            'ubicacion'  => 'required|string|max:255',
            'descripcion'=> 'nullable|string',
            'estado'     => 'required|in:activo,mantenimiento,inactivo',
            'latitud'    => 'nullable|numeric|between:-90,90',
            'longitud'   => 'nullable|numeric|between:-180,180',
        ]);

        $dispositivo->update($request->only(
            'nombre', 'ubicacion', 'descripcion', 'estado', 'latitud', 'longitud'
        ));

        return redirect()->route('dispositivos.index')
            ->with('success', 'Dispositivo actualizado. <a href="' . route('mapa.index') . '" style="color:#4ade80;font-weight:700;">Ver en el mapa →</a>');
    }

    public function destroy($id)
    {
        Dispositivo::findOrFail($id)->delete();
        return redirect()->route('dispositivos.index')
            ->with('success', 'Dispositivo eliminado.');
    }
}
