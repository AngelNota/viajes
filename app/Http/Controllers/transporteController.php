<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transporte;
use Illuminate\Support\Facades\Gate;

class transporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = transporte::query();

        // Search by origin or destination
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('origen', 'LIKE', "%{$search}%")
                  ->orWhere('destino', 'LIKE', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $transportes = $query->latest()->get();
        $tipos = transporte::select('tipo')->distinct()->pluck('tipo');

        return view('transportes.index', compact('transportes', 'tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('admin');
        return view('transportes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('admin');

        $validated = $request->validate([
            'tipo' => 'required|string|max:255',
            'origen' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'fecha_salida' => 'required|date',
        ]);

        transporte::create($validated);

        return redirect()->route('transportes.index')
                        ->with('success', 'Transporte creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(transporte $transporte)
    {
        return view('transportes.show', compact('transporte'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transporte $transporte)
    {
        Gate::authorize('admin');
        return view('transportes.edit', compact('transporte'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, transporte $transporte)
    {
        Gate::authorize('admin');

        $validated = $request->validate([
            'tipo' => 'required|string|max:255',
            'origen' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'capacidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'fecha_salida' => 'required|date',
        ]);

        $transporte->update($validated);

        return redirect()->route('transportes.index')
                        ->with('success', 'Transporte actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transporte $transporte)
    {
        Gate::authorize('admin');
        $transporte->delete();

        return redirect()->route('transportes.index')
                        ->with('success', 'Transporte eliminado exitosamente.');
    }
}
