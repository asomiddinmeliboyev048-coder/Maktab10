<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * Jadval nomi.
     */
    protected $table = 'books';

    /**
     * Mass assignment.
     */
    protected $fillable = [
        'title',
        'code',
        'author',
        'total_copies',
        'available_copies',
    ];

    /**
     * Kitob berilgan o'quvchilar tarixi.
     */
    public function bookIssues()
    {
        return $this->hasMany(
            BookIssue::class,
            'book_id'
        );
    }

    /**
     * Kitobni olgan o'quvchilar.
     */
    public function oquvchilar()
    {
        return $this->belongsToMany(
            Oquvchi::class,
            'book_issues',
            'book_id',
            'oquvchi_id'
        )
        ->withPivot([
            'given_date',
            'return_date',
            'status',
        ])
        ->withTimestamps();
    }
}
