<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservacion;
use App\Models\viaje;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmed;
use App\Mail\BookingCancelled;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Reservacion::with(['user', 'viaje.destino']);

        if (!Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        $reservaciones = $query->latest()->get();
        return view('reservaciones.index', compact('reservaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viajes = viaje::with('destino')->get();
        return view('reservaciones.create', compact('viajes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'viaje_id' => 'required|exists:viajes,id',
        ]);

        return DB::transaction(function () use ($request) {
            $viaje = viaje::with(['hospedaje', 'transporte'])->lockForUpdate()->findOrFail($request->viaje_id);

            if ($viaje->reservaciones()->count() >= $viaje->capacidad) {
                return back()->with('error', 'Lo sentimos, este paquete de viaje ya no tiene lugares disponibles.');
            }

            if ($viaje->hospedaje->habitaciones_disp <= 0) {
                return back()->with('error', 'Lo sentimos, ya no hay habitaciones disponibles en el hotel seleccionado.');
            }

            if ($viaje->transporte->capacidad <= 0) {
                return back()->with('error', 'Lo sentimos, ya no hay asientos disponibles en el transporte seleccionado.');
            }

            $reservacione = Reservacion::create([
                'user_id' => Auth::id(),
                'viaje_id' => $viaje->id,
                'folio' => strtoupper(Str::random(8)),
                'estado' => 'confirmado',
                'monto_pagado' => $viaje->precio_total,
            ]);

            $viaje->hospedaje->decrement('habitaciones_disp');
            $viaje->transporte->decrement('capacidad');

            try {
                Mail::to(Auth::user()->email)->send(new BookingConfirmed($reservacione->load(['user', 'viaje.destino', 'viaje.hospedaje'])));
            } catch (\Exception $e) {
                Log::error("Error enviando correo de confirmación de reserva: " . $e->getMessage());
            }

            return redirect()->route('viajes.index')
                            ->with('success', 'Tu compra ha sido exitosa. ¡Prepárate para la aventura!')
                            ->with('reservacion_id', $reservacione->id);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservacion $reservacione)
    {
        $user = Auth::user();
        
        $isAdmin = $user && $user->isAdmin();
        $isOwner = $user && ($reservacione->user_id == $user->id);

        if (!$isAdmin && !$isOwner) {
            abort(403, 'No tienes permiso para ver esta reservación.');
        }

        $reservacione->load(['user', 'viaje.destino', 'viaje.hospedaje', 'viaje.transporte']);
        return view('reservaciones.show', ['reservacion' => $reservacione]);
    }

    /**
     * Generate and download the PDF ticket.
     */
    public function downloadPdf(Reservacion $reservacione)
    {
        $user = Auth::user();
        $isAdmin = $user && $user->isAdmin();
        $isOwner = $user && ($reservacione->user_id == $user->id);

        if (!$isAdmin && !$isOwner) {
            abort(403);
        }

        $reservacione->load(['user', 'viaje.destino', 'viaje.hospedaje', 'viaje.transporte']);
        
        $pdf = Pdf::loadView('reservaciones.pdf', ['reservacion' => $reservacione]);
        
        return $pdf->download('ticket-viaje-' . $reservacione->folio . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservacion $reservacione)
    {
        Gate::authorize('admin');
        return view('reservaciones.edit', ['reservacion' => $reservacione]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservacion $reservacione)
    {
        $user = Auth::user();
        $isAdmin = $user && $user->isAdmin();
        $isOwner = $user && ($reservacione->user_id == $user->id);

        if (!$isAdmin && !$isOwner) {
            abort(403);
        }

        $request->validate([
            'estado' => 'required|string|in:pendiente,confirmado,completado,cancelado',
        ]);

        // RF-13: Security - If user is owner but not admin, they can ONLY set state to 'cancelado'
        if (!$isAdmin && $request->estado !== 'cancelado') {
            return back()->with('error', 'No tienes permiso para cambiar el estado a algo diferente de cancelado.');
        }

        return DB::transaction(function () use ($request, $reservacione) {
            $oldEstado = $reservacione->estado;
            $newEstado = $request->estado;

            $reservacione->update(['estado' => $newEstado]);

            if ($newEstado === 'cancelado' && $oldEstado !== 'cancelado') {
                $reservacione->viaje->hospedaje->increment('habitaciones_disp');
                $reservacione->viaje->transporte->increment('capacidad');

                try {
                    Mail::to($reservacione->user->email)->send(new BookingCancelled($reservacione->load(['user', 'viaje.destino'])));
                } catch (\Exception $e) {
                    Log::error("Error enviando correo de cancelación de reserva: " . $e->getMessage());
                }
            }
            elseif ($oldEstado === 'cancelado' && $newEstado !== 'cancelado') {
                $reservacione->viaje->hospedaje->decrement('habitaciones_disp');
                $reservacione->viaje->transporte->decrement('capacidad');
            }

            return redirect()->route('reservaciones.show', $reservacione)
                            ->with('success', 'La reservación ha sido actualizada exitosamente.');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservacion $reservacione)
    {
        $user = Auth::user();
        if (!($user && $user->isAdmin()) && ($reservacione->user_id != ($user->id ?? null))) {
            abort(403);
        }

        if ($reservacione->estado !== 'cancelado') {
            $reservacione->viaje->hospedaje->increment('habitaciones_disp');
            $reservacione->viaje->transporte->increment('capacidad');
        }

        $reservacione->delete();

        return redirect()->route('reservaciones.index')
                        ->with('success', 'Reservación eliminada y recursos liberados.');
    }
}
