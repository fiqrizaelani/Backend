<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Upload_tugas;

class Upload_tugasController extends Controller
{
    /**
     * Upload tugas baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'lampiran'    => 'nullable|file|mimes:jpeg,jpg,png,mp4,avi,mov,wmv,pdf|max:20480', 
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $lampiranPath = $file->storeAs('uploads/tugas', $filename, 'public');
        }

        $tugas = Upload_tugas::create([
            'judul_tugas' => $validated['judul_tugas'],
            'deskripsi'   => $validated['deskripsi'] ?? '',
            'lampiran'    => $lampiranPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil diupload',
            'data' => [
                'judul_tugas' => $validated['judul_tugas'],
                'deskripsi'   => $validated['deskripsi'] ?? '',
                'lampiran'    => $lampiranPath ? asset('storage/' . $lampiranPath) : null,
            ]
        ], 201);
    }
}
