<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hospedaje;

class hospedajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hospedajes = hospedaje::all();
        return view('hospedajes.index', compact('hospedajes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not used as creation is in index
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'tipo' => 'required|string|max:255',
            'imagen.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['nombre', 'direccion', 'capacidad', 'tipo']);

        if ($request->hasFile('imagen')) {
            $imagenes = [];
            foreach ($request->file('imagen') as $file) {
                $imagenes[] = $file->store('hospedajes', 'public');
            }
            $data['imagen'] = $imagenes;
        }

        hospedaje::create($data);

        return redirect()->route('hospedajes.index')
                        ->with('success', 'Hospedaje creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hospedaje = hospedaje::findOrFail($id);
        return view('hospedajes.show', compact('hospedaje'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $hospedaje = hospedaje::findOrFail($id);
        return view('hospedajes.edit', compact('hospedaje'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'tipo' => 'required|string|max:255',
            'imagen.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $hospedaje = hospedaje::findOrFail($id);
        $data = $request->only(['nombre', 'direccion', 'capacidad', 'tipo']);

        if ($request->hasFile('imagen')) {
            $imagenes = [];
            foreach ($request->file('imagen') as $file) {
                $imagenes[] = $file->store('hospedajes', 'public');
            }
            $data['imagen'] = $imagenes;
        }

        $hospedaje->update($data);

        return redirect()->route('hospedajes.index')
                        ->with('success', 'Hospedaje actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hospedaje = hospedaje::findOrFail($id);
        $hospedaje->delete();

        return redirect()->route('hospedajes.index')
                        ->with('success', 'Hospedaje eliminado exitosamente.');
    }
}
