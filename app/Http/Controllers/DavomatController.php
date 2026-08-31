<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Sinf;
use App\Davomat;
use App\DarsJadvali;
use App\Xabar;

class DavomatController extends Controller
{
    /**
     * /davomat — rolga qarab tegishli sahifani ko'rsatadi.
     */
    public function index()
    {
        if (Auth::user()->role === 'teacher') {
            return $this->teacherIndex();
        }

        return $this->directorIndex();
    }

    /* =====================================================
       O'QITUVCHI TOMONI
    ===================================================== */

    protected function teacherIndex()
    {
        $teacherId = Auth::id();

        $sinfIds = DarsJadvali::where('oqituvchi_id', $teacherId)
            ->distinct()
            ->pluck('sinf_id');

        $sinflar = Sinf::whereIn('id', $sinfIds)
            ->withCount('oquvchilar')
            ->orderBy('name')
            ->get();

        return view('davomat.teacher_index', compact('sinflar'));
    }

    /**
     * O'qituvchi tomonidan sinfni ko'rish (o'quvchilar ro'yxati, profil bilan).
     */
    public function teacherClassShow(Sinf $sinf)
    {
        $this->authorizeTeacherSinf($sinf);

        $oquvchilar = $sinf->oquvchilar()->orderBy('fio')->get();

        return view('davomat.teacher_students', compact('sinf', 'oquvchilar'));
    }

    /**
     * Davomat belgilash sahifasi (kunni tanlab).
     */
    public function mark(Request $request, Sinf $sinf)
    {
        $this->authorizeTeacherSinf($sinf);

        $sana = $request->query('sana')
            ? Carbon::parse($request->query('sana'))
            : Carbon::today();

        $oquvchilar = $sinf->oquvchilar()->orderBy('fio')->get();

        $existing = Davomat::where('sinf_id', $sinf->id)
            ->whereDate('sana', $sana)
            ->pluck('status', 'oquvchi_id');

        $statusLabels = Davomat::statusLabels();

        return view('davomat.mark', compact('sinf', 'oquvchilar', 'sana', 'existing', 'statusLabels'));
    }

    /**
     * Davomatni saqlash.
     */
    public function store(Request $request, Sinf $sinf)
    {
        $this->authorizeTeacherSinf($sinf);

        $request->validate([
            'sana' => 'required|date',
            'statuses' => 'required|array',
            'statuses.*' => 'in:keldi,sz,sb,kq,kc',
        ]);

        $sana = $request->sana;

        foreach ($request->statuses as $oquvchiId => $status) {
            Davomat::updateOrCreate(
                [
                    'oquvchi_id' => $oquvchiId,
                    'sana' => $sana,
                ],
                [
                    'sinf_id' => $sinf->id,
                    'teacher_id' => Auth::id(),
                    'status' => $status,
                ]
            );
        }

        // Direktor uchun "Xabarlar" bo'limiga bildirishnoma qoldiramiz.
        // Bir sinf + bir kun + bir o'qituvchi uchun bitta yozuv bo'ladi;
        // qayta saqlansa faqat vaqti (updated_at) va o'qilmagan holati yangilanadi.
        $xabar = Xabar::updateOrCreate(
            [
                'sinf_id' => $sinf->id,
                'teacher_id' => Auth::id(),
                'sana' => $sana,
                'turi' => 'davomat',
            ],
            [
                'is_read' => false,
            ]
        );
        $xabar->touch();

        return redirect()
            ->route('davomat.mark', ['sinf' => $sinf->id, 'sana' => $sana])
            ->with('success', 'Davomat muvaffaqiyatli saqlandi.');
    }

    /**
     * O'qituvchi faqat o'zi dars beradigan sinfga davomat qo'ya olishini tekshiradi.
     */
    protected function authorizeTeacherSinf(Sinf $sinf)
    {
        $teaches = DarsJadvali::where('sinf_id', $sinf->id)
            ->where('oqituvchi_id', Auth::id())
            ->exists();

        if (!$teaches) {
            abort(403, 'Siz ushbu sinfga davomat qo\'yish huquqiga ega emassiz.');
        }
    }

     /* =====================================================
       DIREKTOR TOMONI
    ===================================================== */

    /**
     * Barcha sinflar ro'yxati + bugungi davomat holati.
     */
    protected function directorIndex()
    {
        $bugun = Carbon::today();

        $sinflar = Sinf::with('teacher')
            ->withCount('oquvchilar')
            ->orderBy('name')
            ->get()
            ->map(function ($sinf) use ($bugun) {
                $belgilanganSoni = Davomat::where('sinf_id', $sinf->id)
                    ->whereDate('sana', $bugun)
                    ->count();

                $sinf->bugungi_holat = $sinf->oquvchilar_count > 0
                    ? ($belgilanganSoni >= $sinf->oquvchilar_count ? 'toliq' : ($belgilanganSoni > 0 ? 'qisman' : 'yoq'))
                    : 'yoq';

                return $sinf;
            });

        return view('davomat.director_index', compact('sinflar', 'bugun'));
    }

    /**
     * Direktor tomonidan bitta sinfning davomatini FAQAT KO'RISH.
     * Tahrirlash imkoni yo'q — o'qituvchi ma'lumotlari daxlsiz qoladi.
     */
    public function directorClassShow(Request $request, Sinf $sinf)
    {
        $sana = $request->query('sana')
            ? Carbon::parse($request->query('sana'))
            : Carbon::today();

        $oquvchilar = $sinf->oquvchilar()->orderBy('fio')->get();

        $davomatlar = Davomat::with('teacher')
            ->where('sinf_id', $sinf->id)
            ->whereDate('sana', $sana)
            ->get()
            ->keyBy('oquvchi_id');

        $statusLabels = Davomat::statusLabels();

        return view('davomat.director_show', compact('sinf', 'oquvchilar', 'sana', 'davomatlar', 'statusLabels'));
    }

    /**
     * Sinf uchun haftalik/oylik hisobot — har bir o'quvchining
     * statuslar bo'yicha umumiy sonlari.
     */
    public function directorReport(Request $request, Sinf $sinf)
    {
        $davr = $request->query('davr', 'oylik'); // haftalik | oylik

        $boshlanish = $davr === 'haftalik'
            ? Carbon::now()->startOfWeek()
            : Carbon::now()->startOfMonth();

        $tugash = $davr === 'haftalik'
            ? Carbon::now()->endOfWeek()
            : Carbon::now()->endOfMonth();

        $oquvchilar = $sinf->oquvchilar()->orderBy('fio')->get();

        $statuslar = Davomat::where('sinf_id', $sinf->id)
            ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()])
            ->get()
            ->groupBy('oquvchi_id');

        $statusLabels = Davomat::statusLabels();

        return view('davomat.director_report', compact(
            'sinf', 'oquvchilar', 'statuslar', 'statusLabels', 'davr', 'boshlanish', 'tugash'
        ));
    }

      /**
     * Sinf davomat hisobotini Excel formatida yuklab olish.
     */
    public function directorReportExport(Request $request, Sinf $sinf)
    {
        $davr = $request->query('davr', 'oylik');

        $boshlanish = $davr === 'haftalik'
            ? Carbon::now()->startOfWeek()
            : Carbon::now()->startOfMonth();

        $tugash = $davr === 'haftalik'
            ? Carbon::now()->endOfWeek()
            : Carbon::now()->endOfMonth();

        $oquvchilar = $sinf->oquvchilar()->orderBy('fio')->get();

        $statuslar = Davomat::where('sinf_id', $sinf->id)
            ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()])
            ->get()
            ->groupBy('oquvchi_id');

        $statusLabels = Davomat::statusLabels();

        $fileName = $sinf->name . '_davomat_' . $davr . '_' . Carbon::now()->format('Y-m-d') . '.xlsx';

        return \Excel::download(
            new \App\Exports\DavomatHisobotExport($sinf, $oquvchilar, $statuslar, $statusLabels, $boshlanish, $tugash),
            $fileName
        );
    }
}