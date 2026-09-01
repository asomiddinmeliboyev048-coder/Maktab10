<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Maktab bazasidagi statistik ma'lumotlar
        $sinflar_soni = DB::table('sinflar')->count();
        $oquvchilar_soni = DB::table('oquvchilar')->count();
        $oqituvchilar_soni = DB::table('oqituvchilar')->count();
        $xonalar_soni = DB::table('xonalar')->count();

        // So'nggi qo'shilgan 5 ta o'quvchi
        $songgi_oquvchilar = DB::table('oquvchilar')
            ->leftJoin(
                'sinflar',
                'oquvchilar.sinf_id',
                '=',
                'sinflar.id'
            )
            ->select(
                'oquvchilar.*',
                'sinflar.nomi as sinf_nomi'
            )
            ->orderBy('oquvchilar.id', 'desc')
            ->limit(5)
            ->get();

        return view('home', compact(
            'sinflar_soni',
            'oquvchilar_soni',
            'oqituvchilar_soni',
            'xonalar_soni',
            'songgi_oquvchilar'
        ));
    }
}
