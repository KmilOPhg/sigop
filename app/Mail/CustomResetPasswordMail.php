<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class CustomResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetLink;

    /**
     * Recibe el enlace de reseteo
     */
    public function __construct($resetLink)
    {
        $this->resetLink = $resetLink;
    }

    /**
     * Construye el mensaje
     */
    public function build(Request $request)
    {
        //Fecha de creacion del password solo dia y hora
        $fechaCreacion = now()->format('d/m/Y');

        //Obtener nombre del modelo User
        $userAll = User::where('email', $request->email)->first();
        $user = $userAll->name;

        return $this->subject('Recuperación de contraseña')->view('emails.custom_reset_password', compact('user', 'fechaCreacion'));
    }
}
