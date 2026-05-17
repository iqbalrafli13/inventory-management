<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'karyawan';

    protected $fillable = [
        'namaLengkap',
        'email',
        'nip',
        'divisi',
        'jabatan',
        'role',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
