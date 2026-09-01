<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    protected function statsData()
    {
        $sinflar_soni = Schema::hasTable('sinflar') ? DB::table('sinflar')->count() : 0;
        $oquvchilar_soni = Schema::hasTable('oquvchilar') ? DB::table('oquvchilar')->count() : 0;

        if (Schema::hasTable('oqituvchilar')) {
            $oqituvchilar_soni = DB::table('oqituvchilar')->count();
        } elseif (Schema::hasTable('users')) {
            $oqituvchilar_soni = DB::table('users')->where('role', 'teacher')->count();
        } else {
            $oqituvchilar_soni = 0;
        }

        $xonalar_soni = Schema::hasTable('xonalar')
            ? DB::table('xonalar')->count()
            : $sinflar_soni;

        $songgi_oquvchilar = Schema::hasTable('oquvchilar')
            ? DB::table('oquvchilar')
                ->leftJoin('sinflar', 'oquvchilar.sinf_id', '=', 'sinflar.id')
                ->select('oquvchilar.*', 'sinflar.nomi as sinf_nomi')
                ->orderBy('oquvchilar.id', 'desc')
                ->limit(5)
                ->get()
            : collect();

        return compact(
            'sinflar_soni',
            'oquvchilar_soni',
            'oqituvchilar_soni',
            'xonalar_soni',
            'songgi_oquvchilar'
        );
    }

    public function redirectToLogin()
    {
        return redirect()->route('login');
    }

    public function index()
    {
        return view('home', $this->statsData());
    }

    public function dashboard()
    {
        return view('dashboard', $this->statsData());
    }

    public function xonalarIndex()
    {
        return view('placeholder', ['title' => 'Xonalar']);
    }

    public function hisobotlarIndex()
    {
        return view('placeholder', ['title' => 'Hisobotlar']);
    }

    public function teacherTest()
    {
        return 'O‘qituvchi paneli ishlayapti!';
    }

    public function diagnostikaLogin()
    {
        if (!Schema::hasTable('users')) {
            return response()->json([
                'status' => 'error',
                'message' => 'users jadvali mavjud emas.'
            ]);
        }

        $user = DB::table('users')
            ->select('id', 'name', 'email', 'role')
            ->where('email', 'director@school.uz')
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'director@school.uz Render database ichida topilmadi.'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Direktor Render database ichida mavjud.',
            'user' => $user
        ]);
    }
}
