<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        /*
        |--------------------------------------------------------------------------
        | Login qilinmagan bo'lsa
        |--------------------------------------------------------------------------
        */

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /*
        |--------------------------------------------------------------------------
        | Joriy foydalanuvchini olish
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Role tekshirish
        |--------------------------------------------------------------------------
        */

        if (!in_array($user->role, $roles)) {

            abort(
                403,
                'Sizda ushbu sahifaga kirish huquqi mavjud emas.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Hammasi to'g'ri bo'lsa
        |--------------------------------------------------------------------------
        */

        return $next($request);
    }
}