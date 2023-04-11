<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bagian extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_bagian',
    ];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }

    public function task()
    {
        return $this->hasMany(Task::class);
    }

    public function golongan()
    {
        return $this->hasMany(Task::class);
    }
}
