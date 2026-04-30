<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use App\Models\Sertifikasi;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Tampilkan data profil user berdasarkan ID.
     */
    public function show(int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'User tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'user'   => $user,
        ]);
    }

    /**
     * Update data profil user (termasuk upload foto profil).
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'User tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validate([
            'name'          => 'sometimes|string|max:255',
            'tempat_lahir'  => 'sometimes|nullable|string|max:255',
            'tanggal_lahir' => 'sometimes|nullable|date',
            'agama'         => 'sometimes|nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'jenis_kelamin' => 'sometimes|nullable|in:Laki-laki,Perempuan',
            'alamat'        => 'sometimes|nullable|string',
            'sosmed'        => 'sometimes|nullable|string|max:255',
            'github'        => 'sometimes|nullable|string|max:255',
            'instagram'     => 'sometimes|nullable|string|max:255',
            'linkedin'      => 'sometimes|nullable|string|max:255',
            'jurusan'       => 'sometimes|nullable|string|max:255',
            'kelas'         => 'sometimes|nullable|string|max:255',
            'foto_profil'   => 'sometimes|nullable|file|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Handle upload foto profil
        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $validated['foto_profil'] = url('storage/' . $path);
        }

        $user->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Profil berhasil diperbarui.',
            'user'    => $user->fresh(),
        ]);
    }

    /**
     * Hitung total portofolio milik user tertentu.
     */
    public function portofolioCount(int $id): JsonResponse
    {
        $count = Portofolio::where('user_id', $id)->count();

        return response()->json([
            'status' => 'success',
            'count'  => $count,
        ]);
    }

    /**
     * Hitung total sertifikasi milik user tertentu.
     */
    public function sertifikasiCount(int $id): JsonResponse
    {
        $count = Sertifikasi::where('user_id', $id)->count();

        return response()->json([
            'status' => 'success',
            'count'  => $count,
        ]);
    }
}
