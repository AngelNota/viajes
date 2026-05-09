<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Reservación - {{ $reservacion->folio }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; }
        .header { border-bottom: 2px solid #4f46e5; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #4f46e5; }
        .folio-box { background: #f3f4f6; padding: 15px; border-radius: 10px; text-align: right; }
        .folio-title { font-size: 12px; text-transform: uppercase; color: #6b7280; }
        .folio-number { font-size: 20px; font-weight: bold; color: #4f46e5; }
        .section-title { font-size: 14px; font-weight: bold; text-transform: uppercase; border-bottom: 1px solid #e5e7eb; padding-bottom: 5px; margin-top: 25px; margin-bottom: 10px; }
        .grid { width: 100%; }
        .grid td { vertical-align: top; width: 50%; }
        .label { font-size: 10px; color: #9ca3af; text-transform: uppercase; font-weight: bold; }
        .value { font-size: 14px; font-weight: bold; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 20px; }
        .price-box { margin-top: 30px; background: #4f46e5; color: white; padding: 20px; border-radius: 15px; text-align: center; }
        .price-label { font-size: 12px; text-transform: uppercase; }
        .price-value { font-size: 32px; font-weight: 900; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="logo">Viajes Atelier</div>
                    <div style="font-size: 12px; color: #6b7280;">Explorador Creativo</div>
                </td>
                <td style="text-align: right;">
                    <div class="folio-box">
                        <div class="folio-title">Folio de Reserva</div>
                        <div class="folio-number">#{{ $reservacion->folio }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <h1 style="font-size: 24px; margin-bottom: 5px;">{{ $reservacion->viaje->nombre }}</h1>
    <p style="color: #4f46e5; font-size: 18px; margin-top: 0;">{{ $reservacion->viaje->destino->nombre }}, {{ $reservacion->viaje->destino->pais }}</p>

    <div class="section-title">Información del Pasajero</div>
    <table class="grid">
        <tr>
            <td>
                <div class="label">Nombre completo</div>
                <div class="value">{{ $reservacion->user->name }}</div>
            </td>
            <td>
                <div class="label">Correo electrónico</div>
                <div class="value">{{ $reservacion->user->email }}</div>
            </td>
        </tr>
    </table>

    <div class="section-title">Detalles del Itinerario</div>
    <table class="grid">
        <tr>
            <td>
                <div class="label">Fecha de Salida</div>
                <div class="value">{{ \Carbon\Carbon::parse($reservacion->viaje->fecha_inicio)->format('d/m/Y') }}</div>
            </td>
            <td>
                <div class="label">Fecha de Regreso</div>
                <div class="value">{{ \Carbon\Carbon::parse($reservacion->viaje->fecha_fin)->format('d/m/Y') }}</div>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 15px;">
                <div class="label">Alojamiento</div>
                <div class="value">{{ $reservacion->viaje->hospedaje->nombre }}</div>
                <div style="font-size: 12px;">{{ $reservacion->viaje->hospedaje->categoria }}</div>
            </td>
            <td style="padding-top: 15px;">
                <div class="label">Transporte</div>
                <div class="value">{{ $reservacion->viaje->transporte->tipo }}</div>
                <div style="font-size: 12px;">{{ $reservacion->viaje->transporte->origen }} -> {{ $reservacion->viaje->transporte->destino }}</div>
            </td>
        </tr>
    </table>

    <div class="price-box">
        <div class="price-label">Monto Total Pagado</div>
        <div class="price-value">${{ number_format($reservacion->monto_pagado, 2) }} MXN</div>
        <div style="font-size: 11px; opacity: 0.8; margin-top: 5px;">Impuestos y cargos de servicio incluidos</div>
    </div>

    <div class="footer">
        <p>Este documento sirve como comprobante oficial de su reservación.</p>
        <p><strong>Agencia de Viajes Atelier</strong> | San Luis Potosí, México</p>
        <p style="font-size: 10px; margin-top: 10px;">Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
