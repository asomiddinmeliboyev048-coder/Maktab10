<?php

namespace App\Services;

use App\Oquvchi;
use App\Sinf;
use App\Baho;
use App\Davomat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * O'quvchi haqidagi barcha matnli hisobotlarni tayyorlaydigan servis.
 */
class StudentReportService
{
    protected $kunlar = ['Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba', 'Yakshanba'];

    /**
     * Bugungi kun nomini qaytaradi.
     */
    protected function bugungiKun(): string
    {
        $index = Carbon::now()->dayOfWeekIso; // 1 = Dushanba ... 7 = Yakshanba
        return $this->kunlar[$index - 1] ?? 'Dushanba';
    }

    /**
     * O'quvchining to'liq profili.
     */
    public function fullProfileText(Oquvchi $oquvchi): string
    {
        $sinf = $oquvchi->sinf;

        $text = "<b>👤 O'quvchi ma'lumotlari</b>\n\n";
        $text .= "<b>F.I.O:</b> {$oquvchi->fio}\n";
        $text .= "<b>ID raqami:</b> {$oquvchi->student_id}\n";

        if ($sinf) {
            $text .= "<b>Sinfi:</b> {$sinf->name}\n";
            $text .= "<b>Sinf rahbari:</b> " . ($sinf->teacher->name ?? 'Biriktirilmagan') . "\n";
        } else {
            $text .= "<b>Sinfi:</b> Biriktirilmagan\n";
        }

        // JSON string bo'lsa arrayga o'giramiz
        $kitoblar = is_string($oquvchi->kitoblar) ? json_decode($oquvchi->kitoblar, true) : $oquvchi->kitoblar;
        
        $berilgan = $kitoblar['berilgan'] ?? [];
        $berilmagan = $kitoblar['berilmagan'] ?? [];

        $text .= "\n<b>📚 Berilgan darsliklar:</b>\n";
        $text .= !empty($berilgan) ? implode(', ', (array)$berilgan) : "Ma'lumot yo'q";

        $text .= "\n\n<b>❌ Berilmagan darsliklar:</b>\n";
        $text .= !empty($berilmagan) ? implode(', ', (array)$berilmagan) : "Yo'q";

        if ($sinf) {
            $text .= "\n\n" . $this->weeklyScheduleText($sinf);
        }

        return $text;
    }

    /**
     * Sinfning 1 haftalik to'liq dars jadvali.
     */
    public function weeklyScheduleText(Sinf $sinf): string
    {
        $jadval = \App\DarsJadvali::where('sinf_id', $sinf->id)
            ->orderBy('tartib', 'asc')
            ->get()
            ->groupBy('kun');

        $text = "<b>🗓 1 haftalik dars jadvali:</b>\n";

        if ($jadval->isEmpty()) {
            return $text . "Hozircha dars jadvali kiritilmagan.";
        }

        foreach ($this->kunlar as $kun) {
            if (!isset($jadval[$kun])) {
                continue;
            }

            $text .= "\n<b>{$kun}</b>\n";

            foreach ($jadval[$kun]->sortBy('tartib') as $d) {
                $text .= "{$d->tartib}-dars. {$d->fan}";
                if (!empty($d->vaqti)) {
                    $text .= " ({$d->vaqti})";
                }
                $text .= "\n";
            }
        }

        return $text;
    }

    /**
     * Bugungi kunning dars jadvali.
     */
    public function todayScheduleText(Sinf $sinf): string
    {
        $bugun = $this->bugungiKun();

        $darslar = \App\DarsJadvali::where('sinf_id', $sinf->id)
            ->where('kun', $bugun)
            ->orderBy('tartib', 'asc')
            ->get();

        $text = "<b>📅 Bugungi dars jadvali ({$bugun}):</b>\n\n";

        if ($darslar->isEmpty()) {
            return $text . "Bugun uchun dars jadvali topilmadi.";
        }

        foreach ($darslar as $d) {
            $text .= "{$d->tartib}-dars. {$d->fan}";
            if (!empty($d->vaqti)) {
                $text .= " ({$d->vaqti})";
            }
            $text .= "\n";
        }

        return $text;
    }

    /**
     * Bugungi baholar.
     */
    public function todayGradesText(Oquvchi $oquvchi): string
    {
        $baholar = Baho::where('oquvchi_id', $oquvchi->id)
            ->whereDate('sana', Carbon::today())
            ->get();

        $text = "<b>⭐ Bugungi baholar:</b>\n\n";

        if ($baholar->isEmpty()) {
            return $text . "Bugun uchun hali baho qo'yilmagan.";
        }

        foreach ($baholar as $b) {
            $fan = $b->fan ?: 'Fan ko\'rsatilmagan';
            $text .= "• {$fan} — <b>{$b->baho}</b>\n";
        }

        return $text;
    }

    /**
     * 1 haftalik baholar.
     */
    public function weeklyGradesText(Oquvchi $oquvchi): string
    {
        $boshlanish = Carbon::now()->startOfWeek();
        $tugash = Carbon::now()->endOfWeek();

        $baholar = Baho::where('oquvchi_id', $oquvchi->id)
            ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()])
            ->orderBy('sana')
            ->get();

        $text = "<b>🗓 1 haftalik baholar:</b>\n";

        if ($baholar->isEmpty()) {
            return $text . "\nUshbu hafta uchun hali baho qo'yilmagan.";
        }

        $grouped = $baholar->groupBy(function ($b) {
            return Carbon::parse($b->sana)->format('d.m.Y');
        });

        foreach ($grouped as $sana => $kunlik) {
            $text .= "\n<b>{$sana}</b>\n";
            foreach ($kunlik as $b) {
                $fan = $b->fan ?: 'Fan ko\'rsatilmagan';
                $text .= "• {$fan} — {$b->baho}\n";
            }
        }

        return $text;
    }

/**
 * Bugungi davomat holati (o'qituvchi va fan nomi bilan).
 */
public function todayAttendanceText(Oquvchi $oquvchi): string
{
    $davomatlar = Davomat::with('teacher')
        ->where('oquvchi_id', $oquvchi->id)
        ->whereDate('sana', Carbon::today())
        ->get();

    $text = "<b>✅ Bugungi davomat:</b>\n\n";

    if ($davomatlar->isEmpty()) {
        return $text . "Bugun uchun davomat hali belgilanmagan.";
    }

    $labels = Davomat::statusLabels();

    foreach ($davomatlar as $d) {
        // O'qituvchi ma'lumotlari
        $teacherName = $d->teacher->name ?? $d->teacher->fio ?? 'O\'qituvchi';
        
        // O'qituvchining fani (User modelida 'fan', 'subject' yoki 'fan_nomi' ustuni bo'lsa)
        $fanNomi = $d->teacher->fan ?? $d->teacher->subject ?? $d->teacher->fan_nomi ?? null;
        
        $fanInfo = $fanNomi ? "<b>{$fanNomi}</b>" : "<b>Dars</b>";
        $statusLabel = $labels[$d->status]['label'] ?? $d->status;

        $text .= "• {$fanInfo}: <b>{$statusLabel}</b>\n";
        $text .= "  👨‍🏫 <i>O'qituvchi:</i> {$teacherName}\n\n";
    }

    return trim($text);
}

/**
 * 1 haftalik davomat (fan va o'qituvchi ko'rsatilgan holda).
 */
public function weeklyAttendanceText(Oquvchi $oquvchi): string
{
    $boshlanish = Carbon::now()->startOfWeek();
    $tugash = Carbon::now()->endOfWeek();

    $davomatlar = Davomat::with('teacher')
        ->where('oquvchi_id', $oquvchi->id)
        ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()])
        ->orderBy('sana')
        ->get();

    $text = "<b>🗓 1 haftalik davomat:</b>\n\n";

    if ($davomatlar->isEmpty()) {
        return $text . "Ushbu hafta uchun davomat hali belgilanmagan.";
    }

    $labels = Davomat::statusLabels();

    $grouped = $davomatlar->groupBy(function ($d) {
        return Carbon::parse($d->sana)->format('d.m.Y');
    });

    foreach ($grouped as $sana => $kunlik) {
        $text .= "<b>📅 {$sana}</b>\n";
        foreach ($kunlik as $d) {
            $teacherName = $d->teacher->name ?? $d->teacher->fio ?? 'O\'qituvchi';
            $fanNomi = $d->teacher->fan ?? $d->teacher->subject ?? $d->teacher->fan_nomi ?? 'Dars';
            $statusLabel = $labels[$d->status]['label'] ?? $d->status;

            $text .= " • <b>{$fanNomi}:</b> {$statusLabel} (<i>{$teacherName}</i>)\n";
        }
        $text .= "\n";
    }

    return trim($text);
}

/**
 * 1 haftalik davomat (batafsil).
 */

public function weeklyDetailedAttendanceText(Oquvchi $oquvchi): string {
    $boshlanish = Carbon::now()->startOfWeek();
    $tugash = Carbon::now()->endOfWeek();

    $davomatlar = Davomat::with('teacher')
        ->where('oquvchi_id', $oquvchi->id)
        ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()])
        ->orderBy('sana')
        ->get();

    if ($davomatlar->isEmpty()) {
        return "Ushbu hafta uchun davomat hali belgilanmagan.";
}
    $boshlanish = Carbon::now()->startOfWeek();
    $tugash = Carbon::now()->endOfWeek();

    $davomatlar = Davomat::with(['darsJadvali', 'teacher'])
        ->where('oquvchi_id', $oquvchi->id)
        ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()])
        ->orderBy('sana')
        ->get();

    $text = "<b>🗓 1 haftalik davomat:</b>\n\n";

    if ($davomatlar->isEmpty()) {
        return $text . "Ushbu hafta uchun davomat hali belgilanmagan.";
    }

    $labels = method_exists(Davomat::class, 'statusLabels') ? Davomat::statusLabels() : [];

    $grouped = $davomatlar->groupBy(function ($d) {
        return Carbon::parse($d->sana)->format('d.m.Y');
    });

    foreach ($grouped as $sana => $kunlik) {
        $text .= "<b>📅 {$sana}</b>\n";
        foreach ($kunlik as $d) {
            $tartib = $d->darsJadvali->tartib ?? $d->tartib ?? null;
            $fan = $d->fan ?: ($d->darsJadvali->fan ?? 'Dars');
            $darsInfo = $tartib ? "{$tartib}-dars ({$fan})" : $fan;

            $oqituvchi = $d->teacher->name ?? $d->teacher->fio ?? $d->oqituvchi_ismi ?? 'Kiritilmagan';
            $statusLabel = $labels[$d->status]['label'] ?? $d->status;

            $text .= " • <b>{$darsInfo}:</b> {$statusLabel} (<i>{$oqituvchi}</i>)\n";
        }
        $text .= "\n";
    }

    return trim($text);
}

    /**
     * 1 haftalik davomat.
     */
    public function weeklyAttendanceSummaryText(Oquvchi $oquvchi): string
    {
        $boshlanish = Carbon::now()->startOfWeek();
        $tugash = Carbon::now()->endOfWeek();

        $davomatlar = Davomat::where('oquvchi_id', $oquvchi->id)
            ->whereBetween('sana', [$boshlanish->toDateString(), $tugash->toDateString()])
            ->orderBy('sana')
            ->get();

        $text = "<b>🗓 1 haftalik davomat:</b>\n\n";

        if ($davomatlar->isEmpty()) {
            return $text . "Ushbu hafta uchun davomat hali belgilanmagan.";
        }

        foreach ($davomatlar as $d) {
            $sana = Carbon::parse($d->sana)->format('d.m.Y');
            $label = $d->status;
            if (method_exists(Davomat::class, 'statusLabels')) {
                $labels = Davomat::statusLabels();
                $label = $labels[$d->status]['label'] ?? $d->status;
            }
            $text .= "• {$sana} — {$label}\n";
        }

        return $text;
    }

    /**
     * O'quvchining sinf ichidagi reytingi.
     */
    public function rankingText(Oquvchi $oquvchi): string
    {
        if (!$oquvchi->sinf_id) {
            return "<b>🏆 Reyting:</b> Sinf biriktirilmagan, reyting hisoblanmadi.";
        }

        $averages = Baho::where('sinf_id', $oquvchi->sinf_id)
            ->select('oquvchi_id', DB::raw('AVG(baho) as avg_baho'))
            ->groupBy('oquvchi_id')
            ->orderByDesc('avg_baho')
            ->get();

        if ($averages->isEmpty()) {
            return "<b>🏆 Reyting:</b> Sinfda hali baholar yetarli emas.";
        }

        $ids = $averages->pluck('oquvchi_id')->values();
        $position = $ids->search($oquvchi->id);

        if ($position === false) {
            return "<b>🏆 Reyting:</b> Sizda hali baho yo'q, reyting hisoblanmadi.";
        }

        $joy = $position + 1;
        $jami = $ids->count();

        return "<b>🏆 Sinf reytingi:</b> {$joy}-o'rin / {$jami} nafardan";
    }

    /**
     * Kunlik hisobot.
     */
    public function dailySummaryText(Oquvchi $oquvchi): string
    {
        $text = "<b>📢 {$oquvchi->fio} — kunlik hisobot</b>\n";
        $text .= "(" . Carbon::today()->format('d.m.Y') . ")\n\n";

        $text .= $this->todayGradesText($oquvchi) . "\n\n";
        $text .= $this->todayAttendanceText($oquvchi) . "\n\n";
        $text .= $this->rankingText($oquvchi);

        return $text;
    }
}