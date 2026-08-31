<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Telegram Bot API bilan ishlaydigan yordamchi servis.
 */
class TelegramService
{
    protected $botToken;
    protected $apiUrl;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}/";
    }

    /**
     * Oddiy matnli xabar yuborish.
     */
    public function sendMessage($chatId, string $text, ?array $replyMarkup = null)
    {
        if (!$this->botToken) {
            Log::error('Telegram Bot Token topilmadi (.env faylida TELEGRAM_BOT_TOKEN mavjud emas).');
            return null;
        }

        $payload = [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
        ];

        // Massivni json_encode qilmasdan to'g'ridan-to'g'ri beramiz, Http client o'zi JSON qiladi
        if ($replyMarkup !== null) {
            $payload['reply_markup'] = $replyMarkup;
        }

        try {
            // timeout(5) va retry(2, 100) orqali osilib qolishning oldi olinadi
            $response = Http::timeout(5)
                ->retry(2, 100)
                ->post($this->apiUrl . 'sendMessage', $payload);

            if (!$response->successful()) {
                Log::error('Telegram sendMessage xatolik: ' . $response->body());
            }

            return $response;
        } catch (\Exception $e) {
            Log::error('Telegram sendMessage exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Pastdan chiqadigan oddiy tugmalar klaviaturasi.
     */
    public function replyKeyboard(array $rows): array
    {
        return [
            'keyboard' => $rows,
            'resize_keyboard' => true,
            'one_time_keyboard' => false,
        ];
    }

    /**
     * Havolaga olib boruvchi inline tugma.
     */
    public function inlineUrlButton(string $label, string $url): array
    {
        return [
            'inline_keyboard' => [
                [
                    ['text' => $label, 'url' => $url],
                ],
            ],
        ];
    }
}