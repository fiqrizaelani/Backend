<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buat_kelas extends Model
{
    use HasFactory;

    protected $table = 'buat_kelas';

    protected $fillable = [
        'nama_kelas',
        'matapelajaran',
        'nama_guru',
    ];
}
