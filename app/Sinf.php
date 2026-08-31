<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sinf extends Model
{
    /**
     * Sinflar jadvali.
     */
    protected $table = 'sinflar';

    /**
     * Mass assignment uchun ruxsat berilgan ustunlar.
     */
    protected $fillable = [
        'name',
        'teacher_id',
        'subject',
        'room',
    ];

    /**
     * Sinf rahbari.
     *
     * sinflar.teacher_id
     *        ↓
     * users.id
     */
    public function teacher()
    {
        return $this->belongsTo(
            User::class,
            'teacher_id',
            'id'
        );
    }

    public function darsJadvali()
{
    return $this->hasMany(DarsJadvali::class, 'sinf_id');
}


    /**
     * Ushbu sinfdagi o‘quvchilar.
     *
     * oquvchilar.sinf_id
     *        ↓
     * sinflar.id
     */
    public function oquvchilar()
    {
        return $this->hasMany(
            Oquvchi::class,
            'sinf_id',
            'id'
        );
    }

    /**
     * Sinfdagi o‘quvchilar soni.
     */
    public function getOquvchilarSoniAttribute()
    {
        return $this->oquvchilar()->count();
    }
}