<?php

namespace App\Http\Controllers;

use App\Sinf;
use App\Oquvchi;
use Illuminate\Http\Request;

class KutubxonaController extends Controller
{
    /**
     * Kutubxona bosh sahifasi.
     *
     * Yuqorida: umumiy berilgan/berilmagan kitoblar soni (tugmalar bilan).
     * Pastda: Sinflar bo'limidagi kabi har bir sinf alohida qatorda,
     * "ko'rish" va "kitob" ikonkalari bilan.
     *
     * GET /kutubxona
     */
    public function index(Request $request)
    {
        $oquvchilar = Oquvchi::all();

        $totalBerilgan = 0;
        $totalBerilmagan = 0;

        foreach ($oquvchilar as $oquvchi) {
            $totalBerilgan += count($oquvchi->kitoblar['berilgan'] ?? []);
            $totalBerilmagan += count($oquvchi->kitoblar['berilmagan'] ?? []);
        }

        $query = Sinf::withCount('oquvchilar');

        /*
        |--------------------------------------------------------------------------
        | Qidiruv: sinf nomi, o'quvchi F.I.O yoki Student ID bo'yicha
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('oquvchilar', function ($sq) use ($search) {
                      $sq->where('fio', 'like', '%' . $search . '%')
                         ->orWhere('student_id', 'like', '%' . $search . '%');
                  });
            });
        }

        $sinflar = $query->orderBy('name', 'asc')->get();

        return view('kutubxona.index', compact(
            'sinflar', 'totalBerilgan', 'totalBerilmagan'
        ));
    }

    /**
     * Kitobi berilgan o'quvchilar ro'yxati.
     *
     * GET /kutubxona/berilgan
     */
    public function berilgan(Request $request)
    {
        $oquvchilar = $this->filteredOquvchilar($request, 'berilgan');
        $sinflar = Sinf::orderBy('name')->get();

        return view('kutubxona.berilgan', compact('oquvchilar', 'sinflar'));
    }

    /**
     * Kitobi berilmagan o'quvchilar ro'yxati.
     *
     * GET /kutubxona/berilmagan
     */
    public function berilmagan(Request $request)
    {
        $oquvchilar = $this->filteredOquvchilar($request, 'berilmagan');
        $sinflar = Sinf::orderBy('name')->get();

        return view('kutubxona.berilmagan', compact('oquvchilar', 'sinflar'));
    }

    /**
     * Qidiruv (F.I.O / Student ID / sinf) va tur (berilgan|berilmagan)
     * bo'yicha filtrlangan o'quvchilar ro'yxatini qaytaradi.
     */
    protected function filteredOquvchilar(Request $request, string $type)
    {
        $query = Oquvchi::with('sinf');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('fio', 'like', '%' . $search . '%')
                  ->orWhere('student_id', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('sinf_id')) {
            $query->where('sinf_id', $request->sinf_id);
        }

        return $query->orderBy('fio', 'asc')
            ->get()
            ->filter(function ($o) use ($type) {
                return count($o->kitoblar[$type] ?? []) > 0;
            });
    }
}