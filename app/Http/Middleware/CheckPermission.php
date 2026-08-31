<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Foydalanuvchida berilgan permission slug(lar)i bor-yo'qligini
     * tekshiradi. Director/deputy uchun User::hasPermission() ichida
     * avtomatik true qaytadi (super admin).
     *
     * Ishlatilishi:
     *   Route::middleware('permission:students.view')
     */
    public function handle($request, Closure $next, string $slug)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->hasPermission($slug)) {
            abort(403, 'Sizda ushbu bo\'limga kirish huquqi mavjud emas.');
        }

        return $next($request);
    }
}