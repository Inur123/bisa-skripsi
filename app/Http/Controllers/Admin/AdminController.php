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
                return $groups->pluck('total', 'kelompok')->toArray();
            });

        // Calculate total groups per faculty
        $totalGroupsPerFakultas = $groupData->map(function ($groups) {
            return count($groups);
        });

        // Retrieve user registration data for the week (Monday to Sunday)
        $registrations = User::select(
                \DB::raw('DATE(created_at) as date'),
                \DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->startOfWeek()) // Start of the week (Monday)
            ->where('created_at', '<=', now()->endOfWeek()) // End of the week (Sunday)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Kirim data ke view
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalMahasiswa',
            'totalAdmin',
            'totalOperator',
            'groupData',
            'totalMembersPerFakultas',
            'totalGroupsPerFakultas',
            'registrations' // Pass the retrieved registrations data to the view
        ));
    }


    /**
     * Show all users.
     */
    public function showAllUsers()
    {
        $mahasiswa = User::where('role', 'mahasiswa')->paginate(10);
        $admin = User::where('role', 'admin')->paginate(10);
        $operator = User::where('role', 'operator')->paginate(10);
        return view('admin.users', compact('mahasiswa', 'admin', 'operator'));
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

        // Group existing mahasiswa users by fakultas
        $existingGroups = User::where('role', 'mahasiswa')
            ->whereNotNull('kelompok')
            ->get()
            ->groupBy('fakultas');

        // Initialize an array to track the count of members in each group for round-robin assignment
        $groupStatus = [];

        // Populate the group status with existing groups
        foreach ($existingGroups as $fakultas => $mahasiswa) {
            $groupedByKelompok = $mahasiswa->groupBy('kelompok');
            foreach ($groupedByKelompok as $kelompok => $groupMembers) {
                $count = $groupMembers->count();
                $groupStatus[$fakultas][$kelompok] = $count; // Track the number of members in each group
            }
        }

        // Assign new users to groups in a round-robin manner
        foreach ($users as $user) {
            // Determine the faculty of the user
            $fakultas = $user->fakultas;

            // Check if the faculty has existing groups
            if (isset($groupStatus[$fakultas])) {
                // Find the next available group in the round-robin manner
                $assigned = false;
                foreach ($groupStatus[$fakultas] as $kelompok => $memberCount) {
                    if ($memberCount < 10) {
                        // Assign to the first available group with fewer than 10 members
                        $user->kelompok = $kelompok;
                        $user->save();
                        $groupStatus[$fakultas][$kelompok]++; // Increment the member count for this group
                        $assigned = true;
                        break; // Exit the loop once assigned
                    }
                }

                // If no available group was found, create a new one with the global index
                if (!$assigned) {
                    $user->kelompok = $globalGroupIndex; // Use the global group index
                    $user->save();

                    // Initialize the new group in the status
                    $groupStatus[$fakultas][$globalGroupIndex] = 1; // Start with 1 member
                    $globalGroupIndex++; // Increment the global group index for the next group
                }
            } else {
                // If there are no existing groups for this faculty, create a new group with the global index
                $user->kelompok = $globalGroupIndex; // Assign to the next global group
                $user->save();

                // Initialize the new group in the status
                $groupStatus[$fakultas][$globalGroupIndex] = 1; // Start with 1 member
                $globalGroupIndex++; // Increment for future groups
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


    //create data operator
    public function createOperator()
{
    return view('admin.create_operator'); // Create a view for the form
}
/**
 * Store a newly created operator in the database.
 */
public function storeOperator(Request $request)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'nim' => 'required|string|max:50', // NIM validation
        'email' => 'required|email|unique:users',
        'kelompok' => 'nullable|string',
        'fakultas' => 'nullable|string',
        'prodi' => 'nullable|string',
        'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // File is required
    ]);

    // Handle file upload before creating the user
    $filePath = $request->file('file')->store('files');

    // Prepare the data for user creation
    $data = [
        'name' => $request->name,
        'nim' => $request->nim,
        'email' => $request->email,
        'password' => bcrypt('password'), // Set default password
        'role' => 'operator', // Default role is operator
        'kelompok' => $request->kelompok,
        'fakultas' => $request->fakultas,
        'prodi' => $request->prodi,
        'file' => $filePath, // Include file path in user data
    ];

    // Create the user with the file path included
    User::create($data);

    return redirect()->route('admin.users')->with('success', 'Operator created successfully!');
}





}
