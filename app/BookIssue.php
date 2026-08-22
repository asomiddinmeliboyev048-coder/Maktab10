<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookIssue extends Model
{
    /**
     * Jadval nomi.
     */
    protected $table = 'book_issues';

    /**
     * Mass assignment.
     */
    protected $fillable = [
        'oquvchi_id',
        'book_id',
        'given_date',
        'return_date',
        'status',
    ];

    /**
     * Sana formatlari.
     */
    protected $dates = [
        'given_date',
        'return_date',
    ];

    /**
     * Kitobni olgan o'quvchi.
     */
    public function oquvchi()
    {
        return $this->belongsTo(
            Oquvchi::class,
            'oquvchi_id'
        );
    }

    /**
     * Berilgan kitob.
     */
    public function book()
    {
        return $this->belongsTo(
            Book::class,
            'book_id'
        );
    }
}