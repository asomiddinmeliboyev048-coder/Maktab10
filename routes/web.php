<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OquvchiController;


/*
|--------------------------------------------------------------------------
| Guest
|--------------------------------------------------------------------------
*/
Route::get('/set-webhook', function () {
    $token = env('TELEGRAM_BOT_TOKEN');
    $appUrl = env('APP_URL');

    if (!$token || !$appUrl) {
        return "Xatolik: .env faylida TELEGRAM_BOT_TOKEN yoki APP_URL ko'rsatilmagan!";
    }

    $webhookUrl = "{$appUrl}/api/telegram/webhook";
    $url = "https://api.telegram.org/bot{$token}/setWebhook?url={$webhookUrl}";

    $response = Http::get($url);

    return $response->json();
});


Route::middleware('guest')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Login sahifasi
    |--------------------------------------------------------------------------
    */

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    /*
    |--------------------------------------------------------------------------
    | Login yuborish
    |--------------------------------------------------------------------------
    */

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

});


/*
|--------------------------------------------------------------------------
| Authenticated users
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        return view('dashboard');

    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | DIRECTOR
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:director')->group(function () {

        Route::get('/director/test', function () {

            return 'Direktor paneli ishlayapti!';

        })->name('director.test');

    });


    /*
    |--------------------------------------------------------------------------
    | TEACHER
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:teacher')->group(function () {

        Route::get('/teacher/test', function () {

            return 'O‘qituvchi paneli ishlayapti!';

        })->name('teacher.test');

    });

});


Route::middleware(['auth', 'role:director'])->group(function () {

    Route::resource(
        'oquvchilar',
        OquvchiController::class
    );

});