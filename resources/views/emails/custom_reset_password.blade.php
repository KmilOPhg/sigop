<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Recuperación de cuenta - SIGOP</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;">
<div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 20px; border: 1px solid #ddd;">

    <h2 style="color: #0b5ed7; text-align: center;">Solicitud de Recuperación de Cuenta - SIGOP</h2>
    <p>Estimado(a) Administrador del Sistema,</p>
    <p>Por medio del presente correo, solicito la <strong>recuperación de mi cuenta de acceso al sistema SIGOP</strong>. A continuación detallo la información correspondiente:</p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; background: #f0f4ff;"><strong>Fecha de solicitud:</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{$fechaCreacion}}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; background: #f0f4ff;"><strong>Usuario SIGOP:</strong></td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{$user}}</td>
        </tr>
        <tr>
            {{-- url de recuperacion <a href="{{ $resetLink }}">{{ $resetLink }}</a> --}}
            <td style="padding: 8px; border: 1px solid #ddd; background: #f0f4ff;"><strong>Enlace de recuperación:</strong></td>
            <td style="padding: 16px; text-align: center;">
                <a href="{{ $resetLink }}"
                    style="
                    background-color: #0b5ed7;
                    color: #ffffff;
                    text-decoration: none;
                    font-weight: bold;
                    padding: 12px 24px;
                    border-radius: 6px;
                    display: inline-block;
                    font-family: Arial, Helvetica, sans-serif;
                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
                    transition: background-color 0.3s ease;
                ">
                    REESTABLECER CONTRASEÑA
                </a>
            </td>

        </tr>
    </table>

    <p>Gracias por su atención, quedo atento(a) a su confirmación.</p>

    <hr style="border: none; border-top: 1px solid #ddd; margin-top: 20px;">
    <p style="font-size: 12px; color: #777;">Este mensaje ha sido enviado automáticamente desde el sistema SIGOP o por solicitud directa del usuario.</p>

</div>
</body>
</html>
