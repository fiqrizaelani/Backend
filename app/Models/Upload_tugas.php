<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload_tugas extends Model
{

    use HasFactory;

    protected $table = 'upload_tugas';

        protected $fillable = [
            'judul_tugas',
            'deskripsi',
            'lampiran', 
        ];
}
