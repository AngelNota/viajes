<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hospedaje;
use App\Models\destino;
use Illuminate\Support\Facades\Gate;
use App\Traits\UploadsImages;

class hospedajeController extends Controller
{
    use UploadsImages;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = hospedaje::with('destino');

        // Search by name
        if ($request->filled('search')) {
            $query->where('nombre', 'LIKE', "%{$request->search}%");
        }

        // Filter by category
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        // Filter by destination
        if ($request->filled('destino_id')) {
            $query->where('destino_id', $request->destino_id);
        }

        $hospedajes = $query->latest()->get();
        $categorias = hospedaje::select('categoria')->distinct()->pluck('categoria');
        $destinos = destino::all();

        return view('hospedajes.index', compact('hospedajes', 'categorias', 'destinos'));
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

        // Refactor: Using Trait logic
        $data['imagen'] = $this->uploadMultipleImages($request, 'imagen', 'hospedajes');

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

        // Refactor: Using Trait logic
        $newImages = $this->uploadMultipleImages($request, 'imagen', 'hospedajes');
        if ($newImages) {
            $data['imagen'] = $newImages;
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
