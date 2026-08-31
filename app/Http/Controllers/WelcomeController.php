<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    /**
     * Bosh (marketing/landing) sahifa.
     *
     * welcome.blade.php hech qanday dinamik ma'lumotga bog'liq emas —
     * faqat Route::has('login') va @auth/@guest holatini tekshiradi,
     * shuning uchun bu yerda qo'shimcha ma'lumot uzatish shart emas.
     */
    public function index()
    {
        return view('welcome');
    }
}