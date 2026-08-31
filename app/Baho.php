<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baho extends Model
{
    protected $table = 'baholar';

    protected $fillable = [
        'sinf_id',
        'oquvchi_id',
        'teacher_id',
        'fan',
        'sana',
        'baho',
        'izoh',
    ];

    protected $casts = [
        'sana' => 'date',
    ];

    public function sinf()
    {
        return $this->belongsTo(Sinf::class, 'sinf_id');
    }

    public function oquvchi()
    {
        return $this->belongsTo(Oquvchi::class, 'oquvchi_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}