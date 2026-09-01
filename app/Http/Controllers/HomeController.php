<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected function statsData()
    {
        $sinflar_soni = DB::table('sinflar')->count();
        $oquvchilar_soni = DB::table('oquvchilar')->count();
        $oqituvchilar_soni = DB::table('oqituvchilar')->count();
        $xonalar_soni = DB::table('xonalar')->count();

        $songgi_oquvchilar = DB::table('oquvchilar')
            ->leftJoin('sinflar', 'oquvchilar.sinf_id', '=', 'sinflar.id')
            ->select('oquvchilar.*', 'sinflar.nomi as sinf_nomi')
            ->orderBy('oquvchilar.id', 'desc')
            ->limit(5)
            ->get();

        return compact(
            'sinflar_soni',
            'oquvchilar_soni',
            'oqituvchilar_soni',
            'xonalar_soni',
            'songgi_oquvchilar'
        );
    }

    public function index()
    {
        return view('home', $this->statsData());
    }

    public function dashboard()
    {
        return view('dashboard', $this->statsData());
    }
}
