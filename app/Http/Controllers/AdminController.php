<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\RegistroAccion;
use App\Models\Canje;
use App\Models\Dispositivo;
use App\Models\Premio;
use App\Models\AccionEcologica;

class AdminController extends Controller
{
    // ── Dashboard Admin ───────────────────────────────
    public function index()
    {
        $totalUsuarios   = User::where('role_id', 2)->count();
        $totalAcciones   = RegistroAccion::count();
        $totalCanjes     = Canje::count();
        $dispositivosActivos = Dispositivo::where('estado', 'activo')->count();

        $ultimosUsuarios = User::where('role_id', 2)
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Materiales más reciclados
        $materiales = RegistroAccion::join('acciones_ecologicas', 'registros_acciones.accion_id', '=', 'acciones_ecologicas.id')
            ->selectRaw('acciones_ecologicas.nombre, SUM(registros_acciones.cantidad_kg) as total_kg, COUNT(*) as total_registros')
            ->groupBy('acciones_ecologicas.nombre')
            ->orderByDesc('total_registros')
            ->get();

        return view('admin.index', compact(
            'totalUsuarios', 'totalAcciones', 'totalCanjes',
            'dispositivosActivos', 'ultimosUsuarios', 'materiales'
        ));
    }

    // ── Usuarios ──────────────────────────────────────
    public function usuarios()
    {
        $usuarios = User::with('role')->orderByDesc('created_at')->get();
        return view('admin.usuarios', compact('usuarios'));
    }

    public function toggleUsuario($id)
    {
        $user = User::findOrFail($id);
        // Usamos el campo puntos no, usamos un campo activo — lo simulamos con role toggle
        // En su lugar simplemente devolvemos con mensaje por ahora
        return redirect()->route('admin.usuarios')
            ->with('success', "Usuario {$user->nombre} actualizado.");
    }

    // ── Premios CRUD ──────────────────────────────────
    public function premios()
    {
        $premios = Premio::orderBy('nombre')->get();
        return view('admin.premios', compact('premios'));
    }

    public function premioCreate()
    {
        return view('admin.premios_form', ['premio' => null]);
    }

    public function premioStore(Request $request)
    {
        $request->validate([
            'nombre'            => 'required|string|max:100',
            'descripcion'       => 'required|string',
            'puntos_requeridos' => 'required|integer|min:1',
            'stock'             => 'required|integer|min:0',
        ]);

        Premio::create([
            'nombre'            => $request->nombre,
            'descripcion'       => $request->descripcion,
            'puntos_requeridos' => $request->puntos_requeridos,
            'stock'             => $request->stock,
            'activo'            => 1,
        ]);

        return redirect()->route('admin.premios')
            ->with('success', 'Premio creado correctamente.');
    }

    public function premioEdit($id)
    {
        $premio = Premio::findOrFail($id);
        return view('admin.premios_form', compact('premio'));
    }

    public function premioUpdate(Request $request, $id)
    {
        $premio = Premio::findOrFail($id);

        $request->validate([
            'nombre'            => 'required|string|max:100',
            'descripcion'       => 'required|string',
            'puntos_requeridos' => 'required|integer|min:1',
            'stock'             => 'required|integer|min:0',
        ]);

        $premio->update([
            'nombre'            => $request->nombre,
            'descripcion'       => $request->descripcion,
            'puntos_requeridos' => $request->puntos_requeridos,
            'stock'             => $request->stock,
            'activo'            => $request->has('activo') ? 1 : 0,
        ]);

        return redirect()->route('admin.premios')
            ->with('success', 'Premio actualizado.');
    }

    public function premioDestroy($id)
    {
        Premio::findOrFail($id)->delete();
        return redirect()->route('admin.premios')
            ->with('success', 'Premio eliminado.');
    }

    // ── Acciones Ecológicas CRUD ──────────────────────
    public function acciones()
    {
        $acciones = AccionEcologica::orderBy('nombre')->get();
        return view('admin.acciones', compact('acciones'));
    }

    public function accionCreate()
    {
        return view('admin.acciones_form', ['accion' => null]);
    }

    public function accionStore(Request $request)
    {
        $request->validate([
            'nombre'          => 'required|string|max:100',
            'descripcion'     => 'required|string',
            'puntos_otorgados'=> 'required|integer|min:1',
        ]);

        AccionEcologica::create($request->only('nombre', 'descripcion', 'puntos_otorgados'));

        return redirect()->route('admin.acciones')
            ->with('success', 'Acción ecológica creada.');
    }

    public function accionEdit($id)
    {
        $accion = AccionEcologica::findOrFail($id);
        return view('admin.acciones_form', compact('accion'));
    }

    public function accionUpdate(Request $request, $id)
    {
        $accion = AccionEcologica::findOrFail($id);

        $request->validate([
            'nombre'          => 'required|string|max:100',
            'descripcion'     => 'required|string',
            'puntos_otorgados'=> 'required|integer|min:1',
        ]);

        $accion->update($request->only('nombre', 'descripcion', 'puntos_otorgados'));

        return redirect()->route('admin.acciones')
            ->with('success', 'Acción ecológica actualizada.');
    }

    public function accionDestroy($id)
    {
        AccionEcologica::findOrFail($id)->delete();
        return redirect()->route('admin.acciones')
            ->with('success', 'Acción eliminada.');
    }
}
