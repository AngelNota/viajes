<?php

namespace App\Http\Controllers;

use App\Models\destino;
use App\Models\hospedaje;
use App\Models\viaje;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display dashboard metrics and recent travel activity.
     */
    public function index()
    {
        $userId = Auth::id();

        $totalDestinos = destino::count();
        $totalHospedajes = hospedaje::count();
        $totalViajes = viaje::where('user_id', $userId)->count();
        $gastoTotal = (float) viaje::where('user_id', $userId)->sum('total');

        $proximosViajes = viaje::with('destino')
            ->where('user_id', $userId)
            ->whereDate('fecha_inicio', '>=', now()->toDateString())
            ->orderBy('fecha_inicio')
            ->limit(4)
            ->get();

        $destinosRecientes = destino::latest()->limit(6)->get();

        $topPaises = destino::query()
            ->select('pais', DB::raw('COUNT(*) as total'))
            ->groupBy('pais')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $viajesMes = viaje::where('user_id', $userId)
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
