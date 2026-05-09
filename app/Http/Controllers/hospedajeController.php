<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hospedaje;
use App\Models\destino;
use Illuminate\Support\Facades\Gate;

class hospedajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hospedajes = hospedaje::with('destino')->get();
        return view('hospedajes.index', compact('hospedajes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('admin');
        $destinos = destino::all();
        return view('hospedajes.create', compact('destinos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('admin');

        $request->validate([
            'destino_id' => 'required|exists:destinos,id',
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'precio_noche' => 'required|numeric|min:0',
            'habitaciones_disp' => 'required|integer|min:0',
            'imagen.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['destino_id', 'nombre', 'categoria', 'precio_noche', 'habitaciones_disp']);

        if ($request->hasFile('imagen')) {
            $imagenes = [];
            foreach ($request->file('imagen') as $file) {
                $imagenes[] = $file->store('hospedajes', 'public');
            }
            $data['imagen'] = json_encode($imagenes);
        }

        hospedaje::create($data);

        return redirect()->route('hospedajes.index')
                        ->with('success', 'Hospedaje creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(hospedaje $hospedaje)
    {
        $hospedaje->load('destino');
        return view('hospedajes.show', compact('hospedaje'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(hospedaje $hospedaje)
    {
        Gate::authorize('admin');
        $destinos = destino::all();
        return view('hospedajes.edit', compact('hospedaje', 'destinos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, hospedaje $hospedaje)
    {
        Gate::authorize('admin');

        $request->validate([
            'destino_id' => 'required|exists:destinos,id',
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'precio_noche' => 'required|numeric|min:0',
            'habitaciones_disp' => 'required|integer|min:0',
            'imagen.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['destino_id', 'nombre', 'categoria', 'precio_noche', 'habitaciones_disp']);

        if ($request->hasFile('imagen')) {
            $imagenes = [];
            foreach ($request->file('imagen') as $file) {
                $imagenes[] = $file->store('hospedajes', 'public');
            }
            $data['imagen'] = json_encode($imagenes);
        }

        $hospedaje->update($data);

        return redirect()->route('hospedajes.index')
                        ->with('success', 'Hospedaje actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(hospedaje $hospedaje)
    {
        Gate::authorize('admin');
        $hospedaje->delete();

        return redirect()->route('hospedajes.index')
                        ->with('success', 'Hospedaje eliminado exitosamente.');
    }
}
