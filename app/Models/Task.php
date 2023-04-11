<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'pegawai_id',
        'bagian_id',
        'nama_tugas',
        'tanggal',
        'keterangan',
        'lampiran',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function bagian()
    {
        return $this->belongsTo(Bagian::class);
    }

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }
}
