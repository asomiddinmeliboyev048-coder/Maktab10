<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Yangiliklar extends Model
{
    // Laravel 's' qo'shib olmasligi uchun jadval nomini aniq belgilaymiz:
    protected $table = 'yangiliklar';

    protected $fillable = [
        'title',
        'content',
        'image',
    ];
}