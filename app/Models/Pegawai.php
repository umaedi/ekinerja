<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pegawai extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'bagian_id',
        'jabatan_id',
        'nip',
        'name',
        'golongan',
        'email',
        'no_tlp',
        'password',
        'img',
        'role',
        'remember_token',
    ];

    public function task()
    {
        return $this->hasMany(Task::class);
    }

    public function bagian()
    {
        return $this->belongsTo(Bagian::class);
    }
}
