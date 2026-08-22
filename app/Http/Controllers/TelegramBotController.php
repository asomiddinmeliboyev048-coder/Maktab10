<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramBotController extends Controller
{
    /**
     * Telegram Webhook so'rovlarini qabul qiluvchi asosiy metod
     */
    public function handle(Request $request)
    {
        $data = $request->all();
        
        // Telegram so'rovi kelayotganini logga yozish (debug uchun)
        Log::info('Telegram Webhook Data:', $data);

        if (isset($data['message'])) {
            $chatId = $data['message']['chat']['id'];
            $text = $data['message']['text'] ?? '';

            if ($text === '/start') {
                $this->sendStartMenu($chatId);
            } elseif ($text === "📅 Dars jadvali") {
                $this->sendMessage($chatId, "Iltimos, dars jadvalini ko'rish uchun o'quvchi ID raqamini kiriting (Masalan: ST-10045):");
            } elseif ($text === "👨‍🏫 O'qituvchiga murojaat") {
                $this->sendMessage($chatId, "📞 Maktab ma'muriyati va o'qituvchilar bilan bog'lanish:\n\n- Direksiya: +998901234567\n- O'quv ishlari: +998907654321");
            } elseif (strpos($text, 'ST-') === 0) {
                // Hozircha vaqtinchalik javob (Keyinchalik baza bilan ulanadi)
                $this->sendMessage($chatId, "🆔 O'quvchi ID: {$text} qabul qilindi.\n(Hozircha baza bilan bog'lanish sozlanmoqda...)");
            } else {
                $this->sendMessage($chatId, "Tushunarsiz buyruq. Iltimos, menyudan foydalaning.");
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * /start bosilganda menyu yuborish
     */
    private function sendStartMenu($chatId)
    {
        $keyboard = [
            'keyboard' => [
                [["text" => "📅 Dars jadvali"], ["text" => "👨‍🏫 O'qituvchiga murojaat"]]
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ];

        $text = "Xush kelibsiz! Farzandingizning ID raqamini kiriting (Masalan: ST-10045) yoki quyidagi menyudan foydalaning:";
        $this->sendMessage($chatId, $text, $keyboard);
    }

    /**
     * Telegram API orqali xabar yuborish funksiyasi
     */
    private function sendMessage($chatId, $text, $replyMarkup = null)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        if (!$token) {
            Log::error('TELEGRAM_BOT_TOKEN kiritilmagan!');
            return;
        }

        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        
        $params = [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ];

        if ($replyMarkup) {
            $params['reply_markup'] = json_encode($replyMarkup);
        }

        Http::post($url, $params);
    }
}