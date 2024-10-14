<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Redirect users to their respective dashboards after login.
     */
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'operator':
                return redirect()->route('operator.dashboard');
            case 'mahasiswa':
                return redirect()->route('mahasiswa.dashboard');
            default:
                abort(403, 'Unauthorized action.');
        }
    }
}
