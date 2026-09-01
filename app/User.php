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
     *
     * Ushbu massivga yangi xodim ma'lumotlari ham qo'shildi:
     *
     * - staff_id  -> xodimning avtomatik ID raqami
     * - login     -> tizimga kirish login'i
     * - subject   -> o'qituvchining fani
     * - phone     -> telefon raqami
     * - address   -> manzil
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
        'subject',
        'staff_id',
        'login',
        'phone',
        'address',
    ];

    /**
     * JSON chiqarishda yashiriladigan ustunlar.
     *
     * Password hech qachon foydalanuvchiga chiqarilmaydi.
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
     *
     * users.id -> sinflar.teacher_id
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
     *
     * role = director bo'lsa true qaytaradi.
     */
    public function isDirector()
    {
        return $this->role === 'director';
    }

    /**
     * Foydalanuvchi o'qituvchi ekanligini tekshirish.
     *
     * role = teacher bo'lsa true qaytaradi.
     */
    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    /**
     * Foydalanuvchi direktor o'rinbosari ekanligini tekshirish.
     *
     * Direktor o'rinbosari tizimda:
     *
     * role = deputy
     *
     * ko'rinishida saqlanadi.
     *
     * (Eslatma: bu metod avval 'deputy_director' ni tekshirar edi,
     * lekin haqiqiy bazadagi qiymat 'deputy' — shu yerda tuzatildi.)
     */
    public function isDeputyDirector()
    {
        return $this->role === 'deputy';
    }

    /**
     * Foydalanuvchi rahbariyat tarkibiga kirishini tekshirish.
     *
     * Director + Deputy Director
     */
    public function isManagement()
    {
        return in_array(
            $this->role,
            [
                'director',
                'deputy',
            ],
            true
        );
    }

    /**
     * Foydalanuvchi xodim ekanligini tekshirish.
     *
     * Hozirgi tizimdagi direktor,
     * direktor o'rinbosari va o'qituvchilar.
     */
    public function isStaff()
    {
        return in_array(
            $this->role,
            [
                'director',
                'deputy',
                'teacher',
            ],
            true
        );
    }

    /**
     * Avatar URL.
     *
     * Agar foydalanuvchining o'z avatari bo'lsa,
     * storage ichidagi rasm qaytariladi.
     *
     * Aks holda default profil rasmi ishlatiladi.
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        return asset('assets/img/profile-img.jpg');
    }
        /**
     * Foydalanuvchiga individual biriktirilgan ruxsatlar.
     * (Permission tizimi uchun qo'shildi.)
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions')->withTimestamps();
    }

    /**
     * Foydalanuvchida berilgan slug bo'yicha ruxsat bor-yo'qligini tekshiradi.
     *
     * Director va deputy — super admin: har doim true.
     * Teacher uchun bazadagi individual ruxsat tekshiriladi.
     *
     * Performance: $this->permissions bitta request davomida faqat
     * bir marta yuklanadi (Eloquent lazy-load keshlanadi), shuning
     * uchun bir nechta hasPermission() chaqirig'i qo'shimcha query
     * yubormaydi.
     */
    public function hasPermission(string $slug): bool
    {
        if ($this->isDirector() || $this->isDeputyDirector()) {
            return true;
        }

        return $this->permissions->contains('slug', $slug);
    }
}
