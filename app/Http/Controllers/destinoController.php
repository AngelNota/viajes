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
        $destinos = Destino::all();
        return view('destinos', compact('destinos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('admin');

        $request->validate([
            'nombre' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'pais' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'imagen.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['nombre', 'ciudad', 'pais', 'direccion']);

        if ($request->hasFile('imagen')) {
            $imagenes = [];
            foreach ($request->file('imagen') as $file) {
                $imagenes[] = $file->store('destinos', 'public');
            }
            $data['imagen'] = $imagenes;
        }

        destino::create($data);

        return redirect()->route('destinos.index')
                        ->with('success', 'Destino creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
