<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Default direktor foydalanuvchisi yaratish
     *
     * Email: director@school.uz
     * Password: Director123!
     *
     * @return void
     */
    public function run()
    {
        // Default direktor mavjud bo'lsa, skip qilish
        if (User::where('email', 'director@school.uz')->exists()) {
            echo "\n✓ Direktor allaqachon mavjud.\n";
            return;
        }

        // Yangi direktor yaratish
        User::create([
            'name' => 'Maktab Direktori',
            'email' => 'director@school.uz',
            'password' => bcrypt('Director123!'),
            'role' => 'director',
            'staff_id' => 'D-00001',
            'avatar' => null,
            'remember_token' => null,
        ]);

        echo "\n✓ Direktor muvaffaqiyatli yaratildi.\n";
        echo "  Email: director@school.uz\n";
        echo "  Password: Director123!\n";
    }
}
