<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    
    protected $fillable = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
