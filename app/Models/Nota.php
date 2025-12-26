<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Nota.php
class Nota extends Model
{
    protected $fillable = [
        'no',
        'tanggal_masuk',
        'kode_unit',
        'nama_driver',
        'status',
        'kerusakan',
        'harga',
        'items',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}

