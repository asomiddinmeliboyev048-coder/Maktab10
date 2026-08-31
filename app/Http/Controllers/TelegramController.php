<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Oquvchi;
use App\TelegramSubscriber;
use App\Services\TelegramService;
use App\Services\StudentReportService;

class TelegramController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MUHIM: Bu yerga saytingiz login sahifasining haqiqiy manzilini qo'ying.
    |--------------------------------------------------------------------------
    */
    const SITE_LOGIN_URL = 'https://smartschool.uz/login';

    const BTN_TEACHER = '📗 O‘qituvchi';
    const BTN_STUDENT = '🎓 O‘quvchi';
    const BTN_PARENT  = '👪 Ota-ona';

    const BTN_PARENT_SCHEDULE_TODAY = '📅 Bugungi dars jadvali';
    const BTN_PARENT_GRADES         = '⭐ Baho';
    const BTN_PARENT_ATTENDANCE     = '✅ Davomat';
    const BTN_MAIN_MENU             = '🏠 Bosh menyu';

    const BTN_GRADES_TODAY = '📌 Bugungi baho';
    const BTN_GRADES_WEEK  = '🗓 1 haftalik baho';

    const BTN_ATT_TODAY = '📌 Bugungi davomat';
    const BTN_ATT_WEEK  = '🗓 1 haftalik davomat';

    const BTN_BACK_PARENT = '🔙 Ota-ona menyusi';

    const STATE_AWAIT_PARENT_ID  = 'await_parent_id';
    const STATE_AWAIT_STUDENT_ID = 'await_student_id';

    protected $tg;
    protected $report;

    public function __construct(TelegramService $tg, StudentReportService $report)
    {
        $this->tg = $tg;
        $this->report = $report;
    }

    public function handleWebhook(Request $request)
    {
        try {
            $update = $request->all();

            if (!isset($update['message'])) {
                return response()->json(['status' => 'ok'], 200);
            }

            $message = $update['message'];
            $chatId = $message['chat']['id'] ?? null;
            $text = trim($message['text'] ?? '');

            if (!$chatId) {
                return response()->json(['status' => 'ok'], 200);
            }

            /* ---- /start yoki bosh menyuga qaytish ---- */
            if ($text === '/start' || $text === self::BTN_MAIN_MENU) {
                Cache::forget($this->stateKey($chatId));
                $this->sendMainMenu($chatId);
                return response()->json(['status' => 'ok'], 200);
            }

            /* ---- /help ---- */
            if ($text === '/help') {
                $this->tg->sendMessage($chatId,
                    "<b>Smart School Bot</b>\n\n" .
                    "• /start — Botni qayta ishga tushirish\n" .
                    "• Pastdagi tugmalar orqali kerakli bo'limni tanlang."
                );
                return response()->json(['status' => 'ok'], 200);
            }

            /* ---- Asosiy menyu tugmalari ---- */
            switch ($text) {
                case self::BTN_TEACHER:
                    return $this->handleTeacherButton($chatId);

                case self::BTN_STUDENT:
                    return $this->handleStudentButton($chatId);

                case self::BTN_PARENT:
                    return $this->handleParentButton($chatId);

                case self::BTN_PARENT_SCHEDULE_TODAY:
                    return $this->sendParentTodaySchedule($chatId);

                case self::BTN_PARENT_GRADES:
                    return $this->sendGradesSubmenu($chatId);

                case self::BTN_PARENT_ATTENDANCE:
                    return $this->sendAttendanceSubmenu($chatId);

                case self::BTN_GRADES_TODAY:
                    return $this->sendGradesToday($chatId);

                case self::BTN_GRADES_WEEK:
                    return $this->sendGradesWeek($chatId);

                case self::BTN_ATT_TODAY:
                    return $this->sendAttendanceToday($chatId);

                case self::BTN_ATT_WEEK:
                    return $this->sendAttendanceWeek($chatId);

                case self::BTN_BACK_PARENT:
                    return $this->sendParentMenuIfLinked($chatId);
            }

            /* ---- Holat bo'yicha ID kutilyaptimi? ---- */
            $state = Cache::get($this->stateKey($chatId));

            if ($state === self::STATE_AWAIT_PARENT_ID) {
                return $this->processParentId($chatId, $text);
            }

            if ($state === self::STATE_AWAIT_STUDENT_ID) {
                return $this->processStudentId($chatId, $text);
            }

            /* ---- Tushunarsiz xabar ---- */
            $this->tg->sendMessage(
                $chatId,
                "Kechirasiz, buyruqni tushunmadim. /start bosing yoki pastdagi tugmalardan foydalaning."
            );

            return response()->json(['status' => 'ok'], 200);

        } catch (\Throwable $e) {
            Log::error('Telegram Webhook xatolik: ' . $e->getMessage() . ' File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 200);
        }
    }

    protected function sendMainMenu($chatId)
    {
        $keyboard = $this->tg->replyKeyboard([
            [self::BTN_TEACHER, self::BTN_STUDENT],
            [self::BTN_PARENT],
        ]);

        $this->tg->sendMessage(
            $chatId,
            "Assalomu alaykum! 🎓\n\nSmart School rasmiy botiga xush kelibsiz.\nQuyidagi bo'limlardan birini tanlang:",
            $keyboard
        );
    }

    protected function stateKey($chatId): string
    {
        return "tg_state:{$chatId}";
    }

    protected function handleTeacherButton($chatId)
    {
        $inline = $this->tg->inlineUrlButton('🔐 Tizimga kirish', self::SITE_LOGIN_URL);

        $this->tg->sendMessage(
            $chatId,
            "Hurmatli o'qituvchi!\n\nTizimga kirish uchun quyidagi tugmani bosing va login/parolingiz orqali kiring.",
            $inline
        );

        $this->tg->sendMessage(
            $chatId,
            "Bosh menyuga qaytish uchun quyidagi tugmadan foydalaning.",
            $this->tg->replyKeyboard([[self::BTN_MAIN_MENU]])
        );

        return response()->json(['status' => 'ok'], 200);
    }

    protected function handleStudentButton($chatId)
    {
        Cache::put($this->stateKey($chatId), self::STATE_AWAIT_STUDENT_ID, now()->addMinutes(20));

        $this->tg->sendMessage(
            $chatId,
            "Hurmatli o'quvchi!\n\nID raqamingizni yuboring, biz sizga kerakli ma'lumotlarni taqdim etamiz."
        );

        return response()->json(['status' => 'ok'], 200);
    }

    protected function processStudentId($chatId, string $text)
    {
        $oquvchi = Oquvchi::where('student_id', $text)->first();

        if (!$oquvchi) {
            $this->tg->sendMessage($chatId, "❌ Bunday ID raqamli o'quvchi topilmadi. Qaytadan urinib ko'ring yoki /start bosing.");
            return response()->json(['status' => 'ok'], 200);
        }

        Cache::forget($this->stateKey($chatId));

        $this->tg->sendMessage(
            $chatId,
            $this->report->fullProfileText($oquvchi),
            $this->tg->replyKeyboard([[self::BTN_MAIN_MENU]])
        );

        return response()->json(['status' => 'ok'], 200);
    }

    protected function handleParentButton($chatId)
    {
        $sub = TelegramSubscriber::where('chat_id', $chatId)
            ->where('role', 'ota_ona')
            ->whereNotNull('oquvchi_id')
            ->first();

        if ($sub && $sub->oquvchi) {
            $this->tg->sendMessage(
                $chatId,
                "Xush kelibsiz! Farzandingiz: <b>{$sub->oquvchi->fio}</b>",
                $this->parentMenuKeyboard()
            );
            return response()->json(['status' => 'ok'], 200);
        }

        Cache::put($this->stateKey($chatId), self::STATE_AWAIT_PARENT_ID, now()->addMinutes(20));

        $this->tg->sendMessage(
            $chatId,
            "Hurmatli ota-ona!\n\nFarzandingizning ID raqamini yuboring, va biz sizga kerakli ma'lumotlarni taqdim etamiz."
        );

        return response()->json(['status' => 'ok'], 200);
    }

    protected function processParentId($chatId, string $text)
    {
        $oquvchi = Oquvchi::where('student_id', $text)->first();

        if (!$oquvchi) {
            $this->tg->sendMessage($chatId, "❌ Bunday ID raqamli o'quvchi topilmadi. Qaytadan urinib ko'ring yoki /start bosing.");
            return response()->json(['status' => 'ok'], 200);
        }

        TelegramSubscriber::updateOrCreate(
            ['chat_id' => $chatId],
            ['role' => 'ota_ona', 'oquvchi_id' => $oquvchi->id]
        );

        Cache::forget($this->stateKey($chatId));

        $this->tg->sendMessage($chatId, $this->report->fullProfileText($oquvchi));

        $this->tg->sendMessage(
            $chatId,
            "Endi quyidagi bo'limlardan foydalanishingiz mumkin:",
            $this->parentMenuKeyboard()
        );

        return response()->json(['status' => 'ok'], 200);
    }

    protected function parentMenuKeyboard(): array
    {
        return $this->tg->replyKeyboard([
            [self::BTN_PARENT_SCHEDULE_TODAY],
            [self::BTN_PARENT_GRADES, self::BTN_PARENT_ATTENDANCE],
            [self::BTN_MAIN_MENU],
        ]);
    }

    protected function linkedOquvchi($chatId): ?Oquvchi
    {
        $sub = TelegramSubscriber::where('chat_id', $chatId)
            ->where('role', 'ota_ona')
            ->whereNotNull('oquvchi_id')
            ->first();

        return $sub ? $sub->oquvchi : null;
    }

    protected function requireLinkedOquvchi($chatId)
    {
        $oquvchi = $this->linkedOquvchi($chatId);

        if (!$oquvchi) {
            $this->tg->sendMessage($chatId, "Avval /start bosib, Ota-ona bo'limi orqali farzandingiz ID raqamini yuboring.");
            $this->sendMainMenu($chatId);
            return null;
        }

        return $oquvchi;
    }

    protected function sendParentMenuIfLinked($chatId)
    {
        $oquvchi = $this->requireLinkedOquvchi($chatId);
        if (!$oquvchi) return response()->json(['status' => 'ok'], 200);

        $this->tg->sendMessage($chatId, "Bo'limlardan birini tanlang:", $this->parentMenuKeyboard());
        return response()->json(['status' => 'ok'], 200);
    }

    protected function sendParentTodaySchedule($chatId)
    {
        $oquvchi = $this->requireLinkedOquvchi($chatId);
        if (!$oquvchi) return response()->json(['status' => 'ok'], 200);

        if (!$oquvchi->sinf) {
            $this->tg->sendMessage($chatId, "Farzandingiz hali sinfga biriktirilmagan.");
            return response()->json(['status' => 'ok'], 200);
        }

        $this->tg->sendMessage($chatId, $this->report->todayScheduleText($oquvchi->sinf), $this->parentMenuKeyboard());
        return response()->json(['status' => 'ok'], 200);
    }

    protected function sendGradesSubmenu($chatId)
    {
        $oquvchi = $this->requireLinkedOquvchi($chatId);
        if (!$oquvchi) return response()->json(['status' => 'ok'], 200);

        $keyboard = $this->tg->replyKeyboard([
            [self::BTN_GRADES_TODAY, self::BTN_GRADES_WEEK],
            [self::BTN_BACK_PARENT],
        ]);

        $this->tg->sendMessage($chatId, "Qaysi davr uchun baholarni ko'rmoqchisiz?", $keyboard);
        return response()->json(['status' => 'ok'], 200);
    }

    protected function sendAttendanceSubmenu($chatId)
    {
        $oquvchi = $this->requireLinkedOquvchi($chatId);
        if (!$oquvchi) return response()->json(['status' => 'ok'], 200);

        $keyboard = $this->tg->replyKeyboard([
            [self::BTN_ATT_TODAY, self::BTN_ATT_WEEK],
            [self::BTN_BACK_PARENT],
        ]);

        $this->tg->sendMessage($chatId, "Qaysi davr uchun davomatni ko'rmoqchisiz?", $keyboard);
        return response()->json(['status' => 'ok'], 200);
    }

    protected function sendGradesToday($chatId)
    {
        $oquvchi = $this->requireLinkedOquvchi($chatId);
        if (!$oquvchi) return response()->json(['status' => 'ok'], 200);

        $this->tg->sendMessage($chatId, $this->report->todayGradesText($oquvchi));
        return response()->json(['status' => 'ok'], 200);
    }

    protected function sendGradesWeek($chatId)
    {
        $oquvchi = $this->requireLinkedOquvchi($chatId);
        if (!$oquvchi) return response()->json(['status' => 'ok'], 200);

        $this->tg->sendMessage($chatId, $this->report->weeklyGradesText($oquvchi));
        return response()->json(['status' => 'ok'], 200);
    }

    protected function sendAttendanceToday($chatId)
    {
        $oquvchi = $this->requireLinkedOquvchi($chatId);
        if (!$oquvchi) return response()->json(['status' => 'ok'], 200);

        $this->tg->sendMessage($chatId, $this->report->todayAttendanceText($oquvchi));
        return response()->json(['status' => 'ok'], 200);
    }

    protected function sendAttendanceWeek($chatId)
    {
        $oquvchi = $this->requireLinkedOquvchi($chatId);
        if (!$oquvchi) return response()->json(['status' => 'ok'], 200);

        $this->tg->sendMessage($chatId, $this->report->weeklyAttendanceText($oquvchi));
        return response()->json(['status' => 'ok'], 200);
    }
}