<x-mail::message>
# ¡Tu reservación está confirmada!

Hola {{ \$reservacion->user->name }},

Gracias por confiar en **Agencia de Viajes Atelier**. Nos complace informarte que tu reservación para el paquete **{{ \$reservacion->viaje->nombre }}** ha sido procesada con éxito.

<x-mail::panel>
**Detalles de tu Folio:**
# {{ \$reservacion->folio }}
</x-mail::panel>

### Resumen del Viaje:
- **Destino:** {{ \$reservacion->viaje->destino->nombre }}, {{ \$reservacion->viaje->destino->pais }}
- **Fecha de Salida:** {{ \Carbon\Carbon::parse(\$reservacion->viaje->fecha_inicio)->format('d/m/Y') }}
- **Alojamiento:** {{ \$reservacion->viaje->hospedaje->nombre }}
- **Monto Pagado:** \${{ number_format(\$reservacion->monto_pagado, 2) }} MXN

<x-mail::button :url="route('reservaciones.show', \$reservacion)">
Ver detalles y descargar ticket
</x-mail::button>

Si tienes alguna duda o necesitas realizar cambios en tu itinerario, por favor contáctanos respondiendo a este correo.

¡Buen viaje!,<br>
El equipo de {{ config('app.name') }}
</x-mail::message>
