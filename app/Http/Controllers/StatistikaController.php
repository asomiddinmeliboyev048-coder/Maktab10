<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\Sinf;
use App\Oquvchi;
use App\Davomat;
use App\Baho;

class StatistikaController extends Controller
{
    /**
     * GET /statistika
     *
     * Faqat director va deputy uchun.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Ruxsat tekshiruvi (backend darajasida, frontenddan mustaqil)
        |--------------------------------------------------------------------------
        */
        if (!Auth::check() || !in_array(Auth::user()->role, ['director', 'deputy'], true)) {
            abort(403, 'Sizda ushbu sahifaga kirish huquqi mavjud emas.');
        }

        /*
        |--------------------------------------------------------------------------
        | Filterlar
        |--------------------------------------------------------------------------
        */
        $period = $request->get('period', 'month'); // today | week | month
        $sinfId = $request->get('sinf_id');
        $fan = $request->get('fan');

        [$boshlanish, $tugash] = $this->resolvePeriod($period);

        $sinflarUmumiy = Sinf::orderBy('name')->get(['id', 'name']);
        $fanlarUmumiy = Baho::whereNotNull('fan')->distinct()->orderBy('fan')->pluck('fan');

        /*
        |--------------------------------------------------------------------------
        | 1. UMUMIY KPI
        |--------------------------------------------------------------------------
        */
        $kpi = $this->buildKpi();

        /*
        |--------------------------------------------------------------------------
        | 2. SINFLAR (o'quvchilar soni + davomat % + o'rtacha baho — bittada)
        |--------------------------------------------------------------------------
        */
        $sinflarData = $this->buildSinflarData($boshlanish, $tugash, $sinfId);

        /*
        |--------------------------------------------------------------------------
        | 3. O'QUVCHILAR STATISTIKASI
        |--------------------------------------------------------------------------
        */
        $oquvchilarStat = [
            'jami' => Oquvchi::count(),
            'engKop' => $sinflarData->sortByDesc('oquvchilar_soni')->first(),
            'engKam' => $sinflarData->sortBy('oquvchilar_soni')->first(),
        ];

        /*
        |--------------------------------------------------------------------------
        | 4. O'QITUVCHILAR STATISTIKASI
        |--------------------------------------------------------------------------
        */
        $oqituvchilarStat = [
            'jami' => User::where('role', 'teacher')->count(),
            'fanBoyicha' => User::where('role', 'teacher')
                ->whereNotNull('subject')
                ->select('subject', DB::raw('count(*) as soni'))
                ->groupBy('subject')
                ->orderByDesc('soni')
                ->get(),
            'sinfRahbarlari' => Sinf::whereNotNull('teacher_id')->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | 5. DAVOMAT STATISTIKASI (tanlangan davr bo'yicha)
        |--------------------------------------------------------------------------
        */
        $davomatStat = $this->buildDavomatStat($boshlanish, $tugash, $sinfId);

        /*
        |--------------------------------------------------------------------------
        | 6. BAHOLAR STATISTIKASI (tanlangan davr bo'yicha)
        |--------------------------------------------------------------------------
        */
        $baholarStat = $this->buildBaholarStat($boshlanish, $tugash, $sinfId, $fan);

        /*
        |--------------------------------------------------------------------------
        | 7. KUTUBXONA STATISTIKASI
        |--------------------------------------------------------------------------
        */
        $kutubxonaStat = $this->buildKutubxonaStat();

        /*
        |--------------------------------------------------------------------------
        | 8. O'QUVCHILAR REYTINGI (TOP 10)
        |--------------------------------------------------------------------------
        */
        $topOquvchilar = $this->buildTopOquvchilar($boshlanish, $tugash, $fan);

        /*
        |--------------------------------------------------------------------------
        | 9. MUAMMOLI KO'RSATKICHLAR
        |--------------------------------------------------------------------------
        */
        $muammolar = [
            'davomatiPastSinflar' => $sinflarData->filter(function ($s) {
                return $s['davomat_foizi'] !== null && $s['davomat_foizi'] < 80;
            })->values(),

            'bahosiPastSinflar' => $sinflarData->filter(function ($s) {
                return $s['ortacha_baho'] !== null && $s['ortacha_baho'] < 3.0;
            })->values(),

            'kitobiYetishmaganSoni' => DB::table('oquvchilar')
                ->whereRaw("JSON_LENGTH(JSON_EXTRACT(kitoblar, '$.berilmagan')) > 0")
                ->count(),

            'baholanmaganOquvchilarSoni' => Oquvchi::whereDoesntHave('baholar', function ($q) use ($boshlanish, $tugash) {
                $q->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()]);
            })->count(),
        ];

        return view('statistika.index', compact(
            'period', 'sinfId', 'fan',
            'sinflarUmumiy', 'fanlarUmumiy',
            'kpi', 'sinflarData',
            'oquvchilarStat', 'oqituvchilarStat',
            'davomatStat', 'baholarStat',
            'kutubxonaStat', 'topOquvchilar',
            'muammolar', 'boshlanish', 'tugash'
        ));
    }

    /* =====================================================
       YORDAMCHI METODLAR
    ===================================================== */

    protected function resolvePeriod(string $period): array
    {
        switch ($period) {
            case 'today':
                return [Carbon::today(), Carbon::today()->endOfDay()];
            case 'week':
                return [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
            case 'month':
            default:
                return [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()];
        }
    }

    protected function buildKpi(): array
    {
        $todayKeldi = Davomat::whereDate('sana', Carbon::today())->where('status', 'keldi')->count();
        $todayJami = Davomat::whereDate('sana', Carbon::today())->count();
        $todayPercent = $todayJami > 0 ? round(($todayKeldi / $todayJami) * 100, 1) : null;

        $kitobRow = DB::table('oquvchilar')
            ->selectRaw("SUM(JSON_LENGTH(JSON_EXTRACT(kitoblar, '$.berilgan'))) as berilgan")
            ->selectRaw("SUM(JSON_LENGTH(JSON_EXTRACT(kitoblar, '$.berilmagan'))) as berilmagan")
            ->first();

        return [
            'jamiOquvchilar' => Oquvchi::count(),
            'jamiOqituvchilar' => User::where('role', 'teacher')->count(),
            'jamiSinflar' => Sinf::count(),
            'bugungiDavomatFoizi' => $todayPercent,
            'ortachaBaho' => Baho::count() > 0 ? round(Baho::avg('baho'), 2) : null,
            'berilganKitoblar' => (int) ($kitobRow->berilgan ?? 0),
            'berilmaganKitoblar' => (int) ($kitobRow->berilmagan ?? 0),
        ];
    }

    protected function buildSinflarData(Carbon $boshlanish, Carbon $tugash, $sinfId)
    {
        $sinflarQuery = Sinf::with('teacher')->withCount('oquvchilar');

        if ($sinfId) {
            $sinflarQuery->where('id', $sinfId);
        }

        $sinflar = $sinflarQuery->orderBy('name')->get();

        $davomatPerSinf = Davomat::select(
                'sinf_id',
                DB::raw("SUM(CASE WHEN status = 'keldi' THEN 1 ELSE 0 END) as keldi_soni"),
                DB::raw('COUNT(*) as jami_soni')
            )
            ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()])
            ->groupBy('sinf_id')
            ->get()
            ->keyBy('sinf_id');

        $bahoPerSinf = Baho::select('sinf_id', DB::raw('AVG(baho) as ortacha'))
            ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()])
            ->groupBy('sinf_id')
            ->get()
            ->keyBy('sinf_id');

        $kitobPerSinf = DB::table('oquvchilar')
            ->select(
                'sinf_id',
                DB::raw("SUM(JSON_LENGTH(JSON_EXTRACT(kitoblar, '$.berilgan'))) as berilgan"),
                DB::raw("SUM(JSON_LENGTH(JSON_EXTRACT(kitoblar, '$.berilmagan'))) as berilmagan")
            )
            ->groupBy('sinf_id')
            ->get()
            ->keyBy('sinf_id');

        return $sinflar->map(function ($sinf) use ($davomatPerSinf, $bahoPerSinf, $kitobPerSinf) {
            $d = $davomatPerSinf->get($sinf->id);
            $b = $bahoPerSinf->get($sinf->id);
            $k = $kitobPerSinf->get($sinf->id);

            $davomatFoizi = ($d && $d->jami_soni > 0)
                ? round(($d->keldi_soni / $d->jami_soni) * 100, 1)
                : null;

            return collect([
                'id' => $sinf->id,
                'name' => $sinf->name,
                'teacher' => $sinf->teacher,
                'oquvchilar_soni' => $sinf->oquvchilar_count,
                'davomat_foizi' => $davomatFoizi,
                'ortacha_baho' => $b ? round($b->ortacha, 2) : null,
                'kitob_berilgan' => (int) ($k->berilgan ?? 0),
                'kitob_berilmagan' => (int) ($k->berilmagan ?? 0),
            ]);
        });
    }

    protected function buildDavomatStat(Carbon $boshlanish, Carbon $tugash, $sinfId): array
    {
        $query = Davomat::whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()]);

        if ($sinfId) {
            $query->where('sinf_id', $sinfId);
        }

        $jami = (clone $query)->count();

        $statusSoni = (clone $query)
            ->select('status', DB::raw('count(*) as soni'))
            ->groupBy('status')
            ->pluck('soni', 'status');

        $keldi = $statusSoni->get('keldi', 0);
        $foiz = $jami > 0 ? round(($keldi / $jami) * 100, 1) : null;

        return [
            'jami' => $jami,
            'foiz' => $foiz,
            'statusSoni' => $statusSoni,
        ];
    }

    protected function buildBaholarStat(Carbon $boshlanish, Carbon $tugash, $sinfId, $fan): array
    {
        $query = Baho::whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()]);

        if ($sinfId) {
            $query->where('sinf_id', $sinfId);
        }

        if ($fan) {
            $query->where('fan', $fan);
        }

        $jami = (clone $query)->count();
        $ortacha = $jami > 0 ? round((clone $query)->avg('baho'), 2) : null;

        $taqsimot = (clone $query)
            ->select('baho', DB::raw('count(*) as soni'))
            ->groupBy('baho')
            ->pluck('soni', 'baho');

        $fanBoyicha = (clone $query)
            ->whereNotNull('fan')
            ->select('fan', DB::raw('AVG(baho) as ortacha'), DB::raw('count(*) as soni'))
            ->groupBy('fan')
            ->orderByDesc('ortacha')
            ->get();

        return [
            'jami' => $jami,
            'ortacha' => $ortacha,
            'taqsimot' => $taqsimot,
            'fanBoyicha' => $fanBoyicha,
        ];
    }

    protected function buildKutubxonaStat(): array
    {
        $row = DB::table('oquvchilar')
            ->selectRaw("SUM(JSON_LENGTH(JSON_EXTRACT(kitoblar, '$.berilgan'))) as berilgan")
            ->selectRaw("SUM(JSON_LENGTH(JSON_EXTRACT(kitoblar, '$.berilmagan'))) as berilmagan")
            ->first();

        return [
            'berilgan' => (int) ($row->berilgan ?? 0),
            'berilmagan' => (int) ($row->berilmagan ?? 0),
        ];
    }

    /**
     * TOP 10 o'quvchini (tanlangan davr va fan bo'yicha o'rtacha baho asosida) qaytaradi.
     *
     * DIQQAT: Laravel 7.30.7'da Eloquent Builder::withAvg() metodi mavjud emas
     * (u faqat Laravel 8.0+ da qo'shilgan). Shuning uchun o'rtacha bahoni
     * selectSub() orqali qo'lda hisoblaymiz.
     *
     * Jadval va ustun nomlari (masalan "bahos" jadvali, "oquvchi_id" ustuni)
     * qo'lda yozilmagan — ularni to'g'ridan-to'g'ri Oquvchi.php faylidagi
     * baholar() relationidan avtomatik olamiz, shu bilan xatoga yo'l qoldirmaymiz.
     */
    protected function buildTopOquvchilar(Carbon $boshlanish, Carbon $tugash, $fan)
    {
        $oquvchiModel = new Oquvchi();

        // baholar() relationi Oquvchi.php faylida aniqlangan bo'lishi shart.
        $relation = $oquvchiModel->baholar();

        $parentTable  = $oquvchiModel->getTable();          // masalan: oquvchilar
        $relatedTable = $relation->getRelated()->getTable(); // masalan: bahos
        $foreignKey   = $relation->getForeignKeyName();      // masalan: oquvchi_id
        $localKey     = $relation->getLocalKeyName();        // odatda: id

        $avgSubQuery = DB::table($relatedTable)
            ->selectRaw('AVG(baho)')
            ->whereColumn("{$relatedTable}.{$foreignKey}", "{$parentTable}.{$localKey}")
            ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()]);

        if ($fan) {
            $avgSubQuery->where('fan', $fan);
        }

        $top = Oquvchi::with('sinf')
            ->select("{$parentTable}.*")
            ->selectSub($avgSubQuery, 'baholar_avg_baho')
            ->havingRaw('baholar_avg_baho is not null')
            ->orderByDesc('baholar_avg_baho')
            ->take(10)
            ->get();

        return $top;
    }
}