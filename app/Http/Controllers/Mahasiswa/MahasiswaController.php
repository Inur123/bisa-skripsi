<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:mahasiswa']);
    }

    /**
     * Show the mahasiswa dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user(); // Retrieve the authenticated user

        return view('mahasiswa.dashboard', compact('user')); // Pass the user data to the view
    }
}
