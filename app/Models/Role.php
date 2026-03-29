<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The connection associated with the model.
     *
     * @var string
     */
    protected $connection = 'absen_karyawan';

    protected $table = 'user_roles';
    protected $fillable = ['name'];

    /**
     * Get all users with this role
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
