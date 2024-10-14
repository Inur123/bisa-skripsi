<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;

class OperatorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:operator']);
    }

    /**
     * Show the operator dashboard.
     */
    public function dashboard()
    {
        return view('operator.dashboard'); // Points to resources/views/operator/dashboard.blade.php
    }
}
