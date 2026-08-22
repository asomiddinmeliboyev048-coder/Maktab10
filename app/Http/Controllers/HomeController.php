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
        $oqituvchilar_soni = Schema::hasTable('oqituvchilar') ? DB::table('oqituvchilar')->count() : 0;
        $xonalar_soni = Schema::hasTable('xonalar') ? DB::table('xonalar')->count() : 0;

        $songgi_oquvchilar = Schema::hasTable('oquvchilar') 
            ? DB::table('oquvchilar')
                ->leftJoin('sinflar', 'oquvchilar.sinf_id', '=', 'sinflar.id')
                ->select('oquvchilar.*', 'sinflar.nomi as sinf_nomi')
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