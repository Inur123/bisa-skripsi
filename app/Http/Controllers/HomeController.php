<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Redirect to different views based on user role
        switch ($user->role) {
            case 'admin':
                return view('home.admin'); // Admin view
            case 'operator':
                return view('home.operator'); // Operator view
            case 'mahasiswa':
                return view('home', ['user' => $user]);// Mahasiswa view
            default:
                abort(403, 'Unauthorized action.'); // Handle unauthorized access
        }
    }
}
