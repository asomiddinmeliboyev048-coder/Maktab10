<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TelegramSubscriber;
use App\Oquvchi;
use App\Services\TelegramService;
use App\Services\StudentReportService;

class SendTelegramDailyReports extends Command
{
    protected $signature = 'telegram:daily-report';

    protected $description = 'Barcha ota-onalarga farzandlarining kunlik baho, davomat va reytingi haqida Telegram orqali xabar yuboradi';

    protected $tg;
    protected $report;

    public function __construct(TelegramService $tg, StudentReportService $report)
    {
        parent::__construct();
        $this->tg = $tg;
        $this->report = $report;
    }

    public function handle()
    {
        $subscribers = TelegramSubscriber::where('role', 'ota_ona')
            ->whereNotNull('oquvchi_id')
            ->get();

        $this->info("Jami {$subscribers->count()} ta ota-onaga xabar yuborilmoqda...");

        foreach ($subscribers as $sub) {
            $oquvchi = Oquvchi::find($sub->oquvchi_id);

            if (!$oquvchi) {
                continue;
            }

            $this->tg->sendMessage($sub->chat_id, $this->report->dailySummaryText($oquvchi));
        }

        $this->info('Yuborish yakunlandi.');
    }
}