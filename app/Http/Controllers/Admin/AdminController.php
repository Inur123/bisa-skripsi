<?php

namespace App\Http\Controllers\Admin;

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
    // Hitung total user berdasarkan role
    $totalUsers = User::count(); // Total semua user
    $totalMahasiswa = User::where('role', 'mahasiswa')->count();
    $totalAdmin = User::where('role', 'admin')->count();
    $totalOperator = User::where('role', 'operator')->count();

    // Calculate the total number of members in each faculty (fakultas)
    $totalMembersPerFakultas = User::where('role', 'mahasiswa')
        ->select('fakultas', \DB::raw('count(*) as total'))
        ->groupBy('fakultas')
        ->get()
        ->keyBy('fakultas');

    // Retrieve the latest group data from the database
    $groupData = User::where('role', 'mahasiswa')
        ->whereNotNull('kelompok')
        ->select('fakultas', 'kelompok', \DB::raw('count(*) as total'))
        ->groupBy('fakultas', 'kelompok')
        ->get()
        ->groupBy('fakultas')
        ->map(function ($groups) {
            // Convert the collection of groups to an array of group totals
            return $groups->pluck('total', 'kelompok')->toArray();
        });

    // Calculate total groups per faculty
    $totalGroupsPerFakultas = $groupData->map(function ($groups) {
        return count($groups); // Count the number of groups for each faculty
    });

    // Kirim data ke view
    return view('admin.dashboard', compact(
        'totalUsers',
        'totalMahasiswa',
        'totalAdmin',
        'totalOperator',
        'groupData', // Group data as array
        'totalMembersPerFakultas', // Include total members per faculty
        'totalGroupsPerFakultas' // Include total groups per faculty
    ));
}


    /**
     * Show all users.
     */
    public function showAllUsers()
    {
        $users = User::paginate(10);
        return view('admin.users', compact('users'));
    }

    /**
     * Assign users to groups dynamically.
     */
    public function assignGroups()
    {
        // Retrieve all 'mahasiswa' users who are not yet assigned to a group
        $users = User::where('role', 'mahasiswa')->whereNull('kelompok')->get();

        // Find the highest existing group index to continue numbering correctly
        $lastGroupIndex = User::where('role', 'mahasiswa')
            ->whereNotNull('kelompok')
            ->max(\DB::raw('CAST(kelompok AS UNSIGNED)')) ?? 0;

        // Start assigning groups from the next available index
        $globalGroupIndex = $lastGroupIndex + 1;

        // Group users by their faculty (fakultas)
        $groupedUsers = $users->groupBy('fakultas');

        // Iterate through each faculty group
        foreach ($groupedUsers as $fakultas => $mahasiswa) {
            // Track the number of members in the current group
            $memberCount = 0;

            // Assign each student to a group across faculties
            foreach ($mahasiswa as $user) {
                // Check if we need to start a new group
                if ($memberCount == 10) {
                    $globalGroupIndex++; // Increment the global group index for the next group
                    $memberCount = 0; // Reset the member count
                }

                // Assign the user to the current group
                $user->kelompok = $globalGroupIndex; // Use the global group index
                $user->save();

                // Increment member count for the current group
                $memberCount++;
            }

            // After processing each faculty, we ensure to keep incrementing the global index
            // This will allow for a new group index to be set correctly for the next faculty
            if ($memberCount > 0) {
                $globalGroupIndex++; // Move to the next group index after finishing a faculty
            }
        }

        return redirect()->route('admin.users')
            ->with('success', 'Mahasiswa users have been assigned to groups successfully!');
    }


    public function clearGroups()
    {
        // Clear group data only for 'mahasiswa' users
        User::where('role', 'mahasiswa')->update(['kelompok' => null]);

        return redirect()->route('admin.users')->with('success', 'Group data for mahasiswa users has been cleared successfully!');
    }

    public function clearMahasiswa()
{
    // Retrieve all 'mahasiswa' users
    $mahasiswaUsers = User::where('role', 'mahasiswa')->get();

    foreach ($mahasiswaUsers as $user) {
        // Delete file if it exists
        if ($user->file) {
            Storage::delete($user->file);
        }

        // Delete the user
        $user->delete();
    }

    return redirect()->route('admin.users')->with('success', 'All mahasiswa users and their data have been cleared successfully!');
}

    /**
     * Show the edit form for a user.
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));
    }

    /**
     * Update a user in the database.
     */
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,operator,mahasiswa',
            'nim' => 'nullable|string',
            'fakultas' => 'nullable|string',
            'prodi' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kelompok' => 'nullable|string',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Handle file upload
        if ($request->hasFile('file')) {
            if (!empty($user->file)) {
                Storage::delete($user->file);
            }
            $user->file = $request->file('file')->store('files');
        }

        $user->nim = $request->nim;
        $user->fakultas = $request->fakultas;
        $user->prodi = $request->prodi;
        $user->kelompok = $request->kelompok;

        $user->save();

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }

    /**
     * Delete a user from the database.
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->file) {
            Storage::delete($user->file);
        }
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
}
