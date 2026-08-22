<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Mass assignment uchun ruxsat berilgan ustunlar.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
        'subject',
    ];

    /**
     * JSON chiqarishda yashiriladigan ustunlar.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Sinf rahbari bo'lgan sinflar.
     */
    public function sinflar()
    {
        return $this->hasMany(
            Sinf::class,
            'teacher_id'
        );
    }

    /**
     * Foydalanuvchi direktorligini tekshirish.
     */
    public function isDirector()
    {
        return $this->role === 'director';
    }

    /**
     * Foydalanuvchi o'qituvchi ekanligini tekshirish.
     */
    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    /**
     * Avatar URL.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        return asset('assets/img/profile-img.jpg');
    }
}