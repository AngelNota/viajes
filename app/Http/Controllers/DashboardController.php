<?php

namespace App\Http\Controllers;

use App\Models\destino;
use App\Models\hospedaje;
use App\Models\viaje;
use App\Models\Reservacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display dashboard metrics and recent travel activity.
     */
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        $totalDestinos = destino::count();
        $totalHospedajes = hospedaje::count();
        
        // Metrics based on user's reservations
        $totalViajes = Reservacion::where('user_id', $userId)->count();
        $gastoTotal = (float) Reservacion::where('user_id', $userId)->sum('monto_pagado');

        $proximosViajes = Reservacion::with(['viaje.destino'])
            ->where('user_id', $userId)
            ->whereHas('viaje', function($query) {
                $query->whereDate('fecha_inicio', '>=', now()->toDateString());
            })
            ->limit(4)
            ->get();

        $destinosRecientes = destino::latest()->limit(6)->get();

        $topPaises = destino::query()
            ->select('pais', DB::raw('COUNT(*) as total'))
            ->groupBy('pais')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $viajesMes = Reservacion::where('user_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('dashboard', compact(
            'totalDestinos',
            'totalHospedajes',
            'totalViajes',
            'gastoTotal',
            'proximosViajes',
            'destinosRecientes',
            'topPaises',
            'viajesMes'
        ));
    }
}
