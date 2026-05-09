<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Mail\WelcomeUser;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        Gate::authorize('admin');

        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        Gate::authorize('admin');

        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('admin');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:user,admin',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Enviar correo de bienvenida
        try {
            Mail::to($user->email)->send(new WelcomeUser($user, $validated['password']));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error enviando correo a {$user->email}: " . $e->getMessage());
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente y correo de bienvenida enviado.');
    }

    /**
     * RF-21: Show user profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    /**
     * RF-21: Update user profile
     */
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->phone = $validated['phone'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Perfil actualizado exitosamente.');
    }

    /**
     * Export users to Excel.
     */
    public function export()
    {
        Gate::authorize('admin');

        return Excel::download(new UsersExport, 'usuarios-viajes-atelier.xlsx');
    }

    /**
     * Export users to PDF.
     */
    public function exportPdf()
    {
        Gate::authorize('admin');

        $users = User::all();
        $date = now()->translatedFormat('d F Y, H:i');
        
        $pdf = Pdf::loadView('users.pdf', compact('users', 'date'));
        
        return $pdf->download('usuarios-viajes-atelier.pdf');
    }

    /**
     * Import users from Excel.
     */
    public function import(Request $request)
    {
        Gate::authorize('admin');

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new UsersImport, $request->file('file'));

        return redirect()->route('users.index')->with('success', 'Usuarios importados exitosamente.');
    }
}
