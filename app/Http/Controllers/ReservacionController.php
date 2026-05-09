<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservacion;
use App\Models\viaje;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

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
        // Typically reservations are created from the travel package view
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

        // Check availability (simplified for now)
        if ($viaje->reservaciones()->count() >= $viaje->capacidad) {
            return back()->with('error', 'Lo sentimos, este paquete de viaje ya no tiene lugares disponibles.');
        }

        $reservacion = Reservacion::create([
            'user_id' => Auth::id(),
            'viaje_id' => $viaje->id,
            'folio' => strtoupper(Str::random(8)),
            'estado' => 'confirmado',
            'monto_pagado' => $viaje->precio_total,
        ]);

        return redirect()->route('reservaciones.show', $reservacion)
                        ->with('success', '¡Reserva realizada con éxito! Tu folio es: ' . $reservacion->folio);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservacion $reservacion)
    {
        if (!Auth::user()->isAdmin() && $reservacion->user_id !== Auth::id()) {
            abort(403);
        }

        $reservacion->load(['user', 'viaje.destino', 'viaje.hospedaje', 'viaje.transporte']);
        return view('reservaciones.show', compact('reservacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservacion $reservacion)
    {
        Gate::authorize('admin');
        return view('reservaciones.edit', compact('reservacion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservacion $reservacion)
    {
        Gate::authorize('admin');

        $request->validate([
            'estado' => 'required|string|in:pendiente,confirmado,completado,cancelado',
        ]);

        $reservacion->update($request->only('estado'));

        return redirect()->route('reservaciones.index')
                        ->with('success', 'Estado de reservación actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservacion $reservacion)
    {
        if (!Auth::user()->isAdmin() && $reservacion->user_id !== Auth::id()) {
            abort(403);
        }

        $reservacion->delete();

        return redirect()->route('reservaciones.index')
                        ->with('success', 'Reservación eliminada.');
    }
}
