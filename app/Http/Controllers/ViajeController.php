<?php

namespace App\Http\Controllers;

use App\Models\viaje;
use App\Models\destino;
use App\Models\hospedaje;
use App\Models\subtotal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viajes = viaje::with(['user', 'destino', 'hospedaje'])->latest()->get();
        return view('viajes.index', compact('viajes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $destinos = destino::all();
        $hospedajes = hospedaje::all();
        $usuarios = User::all();
        return view('viajes.create', compact('destinos', 'hospedajes', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'destino_id' => 'required|exists:destinos,id',
            'hospedaje_id' => 'required|exists:hospedajes,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'num_personas' => 'required|integer|min:1',
            'tipo_viaje' => 'required|string',
            'total' => 'required|numeric|min:0',
        ]);

        // Crear un subtotal ficticio o real según tu lógica de negocio
        $subtotal = subtotal::create([
            'costo' => $validated['total'],
        ]);

        $validated['subtotal_id'] = $subtotal->id;

        viaje::create($validated);

        return redirect()->route('viajes.index')->with('success', 'Viaje creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(viaje $viaje)
    {
        $viaje->load(['user', 'destino', 'hospedaje']);
        return view('viajes.show', compact('viaje'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(viaje $viaje)
    {
        $destinos = destino::all();
        $hospedajes = hospedaje::all();
        $usuarios = User::all();
        return view('viajes.edit', compact('viaje', 'destinos', 'hospedajes', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, viaje $viaje)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'destino_id' => 'required|exists:destinos,id',
            'hospedaje_id' => 'required|exists:hospedajes,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'num_personas' => 'required|integer|min:1',
            'tipo_viaje' => 'required|string',
            'total' => 'required|numeric|min:0',
        ]);

        $viaje->update($validated);

        return redirect()->route('viajes.index')->with('success', 'Viaje actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(viaje $viaje)
    {
        $viaje->delete();
        return redirect()->route('viajes.index')->with('success', 'Viaje eliminado exitosamente.');
    }
}
