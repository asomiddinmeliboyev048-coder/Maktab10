<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DarsJadvali extends Model
{
    protected $table = 'dars_jadvallari';

    protected $fillable = [
        'sinf_id',
        'sinf_name',
        'oqituvchi_id',
        'oqituvchi_ism',
        'kun',
        'tartib',
        'dars_raqami',
        'vaqti',
        'fan',
    ];

    public function sinf()
    {
        return $this->belongsTo(Sinf::class, 'sinf_id');
    }

    public function oqituvchi()
    {
        return $this->belongsTo(User::class, 'oqituvchi_id');
    }
}