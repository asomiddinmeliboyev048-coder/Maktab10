<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oquvchi extends Model
{
    protected $table = 'oquvchilar';

    protected $fillable = [
        'student_id',
        'sinf_id',
        'fio',
        'phone',
        'address',
    ];


    /**
     * O'quvchi qaysi sinfga tegishli
     */
    public function sinf()
    {
        return $this->belongsTo(
            Sinf::class,
            'sinf_id'
        );
    }


    /**
     * O'quvchining kitoblari
     */
    public function bookIssues()
    {
        return $this->hasMany(
            BookIssue::class,
            'oquvchi_id'
        );
    }
}