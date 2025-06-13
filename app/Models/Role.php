<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    protected $table = 'role';

    protected $primaryKey = 'id';
    protected $fillable = [
        'nama'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_role', 'id');
    }
}
