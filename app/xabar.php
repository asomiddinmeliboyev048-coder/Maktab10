<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Xabar extends Model
{
    protected $table = 'xabarlar';

    protected $fillable = [
        'sinf_id',
        'teacher_id',
        'sana',
        'turi',
        'is_read',
    ];

    protected $casts = [
        'sana' => 'date',
        'is_read' => 'boolean',
    ];

    public function sinf()
    {
        return $this->belongsTo(Sinf::class, 'sinf_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Turi (davomat/baho) uchun o'zbekcha nom, ikonka va rang.
     */
    public static function turiLabels()
    {
        return [
            'davomat' => ['label' => 'Davomat belgiladi', 'icon' => '📅', 'badge' => 'info'],
            'baho'    => ['label' => 'Baho qo\'ydi',       'icon' => '⭐', 'badge' => 'warning'],
        ];
    }
}