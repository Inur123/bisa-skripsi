<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nim' => ['required', 'string', 'unique:users,nim'],
            'fakultas' => ['required', 'string', 'max:255'],
            'prodi' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf'],
            'kelompok' => ['nullable', 'string', 'max:255'],
            'nohp' => ['nullable', 'string', 'max:15'],
        'alamat' => ['nullable', 'string'],
        'jeniskelamin' => ['nullable', 'in:Laki-Laki,Perempuan'],
        'password_confirmation' => ['required', 'string', 'min:8'],
        'g-recaptcha-response' => ['required'],


        ]);
    }

    protected function create(array $data)
    {
        // Store the uploaded file and get the file path
        $filePath = $data['file']->store('uploads', 'public');

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nim' => $data['nim'],
            'fakultas' => $data['fakultas'],
            'prodi' => $data['prodi'],
            'file' => $filePath,
            'kelompok' => null, // Set to null; we will assign it later
            'role' => 'mahasiswa',
            'nohp' => $data['nohp'],
            'alamat' => $data['alamat'],
            'jeniskelamin' => $data['jeniskelamin'],

        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // Create the user
        $user = $this->create($request->all());

        // Assign user to a group
        $this->assignGroupToUser($user);

        // Redirect to the login page with a success message
        return redirect('/login')->with('success', 'Registration successful! You can now log in.');
    }

    protected function assignGroupToUser(User $user)
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

        // Assign the new user to a group in a round-robin manner
        $fakultas = $user->fakultas;

        // Check if the faculty has existing groups
        if (isset($groupStatus[$fakultas])) {
            // Find the next available group in the round-robin manner
            foreach ($groupStatus[$fakultas] as $kelompok => $memberCount) {
                if ($memberCount < 10) {
                    // Assign to the first available group with fewer than 10 members
                    $user->kelompok = $kelompok;
                    $user->save();
                    $groupStatus[$fakultas][$kelompok]++; // Increment the member count for this group
                    return; // Exit the method once assigned
                }
            }
        }

        // If no available group was found, create a new one with the global index
        $user->kelompok = $globalGroupIndex; // Use the global group index
        $user->save();

        // Initialize the new group in the status
        $groupStatus[$fakultas][$globalGroupIndex] = 1; // Start with 1 member
    }
}
