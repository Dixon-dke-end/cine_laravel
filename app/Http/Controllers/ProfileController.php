<?php

// Define el espacio de nombres del controlador.
namespace App\Http\Controllers;

// Importa las clases necesarias para manejar solicitudes, respuestas y autenticación.
use App\Http\Requests\ProfileUpdateRequest;  // Clase personalizada para validar la actualización del perfil.
use Illuminate\Http\RedirectResponse;        // Permite redirigir al usuario tras ejecutar una acción.
use Illuminate\Http\Request;                 // Representa la solicitud HTTP actual.
use Illuminate\Support\Facades\Auth;         // Proporciona funciones relacionadas con la autenticación del usuario.
use Illuminate\Support\Facades\Redirect;     // Facilita las redirecciones a rutas.
use Illuminate\View\View;                    // Permite devolver vistas.

// Controlador encargado de gestionar el perfil del usuario autenticado.
class ProfileController extends Controller
{
    /**
     * Muestra el formulario del perfil del usuario autenticado.
     */
    public function edit(Request $request): View
    {
        // Retorna la vista 'profile.edit' enviando al usuario autenticado
        // como variable 'user', para mostrar sus datos actuales en el formulario.
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualiza la información del perfil del usuario.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Rellena los campos del usuario autenticado con los datos validados
        // por el formulario (usando la clase ProfileUpdateRequest).
        $request->user()->fill($request->validated());

        // Verifica si el usuario cambió su correo electrónico.
        // Si lo hizo, elimina la marca de verificación del correo.
        // Esto obliga al usuario a verificar su nuevo email.
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Guarda los cambios realizados en la base de datos.
        $request->user()->save();

        // Redirige nuevamente al formulario del perfil con un mensaje de éxito.
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Elimina la cuenta del usuario autenticado.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Valida que el usuario haya ingresado su contraseña actual antes de eliminar la cuenta.
        // Si no coincide, Laravel lanza un error automático.
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Obtiene al usuario autenticado actualmente.
        $user = $request->user();

        // Cierra la sesión del usuario.
        Auth::logout();

        // Elimina definitivamente al usuario de la base de datos.
        $user->delete();

        // Invalida la sesión actual para borrar los datos de sesión.
        $request->session()->invalidate();

        // Regenera el token CSRF por seguridad (previene ataques cross-site request forgery).
        $request->session()->regenerateToken();

        // Redirige a la página principal después de eliminar la cuenta.
        return Redirect::to('/');
    }
}
