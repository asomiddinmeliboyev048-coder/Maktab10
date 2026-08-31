<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        // Jadvallar mavjud bo'lsa ma'lumotlarni oladi, bo'lmasa 0 ko'rsatadi
        $sinflar_soni = Schema::hasTable('sinflar') ? DB::table('sinflar')->count() : 0;
        $oquvchilar_soni = Schema::hasTable('oquvchilar') ? DB::table('oquvchilar')->count() : 0;

        // Diqqat: loyihangizda o'qituvchilar alohida "oqituvchilar" jadvalida emas,
        // "users" jadvalida role='teacher' sifatida saqlanadi (User.php modeliga qarang).
        // Shu sabab "oqituvchilar" jadvali odatda mavjud bo'lmaydi va bu 0 qaytaradi.
        // Agar haqiqiy o'qituvchilar sonini ko'rsatmoqchi bo'lsangiz, pastdagi
        // izohli qatorni oching.
        $oqituvchilar_soni = Schema::hasTable('oqituvchilar')
            ? DB::table('oqituvchilar')->count()
            : (Schema::hasTable('users') ? DB::table('users')->where('role', 'teacher')->count() : 0);

        $xonalar_soni = Schema::hasTable('xonalar') ? DB::table('xonalar')->count() : 0;

        $songgi_oquvchilar = Schema::hasTable('oquvchilar')
            ? DB::table('oquvchilar')
                ->leftJoin('sinflar', 'oquvchilar.sinf_id', '=', 'sinflar.id')
                ->select(
                    'oquvchilar.*',
                    'sinflar.name as sinf_nomi',
                    // home.blade.php "->telefon" deb kutadi, jadvalda ustun nomi "phone" —
                    // shu sabab taxallus (alias) beriladi.
                    'oquvchilar.phone as telefon'
                )
                ->orderBy('oquvchilar.id', 'desc')
                ->limit(5)
                ->get()
            : [];

        return view('home', compact(
            'sinflar_soni',
            'oquvchilar_soni',
            'oqituvchilar_soni',
            'xonalar_soni',
            'songgi_oquvchilar'
        ));
    }
}