<?php

namespace App\Http\Controllers;

use App\User;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsPermissionController extends Controller
{
    /**
     * Xodimlar ro'yxati — har birining nechta ruxsati borligi bilan.
     *
     * GET /sozlamalar/huquqlar
     */
    public function index()
    {
        $totalPermissions = Permission::count();

        $xodimlar = User::where('role', 'teacher')
            ->withCount('permissions')
            ->orderBy('name')
            ->get();

        return view('sozlamalar.huquqlar.index', compact('xodimlar', 'totalPermissions'));
    }

    /**
     * Bitta xodimning to'liq VIEW/CREATE/EDIT/DELETE jadvali.
     *
     * GET /sozlamalar/huquqlar/{user}
     */
    public function edit(User $user)
    {
        if ($user->role !== 'teacher') {
            abort(404);
        }

        $permissions = Permission::orderBy('module')->orderBy('action')->get();

        $grouped = $permissions->groupBy('module');

        $userSlugs = $user->permissions->pluck('slug')->toArray();

        return view('sozlamalar.huquqlar.edit', compact('user', 'grouped', 'userSlugs'));
    }

    /**
     * Tanlangan checkboxlar bo'yicha ruxsatlarni saqlaydi.
     *
     * PUT /sozlamalar/huquqlar/{user}
     */
    public function update(Request $request, User $user)
    {
        if ($user->role !== 'teacher') {
            abort(404);
        }

        $slugs = $request->input('permissions', []);

        $ids = Permission::whereIn('slug', $slugs)->pluck('id');

        $user->permissions()->sync($ids);

        return redirect()
            ->route('settings.permissions.edit', $user->id)
            ->with('success', $user->name . ' uchun huquqlar muvaffaqiyatli yangilandi.');
    }

    /**
     * Barcha modullarga barcha amallar bo'yicha ruxsat beradi.
     *
     * POST /sozlamalar/huquqlar/{user}/barchasini-ber
     */
    public function grantAll(User $user)
    {
        if ($user->role !== 'teacher') {
            abort(404);
        }

        $ids = Permission::pluck('id');

        $user->permissions()->sync($ids);

        return redirect()
            ->route('settings.permissions.edit', $user->id)
            ->with('success', $user->name . ' uchun barcha huquqlar berildi.');
    }

    /**
     * Foydalanuvchining barcha ruxsatlarini bekor qiladi.
     *
     * POST /sozlamalar/huquqlar/{user}/bekor-qil
     */
    public function revokeAll(User $user)
    {
        if ($user->role !== 'teacher') {
            abort(404);
        }

        $user->permissions()->sync([]);

        return redirect()
            ->route('settings.permissions.edit', $user->id)
            ->with('success', $user->name . ' uchun barcha huquqlar bekor qilindi.');
    }
}