<?php

namespace App\Http\Controllers\Operator;

use App\Models\Announcement;
use App\Http\Controllers\Controller;
use App\Models\User; // Import the User model

class OperatorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:operator']);
    }

    /**
     * Show the operator dashboard with student data.
     */
    public function dashboard()
{
    // Get the authenticated operator
    $operator = auth()->user();
    $announcements = Announcement::where('role', 'operator')
    ->where('is_active', true)  // Filter by active status
    ->latest()
    ->get();
    // Retrieve students who belong to the same group as the operator
    $students = User::where('kelompok', $operator->kelompok)
                    ->where('role', 'mahasiswa') // Assuming 'mahasiswa' is the role for students
                    ->get(['name', 'nim', 'email', 'kelompok', 'fakultas', 'prodi', 'file']); // Fetch the file column

    return view('operator.dashboard', compact('students','operator','announcements')); // Pass the students data to the view
}

}
