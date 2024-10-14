<?php
namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Show all users.
     */
    public function showAllUsers()
    {
        // Retrieve all users from the database with pagination
        $users = User::paginate(10);
        // Pass the users data to the view
        return view('admin.users', compact('users')); // Points to resources/views/admin/users.blade.php
    }

    /**
     * Show the edit form for a user.
     */
    public function editUser($id)
{
    $user = User::findOrFail($id); // Retrieve the user directly
    return view('admin.edit', compact('user')); // Pass user to the view
}

    /**
     * Update a user in the database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,operator,mahasiswa', // Validate role against enum values
            'nim' => 'nullable|string',
            'fakultas' => 'nullable|string',
            'prodi' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kelompok' => 'nullable|string',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role; // Directly update the role

        // Handle file upload
        if ($request->hasFile('file')) {
            if ($user->file) {
                Storage::delete($user->file); // Delete old file if it exists
            }
            $user->file = $request->file('file')->store('files');
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }


    /**
     * Delete a user from the database.
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
}
