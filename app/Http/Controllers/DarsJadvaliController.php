<?php

namespace App\Http\Controllers;

use App\DarsJadvali;
use App\Sinf;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DarsJadvaliController extends Controller
{
    /**
     * Dars jadvali mavjud bo'lgan sinflar ro'yxati.
     *
     * GET /dars-jadvali
     */
    public function index()
    {
        $sinflar = Sinf::withCount('darsJadvali')
            ->having('dars_jadvali_count', '>', 0)
            ->orderBy('name', 'asc')
            ->get();

        return view('darsjadvali.index', compact('sinflar'));
    }

    /**
     * Excel yuklash formasi.
     *
     * GET /dars-jadvali/import
     */
    public function importForm()
    {
        return view('darsjadvali.import');
    }

    /**
     * Excel faylni import qilish.
     * Bitta fayl ichidagi barcha 4 ta sinfni avtomatik aniqlab bazaga yozadi.
     *
     * POST /dars-jadvali/import
     */
    public function import(Request $request)
    {
        $request->validate(
            [
                'excel_file' => [
                    'required',
                    'file',
                    'mimes:xlsx,xls',
                    'max:10240',
                ],
            ],
            [
                'excel_file.required' => 'Excel faylini tanlang.',
                'excel_file.mimes' => 'Faqat XLSX yoki XLS fayllarini yuklash mumkin.',
                'excel_file.max' => 'Excel fayli 10 MB dan katta bo‘lmasligi kerak.',
            ]
        );

        try {
            $spreadsheet = IOFactory::load(
                $request->file('excel_file')->getPathname()
            );
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Excel faylini o‘qib bo‘lmadi: ' . $e->getMessage()
                );
        }

        $importedSinflar = [];
        $allTeachers = User::whereIn('role', ['teacher', 'deputy'])->get();

        DB::beginTransaction();

        try {
            $sheet = $spreadsheet->getSheetByName('Pastma-past Jadval') ?? $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, false);

            $currentSinf = null;
            $lastKun = null;
            $batchRows = [];
            $kunlarList = [
                'Dushanba',
                'Seshanba',
                'Chorshanba',
                'Payshanba',
                'Juma',
                'Shanba',
                'Yakshanba'
            ];

            foreach ($rows as $row) {
                $colA = isset($row[0]) ? trim((string) $row[0]) : '';
                $colB = isset($row[1]) ? trim((string) $row[1]) : '';
                $colC = isset($row[2]) ? trim((string) $row[2]) : '';
                $colD = isset($row[3]) ? trim((string) $row[3]) : '';
                $colE = isset($row[4]) ? trim((string) $row[4]) : '';

                if (preg_match('/(\d{1,2}\s*[-–—]?\s*[A-Za-zА-Яа-яЎўҚқҒғҲҳ]+)/u', $colA, $matches)) {
                    if (mb_stripos($colA, 'SINF') !== false || mb_stripos($colA, 'DARS JADVALI') !== false) {
                        $foundClassName = strtoupper(str_replace(' ', '', $matches[1]));

                        $sinf = Sinf::firstOrCreate(['name' => $foundClassName]);
                        $currentSinf = $sinf;
                        $lastKun = null;

                        if (!in_array($sinf->name, $importedSinflar)) {
                            DarsJadvali::where('sinf_id', $sinf->id)->delete();
                            $importedSinflar[] = $sinf->name;
                        }
                        continue;
                    }
                }

                if (!$currentSinf || $colA === 'Kun' || $colB === 'Dars T/R') {
                    continue;
                }

                foreach ($kunlarList as $kun) {
                    if (mb_stripos($colA, $kun) !== false) {
                        $lastKun = $kun;
                        break;
                    }
                }

                if (empty($colB) || empty($colD) || $colD === '—' || $colD === '-') {
                    continue;
                }

                if (empty($lastKun)) {
                    continue;
                }

                $tartib = 0;
                if (preg_match('/(\d+)/', $colB, $m)) {
                    $tartib = (int) $m[1];
                }

                $oqituvchiId = null;
                if (!empty($colE) && $colE !== '—' && $colE !== '-') {
                    $cleanName = mb_strtolower(trim($colE));
                    $user = $allTeachers->first(function ($t) use ($cleanName) {
                        return mb_strtolower(trim($t->name)) === $cleanName;
                    });

                    if ($user) {
                        $oqituvchiId = $user->id;
                    }
                }

                $batchRows[] = [
                    'sinf_id'       => $currentSinf->id,
                    'kun'           => $lastKun,
                    'dars_raqami'   => $colB,
                    'tartib'        => $tartib,
                    'vaqti'         => $colC ?: null,
                    'fan'           => $colD,
                    'oqituvchi_id'  => $oqituvchiId,
                    'oqituvchi_ism' => $colE ?: null,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }

            if (empty($batchRows)) {
                foreach ($spreadsheet->getAllSheets() as $singleSheet) {
                    $title = trim($singleSheet->getTitle());
                    if (mb_stripos($title, 'Sinf ') !== 0) {
                        continue;
                    }

                    $sinfName = trim(mb_substr($title, mb_strlen('Sinf ')));
                    $sinf = Sinf::firstOrCreate(['name' => $sinfName]);

                    $rows = $singleSheet->toArray(null, true, true, false);
                    $lastKun = null;

                    foreach ($rows as $row) {
                        $colA = isset($row[0]) ? trim((string) $row[0]) : '';
                        $colB = isset($row[1]) ? trim((string) $row[1]) : '';
                        $colC = isset($row[2]) ? trim((string) $row[2]) : '';
                        $colD = isset($row[3]) ? trim((string) $row[3]) : '';
                        $colE = isset($row[4]) ? trim((string) $row[4]) : '';

                        if ($colB === 'Dars T/R' || empty($colB) || empty($colD) || $colD === '—') {
                            continue;
                        }

                        foreach ($kunlarList as $kun) {
                            if (mb_stripos($colA, $kun) !== false) {
                                $lastKun = $kun;
                                break;
                            }
                        }

                        if (empty($lastKun)) {
                            continue;
                        }

                        $tartib = 0;
                        if (preg_match('/(\d+)/', $colB, $m)) {
                            $tartib = (int) $m[1];
                        }

                        $oqituvchiId = null;
                        if (!empty($colE) && $colE !== '—') {
                            $cleanName = mb_strtolower(trim($colE));
                            $user = $allTeachers->first(function ($t) use ($cleanName) {
                                return mb_strtolower(trim($t->name)) === $cleanName;
                            });
                            if ($user) {
                                $oqituvchiId = $user->id;
                            }
                        }

                        $batchRows[] = [
                            'sinf_id'       => $sinf->id,
                            'kun'           => $lastKun,
                            'dars_raqami'   => $colB,
                            'tartib'        => $tartib,
                            'vaqti'         => $colC ?: null,
                            'fan'           => $colD,
                            'oqituvchi_id'  => $oqituvchiId,
                            'oqituvchi_ism' => $colE ?: null,
                            'created_at'    => now(),
                            'updated_at'    => now(),
                        ];
                    }

                    if (!in_array($sinf->name, $importedSinflar)) {
                        DarsJadvali::where('sinf_id', $sinf->id)->delete();
                        $importedSinflar[] = $sinf->name;
                    }
                }
            }

            if (count($batchRows) > 0) {
                DarsJadvali::insert($batchRows);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Import qilishda xatolik yuz berdi: ' . $e->getMessage()
                );
        }

        if (count($importedSinflar) === 0) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Excel faylidan dars jadvali ma’lumotlarini o‘qib bo‘lmadi. Faylni tekshiring.'
                );
        }

        return redirect()
            ->route('darsjadvali.index')
            ->with(
                'success',
                count($importedSinflar) . ' ta sinf (' . implode(', ', $importedSinflar) . ') uchun jami ' . count($batchRows) . ' ta dars jadvali muvaffaqiyatli yuklandi.'
            );
    }

    /**
     * Bitta sinfning to'liq haftalik jadvalini ko'rish.
     *
     * GET /dars-jadvali/sinf/{sinf}
     */
    public function show(Sinf $sinf)
    {
        $darslar = DarsJadvali::where('sinf_id', $sinf->id)
            ->with('oqituvchi')
            ->orderByRaw(
                "FIELD(kun,'Dushanba','Seshanba','Chorshanba','Payshanba','Juma','Shanba','Yakshanba')"
            )
            ->orderBy('tartib', 'asc')
            ->get()
            ->groupBy('kun');

        $oqituvchilar = User::whereIn('role', ['teacher', 'deputy'])
            ->orderBy('name', 'asc')
            ->get();

        return view(
            'darsjadvali.show',
            compact('sinf', 'darslar', 'oqituvchilar')
        );
    }

    /**
     * O'qituvchining shaxsiy dars jadvali.
     *
     * GET /mening-dars-jadvalim
     */
    public function teacherSchedule()
    {
        $user = Auth::user();

        $haftalikJadval = DarsJadvali::where(function($q) use ($user) {
                $q->where('oqituvchi_id', $user->id)
                  ->orWhereRaw('LOWER(oqituvchi_ism) = ?', [mb_strtolower(trim($user->name))]);
            })
            ->with('sinf')
            ->orderByRaw("FIELD(kun,'Dushanba','Seshanba','Chorshanba','Payshanba','Juma','Shanba','Yakshanba')")
            ->orderBy('tartib', 'asc')
            ->get()
            ->groupBy('kun');

        $kunlar = [
            1 => 'Dushanba',
            2 => 'Seshanba',
            3 => 'Chorshanba',
            4 => 'Payshanba',
            5 => 'Juma',
            6 => 'Shanba',
            7 => 'Yakshanba'
        ];
        $bugungiKun = $kunlar[date('N')] ?? 'Dushanba';

        $bugungiDarslar = DarsJadvali::where(function($q) use ($user) {
                $q->where('oqituvchi_id', $user->id)
                  ->orWhereRaw('LOWER(oqituvchi_ism) = ?', [mb_strtolower(trim($user->name))]);
            })
            ->where('kun', $bugungiKun)
            ->with('sinf')
            ->orderBy('tartib', 'asc')
            ->get();

        return view('darsjadvali.teacher', compact('haftalikJadval', 'bugungiDarslar', 'bugungiKun'));
    }

    /**
     * Sinfga yangi dars qo'shish.
     *
     * POST /dars-jadvali/sinf/{sinf}/dars-qoshish
     */
    public function store(Request $request, Sinf $sinf)
    {
        $request->validate([
            'kun' => 'required|string|max:50',
            'dars_raqami' => 'required|string|max:50',
            'vaqti' => 'nullable|string|max:50',
            'fan' => 'required|string|max:255',
            'oqituvchi_id' => 'nullable|exists:users,id',
        ]);

        $tartib = 0;

        if (preg_match('/(\d+)/', $request->dars_raqami, $m)) {
            $tartib = (int) $m[1];
        }

        $oqituvchiIsm = null;

        if ($request->filled('oqituvchi_id')) {
            $user = User::find($request->oqituvchi_id);
            $oqituvchiIsm = $user ? $user->name : null;
        }

        DarsJadvali::create([
            'sinf_id' => $sinf->id,
            'kun' => $request->kun,
            'dars_raqami' => $request->dars_raqami,
            'tartib' => $tartib,
            'vaqti' => $request->vaqti,
            'fan' => $request->fan,
            'oqituvchi_id' => $request->oqituvchi_id ?: null,
            'oqituvchi_ism' => $oqituvchiIsm,
        ]);

        return redirect()
            ->route('darsjadvali.show', $sinf->id)
            ->with('success', 'Yangi dars muvaffaqiyatli qo‘shildi.');
    }

    /**
     * Bitta darsni tahrirlash sahifasi.
     *
     * GET /dars-jadvali/{id}/edit
     */
    public function edit($id)
    {
        $dars = DarsJadvali::findOrFail($id);

        $oqituvchilar = User::whereIn('role', ['teacher', 'deputy'])
            ->orderBy('name', 'asc')
            ->get();

        return view('darsjadvali.edit', compact('dars', 'oqituvchilar'));
    }

    /**
     * Bitta darsni yangilash.
     *
     * PUT /dars-jadvali/{id}
     */
    public function update(Request $request, $id)
    {
        $dars = DarsJadvali::findOrFail($id);

        $request->validate([
            'kun' => 'required|string|max:50',
            'dars_raqami' => 'required|string|max:50',
            'vaqti' => 'nullable|string|max:50',
            'fan' => 'required|string|max:255',
            'oqituvchi_id' => 'nullable|exists:users,id',
        ]);

        $tartib = 0;

        if (preg_match('/(\d+)/', $request->dars_raqami, $m)) {
            $tartib = (int) $m[1];
        }

        $oqituvchiIsm = null;

        if ($request->filled('oqituvchi_id')) {
            $user = User::find($request->oqituvchi_id);
            $oqituvchiIsm = $user ? $user->name : null;
        }

        $dars->update([
            'kun' => $request->kun,
            'dars_raqami' => $request->dars_raqami,
            'tartib' => $tartib,
            'vaqti' => $request->vaqti,
            'fan' => $request->fan,
            'oqituvchi_id' => $request->oqituvchi_id ?: null,
            'oqituvchi_ism' => $oqituvchiIsm,
        ]);

        return redirect()
            ->route('darsjadvali.show', $dars->sinf_id)
            ->with('success', 'Dars ma’lumotlari yangilandi.');
    }

    /**
     * Bitta darsni o'chirish.
     *
     * DELETE /dars-jadvali/{id}
     */
    public function destroy($id)
    {
        $dars = DarsJadvali::findOrFail($id);

        $sinfId = $dars->sinf_id;

        $dars->delete();

        return redirect()
            ->route('darsjadvali.show', $sinfId)
            ->with('success', 'Dars muvaffaqiyatli o‘chirildi.');
    }

    /**
     * Butun sinf dars jadvalini o'chirish.
     *
     * DELETE /dars-jadvali/sinf/{sinf}
     */
    public function destroySinf(Sinf $sinf)
    {
        DarsJadvali::where('sinf_id', $sinf->id)->delete();

        return redirect()
            ->route('darsjadvali.index')
            ->with(
                'success',
                $sinf->name . ' sinfi uchun dars jadvali muvaffaqiyatli o‘chirildi.'
            );
    }
}