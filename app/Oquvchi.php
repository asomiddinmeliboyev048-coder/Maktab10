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
        'kitoblar',
    ];

    /**
     * "kitoblar" ustuni JSON sifatida saqlanadi va
     * avtomatik array ko'rinishida qaytariladi.
     *
     * Struktura:
     * [
     *     'berilgan'   => ['Matematika', 'Fizika', ...],
     *     'berilmagan' => ['Biologiya', ...],
     * ]
     */
    protected $casts = [
        'kitoblar' => 'array',
    ];

    public function sinf()
    {
        return $this->belongsTo(
            Sinf::class,
            'sinf_id'
        );
    }

    /**
     * O'quvchiga tegishli barcha baholar.
     * Baho jadvalida bu o'quvchini bog'lovchi ustun
     * "oquvchi_id" deb taxmin qilindi.
     */
    public function baholar()
    {
        return $this->hasMany(
            Baho::class,
            'oquvchi_id'
        );
    }
}