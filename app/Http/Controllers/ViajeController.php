<?php

namespace App\Http\Controllers;

use App\Models\viaje;
use App\Models\destino;
use App\Models\hospedaje;
use App\Models\transporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ViajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viajes = viaje::with(['destino', 'hospedaje', 'transporte'])->latest()->get();
        return view('viajes.index', compact('viajes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('admin');
        $destinos = destino::where('activo', true)->get();
        $hospedajes = hospedaje::all();
        $transportes = transporte::all();
        
        return view('viajes.create', compact('destinos', 'hospedajes', 'transportes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('admin');

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'destino_id' => 'required|exists:destinos,id',
            'hospedaje_id' => 'required|exists:hospedajes,id',
            'transporte_id' => 'required|exists:transportes,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'precio_total' => 'required|numeric|min:0',
            'capacidad' => 'required|integer|min:1',
        ]);

        viaje::create($validated);

        return redirect()->route('viajes.index')->with('success', 'Paquete de viaje creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(viaje $viaje)
    {
        $viaje->load(['destino', 'hospedaje', 'transporte']);
        return view('viajes.show', compact('viaje'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(viaje $viaje)
    {
        Gate::authorize('admin');
        $destinos = destino::where('activo', true)->get();
        $hospedajes = hospedaje::all();
        $transportes = transporte::all();

        return view('viajes.edit', compact('viaje', 'destinos', 'hospedajes', 'transportes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, viaje $viaje)
    {
        Gate::authorize('admin');

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'destino_id' => 'required|exists:destinos,id',
            'hospedaje_id' => 'required|exists:hospedajes,id',
            'transporte_id' => 'required|exists:transportes,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'precio_total' => 'required|numeric|min:0',
            'capacidad' => 'required|integer|min:1',
        ]);

        $viaje->update($validated);

        return redirect()->route('viajes.index')->with('success', 'Paquete de viaje actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(viaje $viaje)
    {
        Gate::authorize('admin');
        $viaje->delete();
        return redirect()->route('viajes.index')->with('success', 'Paquete de viaje eliminado exitosamente.');
    }
}
