<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Davomat extends Model
{
    protected $table = 'davomatlar';

    protected $fillable = [
        'sinf_id',
        'oquvchi_id',
        'teacher_id',
        'sana',
        'status',
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

    public static function statusLabels()
    {
        return [
            'keldi' => ['label' => 'Keldi',                 'badge' => 'success'],
            'sz'    => ['label' => 'Sababsiz kelmadi',       'badge' => 'danger'],
            'sb'    => ['label' => 'Sababli kelmadi',        'badge' => 'warning'],
            'kq'    => ['label' => 'Kelgan, qatnashmagan',   'badge' => 'secondary'],
            'kc'    => ['label' => 'Kechikkan',              'badge' => 'info'],
        ];
    }
}