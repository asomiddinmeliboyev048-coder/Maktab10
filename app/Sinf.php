<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sinf extends Model
{
    protected $table = 'sinflar';

    protected $fillable = [
        'name',
        'teacher_id',
        'room',
    ];


    public function teacher()
    {
        return $this->belongsTo(
            User::class,
            'teacher_id'
        );
    }


    public function oquvchilar()
    {
        return $this->hasMany(
            Oquvchi::class,
            'sinf_id'
        );
    }
}