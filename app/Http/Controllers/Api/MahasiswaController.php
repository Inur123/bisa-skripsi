<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class MahasiswaController extends Controller
{
    /**
     * Get the total number of mahasiswa.
     *
     * @return JsonResponse
     */
    public function getTotalMahasiswa(): JsonResponse
    {
        // Hitung total mahasiswa
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();

        // Return JSON response
        return response()->json([
            'status' => 'success',
            'totalMahasiswa' => $totalMahasiswa,
        ]);
    }
}
