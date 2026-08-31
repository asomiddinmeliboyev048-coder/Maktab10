<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oqituvchi extends Model
{
    protected $table = 'oqituvchilar';

    protected $fillable = [
        'title',
        'description',
        'price',
    ];
}