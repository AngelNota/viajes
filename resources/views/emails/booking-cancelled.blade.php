<x-mail::message>
# Tu reservación ha sido cancelada

Hola {{ \$reservacion->user->name }},

Te informamos que tu reservación con el folio **{{ \$reservacion->folio }}** para el paquete **{{ \$reservacion->viaje->nombre }}** ha sido cancelada.

### Detalles de la Cancelación:
- **Folio:** {{ \$reservacion->folio }}
- **Paquete:** {{ \$reservacion->viaje->nombre }}
- **Estado actual:** Cancelado

<x-mail::panel>
Si tú no solicitaste esta cancelación o crees que se trata de un error, por favor ponte en contacto con nuestro equipo de soporte técnico lo antes posible.
</x-mail::panel>

Lamentamos los inconvenientes que esto pueda causarte.

Atentamente,<br>
El equipo de {{ config('app.name') }}
</x-mail::message>
