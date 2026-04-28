<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Viajes Atelier</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .header {
            background-color: #0f6f79;
            padding: 40px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .content {
            padding: 40px;
            color: #334155;
            line-height: 1.6;
        }
        .welcome-text {
            font-size: 18px;
            font-weight: bold;
            color: #0f6f79;
            margin-bottom: 20px;
        }
        .credentials {
            background-color: #f1f5f9;
            border-radius: 16px;
            padding: 24px;
            margin: 24px 0;
            border-left: 4px solid #0f6f79;
        }
        .credentials p {
            margin: 8px 0;
            font-size: 14px;
        }
        .credentials strong {
            color: #0f6f79;
        }
        .btn {
            display: inline-block;
            background-color: #0f6f79;
            color: #ffffff;
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }
        .footer {
            padding: 30px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Viajes Atelier</h1>
        </div>
        <div class="content">
            <p class="welcome-text">¡Hola, {{ $user->name }}!</p>
            <p>Es un gusto darte la bienvenida a nuestra plataforma. Tu cuenta ha sido creada exitosamente por el administrador.</p>
            
            <p>Aquí tienes tus credenciales de acceso para comenzar a explorar:</p>
            
            <div class="credentials">
                <p><strong>Usuario (Email):</strong> {{ $user->email }}</p>
                <p><strong>Contraseña:</strong> {{ $password }}</p>
            </div>
            
            <p>Te recomendamos cambiar tu contraseña una vez que hayas iniciado sesión por primera vez.</p>
            
            <div style="text-align: center;">
                <a href="{{ config('app.url') }}/login" class="btn">Acceder a mi cuenta</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Viajes Atelier. Todos los derechos reservados.</p>
            <p>Si no esperabas este correo, puedes ignorarlo con seguridad.</p>
        </div>
    </div>
</body>
</html>
