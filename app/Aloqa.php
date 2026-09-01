<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aloqa extends Model
{
    protected $table = 'aloqa';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
    ];
}
