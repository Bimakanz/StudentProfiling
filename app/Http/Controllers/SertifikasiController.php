<?php

namespace App\Http\Controllers;

use App\Models\Sertifikasi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SertifikasiController extends Controller
{
    /**
     * Tampilkan semua sertifikasi.
     */
    public function index(): JsonResponse
    {
        $sertifikasis = Sertifikasi::with('user:id,name,email')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => $sertifikasis,
        ]);
    }

    /**
     * Simpan sertifikasi baru.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'user_id'          => 'required|exists:users,id',
                'nama_sertifikat'  => 'required|string|max:255',
                'lembaga_penerbit' => 'required|string|max:255',
                'tanggal_terbit'   => 'required|date',
                'nomor_sertifikat' => 'required|string|max:255|unique:sertifikasis,nomor_sertifikat',
                'file_sertifikat'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
                'deskripsi'        => 'required|string',
                'tools'            => 'required|string|max:255',
                'kategori'         => 'required|string|max:255',
                'jurusan'          => 'required|string|max:255',
            ]);

            if ($request->hasFile('file_sertifikat')) {
                $path = $request->file('file_sertifikat')->store('sertifikat', 'public');
                $validated['file_sertifikat'] = url('storage/' . $path);
            }

            $sertifikasi = Sertifikasi::create($validated);

            return response()->json([
                'status'  => 'success',
                'message' => 'Sertifikasi berhasil dibuat.',
                'data'    => $sertifikasi,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }
    }

    /**
     * Tampilkan satu sertifikasi.
     */
    public function show(string $id): JsonResponse
    {
        $sertifikasi = Sertifikasi::with('user:id,name,email')->find($id);

        if (!$sertifikasi) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sertifikasi tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $sertifikasi,
        ]);
    }

    /**
     * Update sertifikasi.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $sertifikasi = Sertifikasi::find($id);

        if (!$sertifikasi) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sertifikasi tidak ditemukan.',
            ], 404);
        }

        try {
            $validated = $request->validate([
                'user_id'          => 'sometimes|exists:users,id',
                'nama_sertifikat'  => 'sometimes|string|max:255',
                'lembaga_penerbit' => 'sometimes|string|max:255',
                'tanggal_terbit'   => 'sometimes|date',
                'nomor_sertifikat' => 'sometimes|string|max:255|unique:sertifikasis,nomor_sertifikat,' . $id,
                'file_sertifikat'  => 'nullable',
                'deskripsi'        => 'sometimes|string',
                'tools'            => 'sometimes|string|max:255',
                'kategori'         => 'sometimes|string|max:255',
                'jurusan'          => 'sometimes|string|max:255',
            ]);

            if ($request->hasFile('file_sertifikat')) {
                $path = $request->file('file_sertifikat')->store('sertifikat', 'public');
                $validated['file_sertifikat'] = url('storage/' . $path);
            }

            $sertifikasi->update($validated);

            return response()->json([
                'status'  => 'success',
                'message' => 'Sertifikasi berhasil diperbarui.',
                'data'    => $sertifikasi->fresh(),
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }
    }

    /**
     * Hapus sertifikasi.
     */
    public function destroy(string $id): JsonResponse
    {
        $sertifikasi = Sertifikasi::find($id);

        if (!$sertifikasi) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sertifikasi tidak ditemukan.',
            ], 404);
        }

        $sertifikasi->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Sertifikasi berhasil dihapus.',
        ]);
    }
}
