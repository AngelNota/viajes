<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\destino;
use Illuminate\Support\Facades\Gate;
use App\Traits\UploadsImages;

class destinoController extends Controller
{
    use UploadsImages;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = destino::query();

        // RF-03: Filter by Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('pais', 'LIKE', "%{$search}%")
                  ->orWhere('descripcion', 'LIKE', "%{$search}%");
            });
        }

        // RF-03: Filter by Country
        if ($request->filled('pais')) {
            $query->where('pais', $request->pais);
        }

        // RF-03: Filter by Availability (Active)
        if ($request->filled('disponible')) {
            if ($request->disponible == '1') $query->where('activo', true);
            if ($request->disponible == '0') $query->where('activo', false);
        }

        // RF-03: Sort logic
        if ($request->filled('sort')) {
            if ($request->sort === 'price_asc') $query->orderBy('precio_base', 'asc');
            elseif ($request->sort === 'price_desc') $query->orderBy('precio_base', 'desc');
            elseif ($request->sort === 'popular') $query->withCount('viajes')->orderBy('viajes_count', 'desc');
        } else {
            $query->latest();
        }

        $destinos = $query->get();
        $paises = destino::select('pais')->distinct()->pluck('pais');

        return view('destinos.index', compact('destinos', 'paises'));
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

        $data['imagen'] = $this->uploadMultipleImages($request, 'imagen', 'destinos');

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

        $newImages = $this->uploadMultipleImages($request, 'imagen', 'destinos');
        if ($newImages) {
            $data['imagen'] = $newImages;
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
