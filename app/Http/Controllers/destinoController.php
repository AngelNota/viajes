<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\destino;
use Illuminate\Support\Facades\Gate;

class destinoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinos = destino::all();
        return view('destinos', compact('destinos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('admin');
        return view('destinos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('admin');

        $request->validate([
            'nombre' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_base' => 'required|numeric|min:0',
            'imagen.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['nombre', 'pais', 'descripcion', 'precio_base']);
        $data['activo'] = $request->has('activo');

        if ($request->hasFile('imagen')) {
            $imagenes = [];
            foreach ($request->file('imagen') as $file) {
                $imagenes[] = $file->store('destinos', 'public');
            }
            $data['imagen'] = json_encode($imagenes);
        }

        destino::create($data);

        return redirect()->route('destinos.index')
                        ->with('success', 'Destino creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(destino $destino)
    {
        return view('destinos.show', compact('destino'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(destino $destino)
    {
        Gate::authorize('admin');
        return view('destinos.edit', compact('destino'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, destino $destino)
    {
        Gate::authorize('admin');

        $request->validate([
            'nombre' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_base' => 'required|numeric|min:0',
            'imagen.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['nombre', 'pais', 'descripcion', 'precio_base']);
        $data['activo'] = $request->has('activo');

        if ($request->hasFile('imagen')) {
            $imagenes = [];
            foreach ($request->file('imagen') as $file) {
                $imagenes[] = $file->store('destinos', 'public');
            }
            $data['imagen'] = json_encode($imagenes);
        }

        $destino->update($data);

        return redirect()->route('destinos.index')
                        ->with('success', 'Destino actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(destino $destino)
    {
        Gate::authorize('admin');
        $destino->delete();

        return redirect()->route('destinos.index')
                        ->with('success', 'Destino eliminado exitosamente.');
    }
}
