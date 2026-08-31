<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelegramSubscribersTable extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | telegram_subscribers
    |--------------------------------------------------------------------------
    |
    | Har bir Telegram chat_id qaysi o'quvchiga (va qaysi rolga - ota_ona)
    | bog'langanini doimiy saqlab turadi. Shu orqali ota-ona bir marta ID
    | yuborgandan keyin, keyingi barcha murojaatlarida qaytadan ID so'ralmaydi.
    |
    */
    public function up()
    {
        Schema::create('telegram_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('chat_id')->unique();
            $table->string('role')->nullable(); // ota_ona | oquvchi | oqituvchi
            $table->unsignedBigInteger('oquvchi_id')->nullable();
            $table->timestamps();

            $table->foreign('oquvchi_id')
                ->references('id')->on('oquvchilar')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('telegram_subscribers');
    }
}