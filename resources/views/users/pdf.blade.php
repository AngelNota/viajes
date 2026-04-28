<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Usuarios - Viajes Atelier</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 2cm;
            color: #334155;
            line-height: 1.5;
        }
        .header {
            position: relative;
            margin-bottom: 2rem;
            border-bottom: 2px solid #0f6f79;
            padding-bottom: 1rem;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #0f6f79;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .title {
            font-size: 18px;
            color: #64748b;
            margin-top: 0.5rem;
        }
        .date {
            position: absolute;
            right: 0;
            top: 0;
            font-size: 12px;
            color: #94a3b8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th {
            background-color: #f8fafc;
            color: #475569;
            text-align: left;
            padding: 12px 8px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e2e8f0;
        }
        td {
            padding: 12px 8px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
        }
        tr:nth-child(even) {
            background-color: #fdfdfd;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: bold;
        }
        .badge-admin {
            background-color: #ffedd5;
            color: #9a3412;
        }
        .badge-user {
            background-color: #f1f5f9;
            color: #475569;
        }
        .footer {
            position: fixed;
            bottom: 1cm;
            left: 2cm;
            right: 2cm;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">Viajes Atelier</div>
        <div class="title">Reporte General de Usuarios</div>
        <div class="date">{{ $date }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td style="font-weight: bold;">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge badge-admin">Administrador</span>
                        @else
                            <span class="badge badge-user">Usuario</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        © {{ date('Y') }} Viajes Atelier. Este es un documento generado automáticamente.
    </div>
</body>
</html>
