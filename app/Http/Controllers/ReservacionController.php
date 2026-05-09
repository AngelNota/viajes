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

        $viaje = viaje::findOrFail($request->viaje_id);

        if ($viaje->reservaciones()->count() >= $viaje->capacidad) {
            return back()->with('error', 'Lo sentimos, este paquete de viaje ya no tiene lugares disponibles.');
        }

        $reservacione = Reservacion::create([
            'user_id' => Auth::id(),
            'viaje_id' => $viaje->id,
            'folio' => strtoupper(Str::random(8)),
            'estado' => 'confirmado',
            'monto_pagado' => $viaje->precio_total,
        ]);

        // Enviar correo de confirmación
        try {
            Mail::to(Auth::user()->email)->send(new BookingConfirmed($reservacione->load(['user', 'viaje.destino', 'viaje.hospedaje'])));
        } catch (\Exception $e) {
            Log::error("Error enviando correo de confirmación de reserva: " . $e->getMessage());
        }

        // Redirect back with success and the ID for the modal
        return redirect()->route('viajes.index')
                        ->with('success', 'Tu compra ha sido exitosa. ¡Prepárate para la aventura!')
                        ->with('reservacion_id', $reservacione->id);
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
        Gate::authorize('admin');

        $request->validate([
            'estado' => 'required|string|in:pendiente,confirmado,completado,cancelado',
        ]);

        $oldEstado = $reservacione->estado;
        $reservacione->update($request->only('estado'));

        if ($reservacione->estado === 'cancelado' && $oldEstado !== 'cancelado') {
            try {
                Mail::to($reservacione->user->email)->send(new BookingCancelled($reservacione->load(['user', 'viaje.destino'])));
            } catch (\Exception $e) {
                Log::error("Error enviando correo de cancelación de reserva: " . $e->getMessage());
            }
        }

        return redirect()->route('reservaciones.index')
                        ->with('success', 'Estado de reservación actualizado.');
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

        $reservacione->delete();

        return redirect()->route('reservaciones.index')
                        ->with('success', 'Reservación eliminada.');
    }
}
