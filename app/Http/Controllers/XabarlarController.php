<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Sinf;
use App\Davomat;
use App\Baho;
use App\Xabar;

class XabarlarController extends Controller
{
    /**
     * GET /xabarlar
     *
     * Barcha o'qituvchilar tomonidan qo'yilgan davomat va baholar
     * bo'yicha bildirishnomalar ro'yxati (eng oxirgisi tepada).
     */
    public function index()
    {
        $xabarlar = Xabar::with(['sinf', 'teacher'])
            ->orderByDesc('updated_at')
            ->get();

        $turiLabels = Xabar::turiLabels();

        return view('xabarlar.index', compact('xabarlar', 'turiLabels'));
    }

    /**
     * GET /xabarlar/{sinf}/korish
     *
     * Bitta sinfning tanlangan sanadagi davomati va baholari birga,
     * yuqorida umumiy statistika (jami, kelgan, kelmagan, baho
     * qo'yilgan, qo'yilmagan) bilan.
     */
    public function show(Request $request, Sinf $sinf)
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

        $baholar = Baho::with('teacher')
            ->where('sinf_id', $sinf->id)
            ->whereDate('sana', $sana)
            ->get()
            ->groupBy('oquvchi_id');

        $statusLabels = Davomat::statusLabels();

        // --- Statistika ---
        $jami = $oquvchilar->count();

        $keldiSoni = $davomatlar->where('status', 'keldi')->count();
        $belgilanganSoni = $davomatlar->count();
        $kelmadiSoni = $belgilanganSoni - $keldiSoni;
        $belgilanmaganSoni = $jami - $belgilanganSoni;

        $bahoQoyilganSoni = $baholar->count(); // distinct oquvchi_id soni
        $bahoQoyilmaganSoni = $jami - $bahoQoyilganSoni;

        // Shu sinf + shu sana uchun kim (qaysi o'qituvchi) nima qilganini ko'rsatish
        $bugungiXabarlar = Xabar::with('teacher')
            ->where('sinf_id', $sinf->id)
            ->whereDate('sana', $sana)
            ->get();

        // Sahifaga kirilganda shu sinf-sana uchun xabarlarni "o'qilgan" deb belgilaymiz
        Xabar::where('sinf_id', $sinf->id)
            ->whereDate('sana', $sana)
            ->update(['is_read' => true]);

        return view('xabarlar.show', compact(
            'sinf', 'oquvchilar', 'sana', 'davomatlar', 'baholar', 'statusLabels',
            'jami', 'keldiSoni', 'kelmadiSoni', 'belgilanmaganSoni',
            'bahoQoyilganSoni', 'bahoQoyilmaganSoni', 'bugungiXabarlar'
        ));
    }
}