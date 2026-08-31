<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Sinf;
use App\Baho;
use App\DarsJadvali;
use App\Xabar;
use App\Exports\BaholarHisobotExport;

class BaholashController extends Controller
{
    /**
     * /baholar — rolga qarab tegishli sahifani ko'rsatadi.
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

        return view('baholash.teacher_index', compact('sinflar'));
    }

    public function teacherClassShow(Sinf $sinf)
    {
        $this->authorizeTeacherSinf($sinf);

        $oquvchilar = $sinf->oquvchilar()->orderBy('fio')->get();

        return view('baholash.teacher_students', compact('sinf', 'oquvchilar'));
    }

    /**
     * Baho qo'yish sahifasi (kunni tanlab).
     */
    public function mark(Request $request, Sinf $sinf)
    {
        $this->authorizeTeacherSinf($sinf);

        $sana = $request->query('sana')
            ? Carbon::parse($request->query('sana'))
            : Carbon::today();

        $oquvchilar = $sinf->oquvchilar()->orderBy('fio')->get();

        // Shu sinf, shu kun uchun eng oxirgi qo'yilgan baholar (bitta o'quvchiga bir nechta bo'lsa ham, formada oxirgisi ko'rinadi)
        $existing = Baho::where('sinf_id', $sinf->id)
            ->whereDate('sana', $sana)
            ->orderBy('id', 'desc')
            ->get()
            ->groupBy('oquvchi_id')
            ->map(function ($group) {
                return $group->first();
            });

        return view('baholash.mark', compact('sinf', 'oquvchilar', 'sana', 'existing'));
    }

    /**
     * Baholarni saqlash.
     */
    public function store(Request $request, Sinf $sinf)
    {
        $this->authorizeTeacherSinf($sinf);

        $request->validate([
            'sana' => 'required|date',
            'baholar' => 'required|array',
            'baholar.*' => 'nullable|integer|min:1|max:5',
        ]);

        $sana = $request->sana;
        $birortaSaqlandi = false;

        foreach ($request->baholar as $oquvchiId => $baho) {
            if ($baho === null || $baho === '') {
                continue;
            }

            Baho::updateOrCreate(
                [
                    'oquvchi_id' => $oquvchiId,
                    'sinf_id' => $sinf->id,
                    'sana' => $sana,
                ],
                [
                    'teacher_id' => Auth::id(),
                    'fan' => Auth::user()->subject,
                    'baho' => $baho,
                ]
            );

            $birortaSaqlandi = true;
        }

        // Direktor uchun "Xabarlar" bo'limiga bildirishnoma qoldiramiz
        // (kamida bitta o'quvchiga baho qo'yilgan bo'lsagina).
        if ($birortaSaqlandi) {
            $xabar = Xabar::updateOrCreate(
                [
                    'sinf_id' => $sinf->id,
                    'teacher_id' => Auth::id(),
                    'sana' => $sana,
                    'turi' => 'baho',
                ],
                [
                    'is_read' => false,
                ]
            );
            $xabar->touch();
        }

        return redirect()
            ->route('baholar.mark', ['sinf' => $sinf->id, 'sana' => $sana])
            ->with('success', 'Baholar muvaffaqiyatli saqlandi.');
    }

    protected function authorizeTeacherSinf(Sinf $sinf)
    {
        $teaches = DarsJadvali::where('sinf_id', $sinf->id)
            ->where('oqituvchi_id', Auth::id())
            ->exists();

        if (!$teaches) {
            abort(403, 'Siz ushbu sinfga baho qo\'yish huquqiga ega emassiz.');
        }
    }

    /* =====================================================
       DIREKTOR TOMONI
    ===================================================== */

    protected function directorIndex()
    {
        $bugun = Carbon::today();

        $sinflar = Sinf::with('teacher')
            ->withCount('oquvchilar')
            ->orderBy('name')
            ->get()
            ->map(function ($sinf) use ($bugun) {
                $belgilanganSoni = Baho::where('sinf_id', $sinf->id)
                    ->whereDate('sana', $bugun)
                    ->distinct('oquvchi_id')
                    ->count('oquvchi_id');

                $sinf->bugungi_holat = $sinf->oquvchilar_count > 0
                    ? ($belgilanganSoni >= $sinf->oquvchilar_count ? 'toliq' : ($belgilanganSoni > 0 ? 'qisman' : 'yoq'))
                    : 'yoq';

                return $sinf;
            });

        return view('baholash.director_index', compact('sinflar', 'bugun'));
    }

    /**
     * Direktor tomonidan FAQAT KO'RISH.
     */
    public function directorClassShow(Request $request, Sinf $sinf)
    {
        $sana = $request->query('sana')
            ? Carbon::parse($request->query('sana'))
            : Carbon::today();

        $oquvchilar = $sinf->oquvchilar()->orderBy('fio')->get();

        $baholar = Baho::with('teacher')
            ->where('sinf_id', $sinf->id)
            ->whereDate('sana', $sana)
            ->get()
            ->groupBy('oquvchi_id');

        return view('baholash.director_show', compact('sinf', 'oquvchilar', 'sana', 'baholar'));
    }

    /**
     * Sinf uchun haftalik/oylik hisobot — har bir o'quvchining o'rtacha bahosi.
     */
    public function directorReport(Request $request, Sinf $sinf)
    {
        $davr = $request->query('davr', 'oylik');

        $boshlanish = $davr === 'haftalik'
            ? Carbon::now()->startOfWeek()
            : Carbon::now()->startOfMonth();

        $tugash = $davr === 'haftalik'
            ? Carbon::now()->endOfWeek()
            : Carbon::now()->endOfMonth();

        $oquvchilar = $sinf->oquvchilar()->orderBy('fio')->get();

        $baholar = Baho::where('sinf_id', $sinf->id)
            ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()])
            ->get()
            ->groupBy('oquvchi_id');

        return view('baholash.director_report', compact(
            'sinf', 'oquvchilar', 'baholar', 'davr', 'boshlanish', 'tugash'
        ));
    }

    /**
     * Excel eksport.
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

        $baholar = Baho::where('sinf_id', $sinf->id)
            ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()])
            ->get()
            ->groupBy('oquvchi_id');

        $fileName = $sinf->name . '_baholar_' . $davr . '_' . Carbon::now()->format('Y-m-d') . '.xlsx';

        return \Excel::download(
            new BaholarHisobotExport($sinf, $oquvchilar, $baholar),
            $fileName
        );
    }
}