<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelegramSubscriber extends Model
{
    protected $table = 'telegram_subscribers';

    protected $fillable = [
        'chat_id',
        'role',
        'oquvchi_id',
    ];

    public function oquvchi()
    {
        return $this->belongsTo(Oquvchi::class, 'oquvchi_id');
    }
}