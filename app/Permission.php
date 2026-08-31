<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
        'module',
        'module_name',
        'action',
        'slug',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions')->withTimestamps();
    }
}