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
        $user = Auth::user();
        return view('mahasiswa.dashboard', compact('user')); // Points to resources/views/mahasiswa/dashboard.blade.php
    }
}
