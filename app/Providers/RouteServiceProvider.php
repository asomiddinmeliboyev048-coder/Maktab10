<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Loyihangizda "/home" emas, "/dashboard" ishlatilgani uchun
     * shu yerga ham "/dashboard" yozildi. Aks holda Laravel ba'zi
     * standart holatlarda (masalan parolni tiklashdan keyin)
     * mavjud bo'lmagan "/home" ga yo'naltirib, 404 chiqarishi mumkin.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     * Namespace berilmadi — web.php faylidagi barcha route'lar
     * [Controller::class, 'method'] ko'rinishida yozilgani uchun
     * namespace shart emas, va $this->namespace mavjud bo'lmagani
     * sabab xatolik chiqarmasligi uchun olib tashlandi.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->group(base_path('routes/api.php'));
    }
}