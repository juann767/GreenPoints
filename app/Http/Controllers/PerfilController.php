<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class PerfilController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('perfil.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('perfil.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required'  => 'El correo es obligatorio.',
            'email.email'     => 'Ingresa un correo válido.',
            'email.unique'    => 'Este correo ya está registrado por otro usuario.',
            'avatar.image'    => 'El archivo debe ser una imagen.',
            'avatar.max'      => 'La imagen no debe superar 2MB.',
        ]);

        $data = [
            'nombre' => $request->nombre,
            'email'  => $request->email,
        ];

        // Subida de avatar
        if ($request->hasFile('avatar')) {
            // Eliminar avatar anterior si existe
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatares', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return redirect()->route('perfil.show')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'password_actual' => 'required',
            'password'        => ['required', 'min:6', 'confirmed'],
        ], [
            'password_actual.required' => 'Debes ingresar tu contraseña actual.',
            'password.required'        => 'La nueva contraseña es obligatoria.',
            'password.min'             => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed'       => 'Las contraseñas no coinciden.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password_actual, $user->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual es incorrecta.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('perfil.show')
            ->with('success', 'Contraseña actualizada correctamente.');
    }
}
