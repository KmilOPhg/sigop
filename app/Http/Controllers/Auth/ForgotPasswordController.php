<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\CustomResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function showLinkRequestForm()
    {
        $user = User::role('admin')->get(); //Ejemplo de obtención de usuarios con rol 'admin'

        return view('auth.passwords.email', compact('user')); // Tu vista de "Olvidé mi contraseña"
    }

    public function sendResetLinkEmail(Request $request)
    {

        try {
            // 1) Validamos el correo ingresado en el formulario
            $request->validate([
                'email' => 'required|email',
            ]);

            // 2) Buscamos al usuario por ese correo
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                // Si no existe, Laravel normalmente muestra este error
                return back()->withErrors(['email' => trans('passwords.user')]);
            }

            // 3) Generamos un token de restablecimiento para ESTE usuario
            $token = Password::getRepository()->create($user);

            // 4) Construimos el enlace que el usuario deberá abrir para resetear
            //    Ejemplo: http://dominio.com/password/reset/TOKEN?email=emailrecuperacion
            $resetLink = url(route('password.reset', [
                'token' => $token,
                'email' => $user->email,
            ], false));

            //Envio de correo de verificacion
            $emailAdmin = $request->email_admin;

            Mail::to($emailAdmin)
                ->send(new CustomResetPasswordMail($resetLink));

            // 6) Retornamos un mensaje de éxito
            Log::info('Email sent to ' . $emailAdmin);
            return back()->with('status', trans('passwords.sent'));
        } catch (\Exception $e) {
            Log::info('Error al enviar el correo de restablecimiento: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Error al enviar el correo de restablecimiento: ' . $e->getMessage()]);
        }
    }
}
