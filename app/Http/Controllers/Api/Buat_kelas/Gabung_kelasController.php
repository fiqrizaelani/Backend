<?php

namespace App\Http\Controllers\Api\Buat_kelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buat_kelas;
use App\Models\Peserta_kelas; // Buat model untuk menyimpan peserta kelas

class Gabung_kelasController extends Controller
{
    public function join(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_peserta' => 'required|string',
        ]);

        // Cari kelas berdasarkan ID dari link
        $kelas = Buat_kelas::find($id);

        if (!$kelas) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan.',
            ], 404);
        }

        // Cek apakah peserta sudah terdaftar di kelas ini
        $existingParticipant = Peserta_kelas::where('buat_kelas_id', $kelas->id)
            ->where('nama_peserta', $request->nama_peserta)
            ->first();

        if ($existingParticipant) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah bergabung di kelas ini.',
            ], 422);
        }

        // Tambahkan peserta ke kelas
        $peserta = Peserta_kelas::create([
            'buat_kelas_id' => $kelas->id,
            'nama_peserta'  => $request->nama_peserta,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil bergabung ke kelas.',
            'data'    => $peserta,
            'kelas'   => $kelas,
        ], 201);
    }
}
