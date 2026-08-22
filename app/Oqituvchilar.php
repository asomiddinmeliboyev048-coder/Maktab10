<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Xizmatlar extends Model
{
    protected $table = 'xizmatlar';

    protected $fillable = [
        'title',
        'description',
        'price',
    ];
}