<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jabatan_id',
        'prioritas',
        'aspirasi',
        'status',
        'tanggapan_admin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jabatan()
    {
        return $this->belongsTo(JabatanAbsen::class, 'jabatan_id', 'id');
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}



