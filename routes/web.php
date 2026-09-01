<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OquvchiController;
use App\Http\Controllers\SinfController;
use App\Http\Controllers\OqituvchiController;
use App\Http\Controllers\DarsJadvaliController;
use App\Http\Controllers\DavomatController;
use App\Http\Controllers\BaholashController;
use App\Http\Controllers\KutubxonaController;
use App\Http\Controllers\StatistikaController;
use App\Http\Controllers\ReytingController;
use App\Http\Controllers\XabarlarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsPermissionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| WELCOME (BOSH / LANDING SAHIFA)
|--------------------------------------------------------------------------
|
| Hech qanday middleware bilan cheklanmagan — login qilgan ham,
| qilmagan ham foydalanuvchi kira oladi. welcome.blade.php ichida
| @auth / @guest orqali holat farqlanadi.
|
*/
Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'redirectToLogin'])->name('root');

/*
|--------------------------------------------------------------------------
| GUEST ROUTES (LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | BAHOLAR — AUTHENTICATED USERS
    |--------------------------------------------------------------------------
    |
    | Bu route barcha login qilgan foydalanuvchilar uchun ochiq.
    | Director/deputy uchun maxsus baholash route'lari esa pastdagi
    | director,deputy guruhida qoladi.
    |
    */
    Route::get('/baholar', [BaholashController::class, 'index'])
        ->name('baholar.index');

    /*
    |--------------------------------------------------------------------------
    | DAVOMAT — director, deputy va teacher uchun umumiy kirish nuqtasi.
    |--------------------------------------------------------------------------
    |
    | Controller ichida Auth::user()->role tekshirilib, tegishli
    | ko'rinish (teacher yoki director) ko'rsatiladi.
    |
    */
    Route::get('/davomat', [DavomatController::class, 'index'])
        ->name('davomat.index');

    /*
    |--------------------------------------------------------------------------
    | PROFIL — director, deputy va teacher uchun umumiy kirish nuqtasi.
    |--------------------------------------------------------------------------
    |
    | Controller ichida Auth::user()->role tekshirilib, director/deputy
    | uchun qo'shimcha xodimlar ro'yxati ko'rsatiladi.
    |
    */
    Route::get('/profil', [ProfileController::class, 'index'])
        ->name('profil');

    Route::get('/profil/tahrirlash', [ProfileController::class, 'edit'])
        ->name('profil.edit');

    Route::put('/profil/tahrirlash', [ProfileController::class, 'update'])
        ->name('profil.update');

    Route::put('/profil/parol', [ProfileController::class, 'updatePassword'])
        ->name('profil.password.update');

    /*
    |--------------------------------------------------------------------------
    | DIRECTOR & DEPUTY (BOSHQARUV)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:director,deputy')->group(function () {

        Route::resource('oquvchilar', OquvchiController::class);

        Route::resource('sinflar', SinfController::class);

        Route::resource('oqituvchilar', OqituvchiController::class);

        /*
        |--------------------------------------------------------------------------
        | BAHOLASH — DIRECTOR / DEPUTY
        |--------------------------------------------------------------------------
        */
        Route::get(
            '/baholar/{sinf}/korish',
            [BaholashController::class, 'directorClassShow']
        )->name('baholar.director.show');

        Route::get(
            '/baholar/{sinf}/hisobot',
            [BaholashController::class, 'directorReport']
        )->name('baholar.director.report');

        Route::get(
            '/baholar/{sinf}/hisobot/excel',
            [BaholashController::class, 'directorReportExport']
        )->name('baholar.director.report.export');

        /*
        |--------------------------------------------------------------------------
        | DAVOMAT — DIRECTOR TOMONI (FAQAT KO'RISH)
        |--------------------------------------------------------------------------
        */
        Route::get(
            '/davomat/{sinf}/korish',
            [DavomatController::class, 'directorClassShow']
        )->name('davomat.director.show');

        Route::get(
            '/davomat/{sinf}/hisobot',
            [DavomatController::class, 'directorReport']
        )->name('davomat.director.report');

        Route::get(
            '/davomat/{sinf}/hisobot/excel',
            [DavomatController::class, 'directorReportExport']
        )->name('davomat.director.report.export');

        /*
        |--------------------------------------------------------------------------
        | DARS JADVALI
        |--------------------------------------------------------------------------
        */
        Route::get(
            '/dars-jadvali',
            [DarsJadvaliController::class, 'index']
        )->name('darsjadvali.index');

        // Alias: /darsjadvali oldingi sahifa uchun, lekin route cache uchun
        // nom berilmagan holda qoldiramiz, chunki bir xil URI uchun ikki
        // xil nom bo'lmasligi kerak.
        Route::get(
            '/darsjadvali',
            [DarsJadvaliController::class, 'index']
        );

        Route::get(
            '/darsjadvali/import',
            [DarsJadvaliController::class, 'importForm']
        )->name('darsjadvali.import.form');

        Route::post(
            '/dars-jadvali/import',
            [DarsJadvaliController::class, 'import']
        )->name('darsjadvali.import');

        Route::get(
            '/dars-jadvali/sinf/{sinf}',
            [DarsJadvaliController::class, 'show']
        )->name('darsjadvali.show');

        Route::delete(
            '/dars-jadvali/sinf/{sinf}',
            [DarsJadvaliController::class, 'destroySinf']
        )->name('darsjadvali.destroySinf');

        Route::post(
            '/dars-jadvali/sinf/{sinf}/dars-qoshish',
            [DarsJadvaliController::class, 'store']
        )->name('darsjadvali.store');

        Route::get(
            '/dars-jadvali/{id}/edit',
            [DarsJadvaliController::class, 'edit']
        )->name('darsjadvali.edit');

        Route::put(
            '/dars-jadvali/{id}',
            [DarsJadvaliController::class, 'update']
        )->name('darsjadvali.update');

        Route::delete(
            '/dars-jadvali/{id}',
            [DarsJadvaliController::class, 'destroy']
        )->name('darsjadvali.destroy');

        /*
        |--------------------------------------------------------------------------
        | BOSHQA BO'LIMLAR
        |--------------------------------------------------------------------------
        */
        Route::get('/xonalar', [HomeController::class, 'xonalarIndex'])->name('xonalar.index');

        // KUTUBXONA
        Route::get('/kutubxona', [KutubxonaController::class, 'index'])->name('kutubxona.index');
        Route::get('/kutubxona/berilgan', [KutubxonaController::class, 'berilgan'])->name('kutubxona.berilgan');
        Route::get('/kutubxona/berilmagan', [KutubxonaController::class, 'berilmagan'])->name('kutubxona.berilmagan');

        Route::get('/hisobotlar', [HomeController::class, 'hisobotlarIndex'])->name('hisobotlar.index');

        Route::get('/statistika', [StatistikaController::class, 'index'])->name('statistika.index');

        /*
        |--------------------------------------------------------------------------
        | O'QUVCHILAR REYTINGI
        |--------------------------------------------------------------------------
        */
        Route::get('/reyting', [ReytingController::class, 'index'])
            ->name('reyting.index');

        Route::get('/reyting/{id}/davomat', [ReytingController::class, 'davomat'])
            ->name('reyting.davomat');

        Route::get('/reyting/{id}/kunlik', [ReytingController::class, 'kunlik'])
            ->name('reyting.kunlik');

        /*
        |--------------------------------------------------------------------------
        | XABARLAR
        |--------------------------------------------------------------------------
        */
        Route::get('/xabarlar', [XabarlarController::class, 'index'])
            ->name('xabarlar.index');

        Route::get('/xabarlar/{sinf}/korish', [XabarlarController::class, 'show'])
            ->name('xabarlar.show');

        /*
        |--------------------------------------------------------------------------
        | SOZLAMALAR — FOYDALANUVCHILAR VA HUQUQLAR
        |--------------------------------------------------------------------------
        |
        | DIQQAT: "sozlamalar.index" — chap menyudagi "Sozlamalar" havolasi
        | shu route nomini chaqiradi (layouts/app.blade.php ichida).
        | Bu qator o'chirilsa yoki nomi o'zgartirilsa, BARCHA sahifalarda
        | "Route [sozlamalar.index] not defined" xatoligi chiqadi.
        |
        */
        Route::get('/sozlamalar', [SettingsPermissionController::class, 'index'])
            ->name('sozlamalar.index');

        Route::get('/sozlamalar/huquqlar', [SettingsPermissionController::class, 'index'])
            ->name('settings.permissions.index');

        Route::get('/sozlamalar/huquqlar/{user}', [SettingsPermissionController::class, 'edit'])
            ->name('settings.permissions.edit');

        Route::put('/sozlamalar/huquqlar/{user}', [SettingsPermissionController::class, 'update'])
            ->name('settings.permissions.update');

        Route::post('/sozlamalar/huquqlar/{user}/barchasini-ber', [SettingsPermissionController::class, 'grantAll'])
            ->name('settings.permissions.grantAll');

        Route::post('/sozlamalar/huquqlar/{user}/bekor-qil', [SettingsPermissionController::class, 'revokeAll'])
            ->name('settings.permissions.revokeAll');
    });

    /*
    |--------------------------------------------------------------------------
    | TEACHER (O'QITUVCHI PANELI)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:teacher')->group(function () {

        Route::get(
            '/mening-dars-jadvalim',
            [DarsJadvaliController::class, 'teacherSchedule']
        )->name('darsjadvali.teacher');

        Route::get('/teacher/test', [HomeController::class, 'teacherTest'])->name('teacher.test');

        /*
        |--------------------------------------------------------------------------
        | BAHOLAR — O'QITUVCHI TOMONI
        |--------------------------------------------------------------------------
        */
        Route::get(
            '/baholar/{sinf}/oquvchilar',
            [BaholashController::class, 'teacherClassShow']
        )->name('baholar.teacher.students');

        Route::get(
            '/baholar/{sinf}/qoyish',
            [BaholashController::class, 'mark']
        )->name('baholar.mark');

        Route::post(
            '/baholar/{sinf}/qoyish',
            [BaholashController::class, 'store']
        )->name('baholar.store');

        /*
        |--------------------------------------------------------------------------
        | DAVOMAT — O'QITUVCHI TOMONI
        |--------------------------------------------------------------------------
        */
        Route::get(
            '/davomat/{sinf}/oquvchilar',
            [DavomatController::class, 'teacherClassShow']
        )->name('davomat.teacher.students');

        Route::get(
            '/davomat/{sinf}/belgilash',
            [DavomatController::class, 'mark']
        )->name('davomat.mark');

        Route::post(
            '/davomat/{sinf}/belgilash',
            [DavomatController::class, 'store']
        )->name('davomat.store');

Route::get('/diagnostika-login', [HomeController::class, 'diagnostikaLogin']);
    });

});
