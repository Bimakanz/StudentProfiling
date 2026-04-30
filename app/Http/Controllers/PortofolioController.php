<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class PortofolioController extends Controller
{
    /**
     * Tampilkan semua portofolio.
     */
    public function index(): JsonResponse
    {
        $portofolios = Portofolio::with('user:id,name,email')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => $portofolios,
        ]);
    }

    /**
     * Simpan portofolio baru.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'user_id'     => 'required|exists:users,id',
                'judul'       => 'required|string|max:255',
                'deskripsi'   => 'required|string',
                'link_github' => 'nullable|string|max:255',
                'thumbnail'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240', // Validasi file gambar atau PDF maksimal 10MB
                'kategori'    => 'required|string|max:255',
                'nilai'       => 'required|in:A,B,C,D',
                'jenis_porto' => 'required|string|max:255',
                'tools'       => 'required|string|max:255',
                'teknologi'   => 'required|string|max:255',
            ]);

            // Handle upload file thumbnail jika ada
            if ($request->hasFile('thumbnail')) {
                $path = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = url('storage/' . $path);
            }

            $portofolio = Portofolio::create($validated);

            return response()->json([
                'status'  => 'success',
                'message' => 'Portofolio berhasil dibuat.',
                'data'    => $portofolio,
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
     * Tampilkan satu portofolio berdasarkan ID.
     */
    public function show(string $id): JsonResponse
    {
        $portofolio = Portofolio::with('user:id,name,email')->find($id);

        if (!$portofolio) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Portofolio tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $portofolio,
        ]);
    }

    /**
     * Update portofolio berdasarkan ID.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $portofolio = Portofolio::find($id);

        if (!$portofolio) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Portofolio tidak ditemukan.',
            ], 404);
        }

        try {
            $validated = $request->validate([
                'user_id'     => 'sometimes|exists:users,id',
                'judul'       => 'sometimes|string|max:255',
                'deskripsi'   => 'sometimes|string',
                'link_github' => 'nullable|string|max:255',
                'thumbnail'   => 'nullable|string|max:255',
                'kategori'    => 'sometimes|string|max:255',
                'nilai'       => 'sometimes|in:A,B,C,D',
                'jenis_porto' => 'sometimes|string|max:255',
                'tools'       => 'sometimes|string|max:255',
                'teknologi'   => 'sometimes|string|max:255',
            ]);

            $portofolio->update($validated);

            return response()->json([
                'status'  => 'success',
                'message' => 'Portofolio berhasil diperbarui.',
                'data'    => $portofolio->fresh(),
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
     * Hapus portofolio berdasarkan ID.
     */
    public function destroy(string $id): JsonResponse
    {
        $portofolio = Portofolio::find($id);

        if (!$portofolio) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Portofolio tidak ditemukan.',
            ], 404);
        }

        $portofolio->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Portofolio berhasil dihapus.',
        ]);
    }
}
