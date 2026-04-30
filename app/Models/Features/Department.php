<?php

namespace App\Models\Features;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'department_code', 'code');
    }
}
