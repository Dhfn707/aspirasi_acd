<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanAbsen extends Model
{
    use HasFactory;

    /**
     * The connection associated with the model.
     *
     * @var string
     */
    protected $connection = 'absen_karyawan';

    protected $table = 'jabatan';

    protected $fillable = ['nama'];

    public $timestamps = false;

    public function aspirasis()
    {
        return $this->hasMany(Aspirasi::class, 'jabatan_id', 'id');
    }
}
