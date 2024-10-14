<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        return view('admin.dashboard'); // Points to resources/views/admin/dashboard.blade.php
    }
}
