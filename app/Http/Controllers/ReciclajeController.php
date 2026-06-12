<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\RegistroAccion;
use App\Models\AccionEcologica;
use App\Models\Dispositivo;
use App\Mail\ReciclajeConfirmadoMail;

class ReciclajeController extends Controller
{
    public function index()
    {
        $registros = RegistroAccion::where('user_id', Auth::id())
            ->with(['accion', 'dispositivo'])
            ->orderByDesc('fecha')
            ->get();

        return view('reciclaje.index', compact('registros'));
    }

    public function create()
    {
        $acciones     = AccionEcologica::all();
        $dispositivos = Dispositivo::where('estado', 'activo')->get();
        return view('reciclaje.create', compact('acciones', 'dispositivos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'accion_id'      => 'required|exists:acciones_ecologicas,id',
            'dispositivo_id' => 'nullable|exists:dispositivos,id',
            'cantidad_kg'    => 'nullable|numeric|min:0',
            'fecha'          => 'required|date',
            'observaciones'  => 'nullable|string|max:500',
        ]);

        $accion = AccionEcologica::findOrFail($validated['accion_id']);

        $registro = RegistroAccion::create([
            'user_id'        => Auth::id(),
            'accion_id'      => $validated['accion_id'],
            'dispositivo_id' => $validated['dispositivo_id'] ?? null,
            'cantidad_kg'    => $validated['cantidad_kg'] ?? null,
            'fecha'          => $validated['fecha'],
            'observaciones'  => $validated['observaciones'] ?? null,
        ]);

        Auth::user()->increment('puntos', $accion->puntos_otorgados);

        // Enviar correo de confirmación
        try {
            $user = Auth::user()->fresh();
            $registro->load(['accion', 'dispositivo']);
            Mail::to($user->email)->send(new ReciclajeConfirmadoMail($user, $registro));
        } catch (\Exception $e) {
            // Si el correo falla no interrumpimos el flujo
        }

        return redirect()->route('reciclaje.index')
            ->with('success', "¡Acción registrada! +{$accion->puntos_otorgados} puntos. <a href='/comprobante/{$registro->id}' target='_blank' style='color:#4ade80;font-weight:700;'>Ver comprobante QR →</a>");
    }

    public function destroy($id)
    {
        $registro = RegistroAccion::where('user_id', Auth::id())->findOrFail($id);
        $puntos = $registro->accion->puntos_otorgados;
        Auth::user()->decrement('puntos', $puntos);
        $registro->delete();

        return redirect()->route('reciclaje.index')->with('success', 'Registro eliminado.');
    }
}
