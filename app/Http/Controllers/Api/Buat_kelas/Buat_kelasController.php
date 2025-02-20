<?php

namespace App\Http\Controllers\Api\Buat_kelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buat_kelas;

class Buat_kelasController extends Controller
{
    public function index()
{
    $data = Buat_kelas::all();
    \Log::info($data); // Tambahkan logging

    return response()->json($data, 200);
}

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kelas'    => 'required|string', 
            'nama_guru'     => 'required|string',
            'matapelajaran' => 'required|string',
        ]);

        $existingClass = Buat_kelas::where('nama_kelas', $request->nama_kelas)
            ->where('matapelajaran', $request->matapelajaran)
            ->first();

        if ($existingClass) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas dengan mata pelajaran ini sudah ada.'
            ], 422);
        }

        // Simpan data kelas ke database
        $kelas = Buat_kelas::create([
            'nama_kelas'    => $request->nama_kelas,
            'nama_guru'     => $request->nama_guru,
            'matapelajaran' => $request->matapelajaran,
        ]);

        $shareLink = url('/sharekelas/' . $kelas->id);

        return response()->json([
            'success'    => true,
            'message'    => 'Kelas berhasil dibuat',
            'data'       => $kelas,
            'share_link' => $shareLink,
        ], 201);
    }
}
