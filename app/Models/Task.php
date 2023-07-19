<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'bidang_id',
        'level',
        'nama_tugas',
        'keterangan',
        'lampiran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
