<?php

namespace App\Http\Controllers;

use App\Baho;
use App\Davomat;
use App\Oquvchi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReytingController extends Controller
{
    /**
     * Reyting ballini hisoblashda baho va davomatning og'irligi.
     * (Foydalanuvchi tanlovi: 50% baho + 50% davomat)
     */
    const BAHO_OGIRLIK = 0.5;
    const DAVOMAT_OGIRLIK = 0.5;

    /**
     * GET /reyting
     *
     * Barcha maktab bo'yicha (barcha sinflar orasida) TOP 20 o'quvchi reytingi.
     * Reyting balli = (o'rtacha baho / 5 * 100) * 0.5 + (davomat foizi) * 0.5
     */
    public function index(Request $request)
    {
        $this->checkAccess();

        $period = $request->get('period', 'month'); // today | week | month | all
        $qidiruv = trim((string) $request->get('q', ''));

        [$boshlanish, $tugash] = $this->resolvePeriod($period);

        $reyting = $this->buildReyting($boshlanish, $tugash);

        // Har biriga o'rin raqamini beramiz (umumiy reytingdagi haqiqiy o'rni)
        $reyting = $reyting->values()->map(function ($item, $idx) {
            $item['orin'] = $idx + 1;
            return $item;
        });

        $top20 = $reyting->take(20);

        // Qidiruv: ism/familiya, student_id yoki sinf nomi bo'yicha —
        // TOP 20'da bo'lmasa ham, umumiy reytingdagi haqiqiy o'rnini ko'rsatamiz.
        $qidiruvNatija = collect();

        if ($qidiruv !== '') {
            $qidiruvNatija = $reyting->filter(function ($item) use ($qidiruv) {
                return stripos($item['fio'], $qidiruv) !== false
                    || stripos((string) $item['student_id'], $qidiruv) !== false
                    || stripos((string) $item['id'], $qidiruv) !== false
                    || stripos($item['sinf_name'], $qidiruv) !== false;
            })->values();
        }

        return view('reyting.index', compact(
            'top20', 'qidiruvNatija', 'qidiruv', 'period', 'boshlanish', 'tugash'
        ));
    }

    /**
     * GET /reyting/{id}/davomat
     *
     * Bitta o'quvchining tanlangan oy bo'yicha kunma-kun davomat tarixi.
     * Reyting jadvalidagi "Davomat" ikonkasi shu yerga olib keladi.
     */
    public function davomat(Request $request, $id)
    {
        $this->checkAccess();

        $oquvchi = Oquvchi::with('sinf')->findOrFail($id);

        $oy = $request->get('oy', Carbon::now()->format('Y-m'));

        try {
            $boshlanish = Carbon::createFromFormat('Y-m', $oy)->startOfMonth();
        } catch (\Exception $e) {
            $oy = Carbon::now()->format('Y-m');
            $boshlanish = Carbon::now()->startOfMonth();
        }

        $tugash = $boshlanish->copy()->endOfMonth();

        $davomatlar = Davomat::with('teacher')
            ->where('oquvchi_id', $oquvchi->id)
            ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()])
            ->orderBy('sana')
            ->get();

        $jami = $davomatlar->count();
        $keldi = $davomatlar->where('status', 'keldi')->count();
        $foiz = $jami > 0 ? round(($keldi / $jami) * 100, 1) : null;

        $statusLabels = Davomat::statusLabels();

        return view('reyting.davomat', compact(
            'oquvchi', 'davomatlar', 'oy', 'jami', 'keldi', 'foiz', 'statusLabels'
        ));
    }

    /**
     * GET /reyting/{id}/kunlik
     *
     * Bitta o'quvchining tanlangan sanadagi barcha baholari va davomati
     * (o'qituvchilar shu kun qo'ygan ma'lumotlar). Reyting jadvalidagi
     * "Ko'rish" ikonkasi shu yerga olib keladi. Tepada sana tanlagich bor.
     */
    public function kunlik(Request $request, $id)
    {
        $this->checkAccess();

        $oquvchi = Oquvchi::with('sinf')->findOrFail($id);

        $sana = $request->get('sana', Carbon::today()->toDateString());

        try {
            $sanaCarbon = Carbon::parse($sana);
        } catch (\Exception $e) {
            $sana = Carbon::today()->toDateString();
            $sanaCarbon = Carbon::today();
        }

        $baholar = Baho::with('teacher')
            ->where('oquvchi_id', $oquvchi->id)
            ->whereDate('sana', $sanaCarbon->toDateString())
            ->orderBy('fan')
            ->get();

        $davomat = Davomat::with('teacher')
            ->where('oquvchi_id', $oquvchi->id)
            ->whereDate('sana', $sanaCarbon->toDateString())
            ->first();

        $statusLabels = Davomat::statusLabels();

        return view('reyting.kunlik', compact(
            'oquvchi', 'baholar', 'davomat', 'sana', 'statusLabels'
        ));
    }

    /* =====================================================
       YORDAMCHI METODLAR
    ===================================================== */

    protected function checkAccess(): void
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['director', 'deputy'], true)) {
            abort(403, 'Sizda ushbu sahifaga kirish huquqi mavjud emas.');
        }
    }

    protected function resolvePeriod(string $period): array
    {
        switch ($period) {
            case 'today':
                return [Carbon::today(), Carbon::today()->endOfDay()];
            case 'week':
                return [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
            case 'all':
                return [Carbon::createFromDate(2000, 1, 1)->startOfDay(), Carbon::now()->endOfDay()];
            case 'month':
            default:
                return [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()];
        }
    }

    /**
     * Barcha o'quvchilar uchun (barcha sinflar bo'yicha, umumiy) reyting
     * ballarini hisoblab, kamayish tartibida saralangan collection qaytaradi.
     */
    protected function buildReyting(Carbon $boshlanish, Carbon $tugash)
    {
        $oquvchilar = Oquvchi::with('sinf')->get();

        $bahoAvg = Baho::select('oquvchi_id', DB::raw('AVG(baho) as ortacha'))
            ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()])
            ->groupBy('oquvchi_id')
            ->get()
            ->keyBy('oquvchi_id');

        $davomat = Davomat::select(
                'oquvchi_id',
                DB::raw("SUM(CASE WHEN status = 'keldi' THEN 1 ELSE 0 END) as keldi_soni"),
                DB::raw('COUNT(*) as jami_soni')
            )
            ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()])
            ->groupBy('oquvchi_id')
            ->get()
            ->keyBy('oquvchi_id');

        return $oquvchilar->map(function ($o) use ($bahoAvg, $davomat) {
            $b = $bahoAvg->get($o->id);
            $d = $davomat->get($o->id);

            $ortachaBaho = $b ? round($b->ortacha, 2) : null;
            $davomatFoizi = ($d && $d->jami_soni > 0)
                ? round(($d->keldi_soni / $d->jami_soni) * 100, 1)
                : null;

            // Reyting ballini hisoblash uchun bo'sh ma'lumot 0 sifatida olinadi
            $bahoBall = $ortachaBaho !== null ? ($ortachaBaho / 5) * 100 : 0;
            $davomatBall = $davomatFoizi !== null ? $davomatFoizi : 0;

            $umumiyBall = round(($bahoBall * self::BAHO_OGIRLIK) + ($davomatBall * self::DAVOMAT_OGIRLIK), 2);

            // fio ni "Familiya Ism Sharif" tartibida 3 qismga ajratamiz
            $qismlar = preg_split('/\s+/', trim($o->fio));
            $familiya = $qismlar[0] ?? $o->fio;
            $ism = $qismlar[1] ?? '';
            $sharif = $qismlar[2] ?? '';

            return [
                'id' => $o->id,
                'student_id' => $o->student_id,
                'fio' => $o->fio,
                'familiya' => $familiya,
                'ism' => $ism,
                'sharif' => $sharif,
                'sinf_id' => $o->sinf_id,
                'sinf_name' => $o->sinf->name ?? '—',
                'ortacha_baho' => $ortachaBaho,
                'davomat_foizi' => $davomatFoizi,
                'umumiy_ball' => $umumiyBall,
            ];
        })
        ->sortByDesc('umumiy_ball')
        ->values();
    }
}