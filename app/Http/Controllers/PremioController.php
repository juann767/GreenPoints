<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Premio;
use App\Models\Canje;
use App\Mail\CanjeConfirmadoMail;

class PremioController extends Controller
{
    public function index()
    {
        $premios = Premio::where('activo', 1)->get();
        $user    = Auth::user();
        $canjes  = Canje::where('user_id', $user->id)->with('premio')->orderByDesc('fecha_canje')->get();

        return view('premios.index', compact('premios', 'user', 'canjes'));
    }

    public function canjear($id)
    {
        $premio = Premio::where('activo', 1)->findOrFail($id);
        $user   = Auth::user();

        if ($user->puntos < $premio->puntos_requeridos) {
            return back()->withErrors(['puntos' => 'No tienes suficientes puntos.']);
        }

        if ($premio->stock <= 0) {
            return back()->withErrors(['puntos' => 'Este premio no tiene stock disponible.']);
        }

        $canje = Canje::create([
            'user_id'     => $user->id,
            'premio_id'   => $premio->id,
            'fecha_canje' => now(),
        ]);

        $user->decrement('puntos', $premio->puntos_requeridos);
        $premio->decrement('stock');

        // Enviar correo de confirmación de canje
        try {
            $userFresh = $user->fresh();
            $canje->load('premio');
            Mail::to($userFresh->email)->send(new CanjeConfirmadoMail($userFresh, $canje));
        } catch (\Exception $e) {
            // Si el correo falla no interrumpimos el canje
        }

        return redirect()->route('premios.index')
            ->with('success', "¡Canjeaste «{$premio->nombre}»! Revisa tu correo para el comprobante 🎁");
    }
}
