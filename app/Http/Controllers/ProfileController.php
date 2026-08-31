<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Profil bosh sahifasi.
     *
     * - Har bir foydalanuvchi o'z shaxsiy ma'lumotlarini ko'radi.
     * - Director/deputy uchun qo'shimcha ravishda xodimlar
     *   (teacher + deputy) ro'yxati, qidiruv va filter bilan chiqadi.
     *
     * GET /profil
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Joriy foydalanuvchining sinf rahbarligi (mavjud relationship orqali)
        |--------------------------------------------------------------------------
        */
        $mySinflar = $user->sinflar()->withCount('oquvchilar')->get();

        $xodimlar = null;

        if (in_array($user->role, ['director', 'deputy'], true)) {

            $query = User::whereIn('role', ['teacher', 'deputy']);

            /*
            |--------------------------------------------------------------------------
            | Qidiruv: ism, staff_id, email, fan bo'yicha
            |--------------------------------------------------------------------------
            */
            if ($request->filled('search')) {
                $search = trim($request->search);

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('staff_id', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('subject', 'like', '%' . $search . '%');
                });
            }

            /*
            |--------------------------------------------------------------------------
            | Rol bo'yicha filter
            |--------------------------------------------------------------------------
            */
            if ($request->filled('role') && in_array($request->role, ['teacher', 'deputy'], true)) {
                $query->where('role', $request->role);
            }

            /*
            |--------------------------------------------------------------------------
            | Pagination hajmi (15 / 25 / 50)
            |--------------------------------------------------------------------------
            */
            $perPage = in_array((int) $request->get('per_page'), [15, 25, 50], true)
                ? (int) $request->per_page
                : 15;

            $xodimlar = $query
                ->withCount('sinflar')
                ->orderBy('name', 'asc')
                ->paginate($perPage)
                ->appends($request->all());
        }

        return view('profil.index', compact('user', 'mySinflar', 'xodimlar'));
    }

    /**
     * O'z profilini tahrirlash sahifasi.
     *
     * GET /profil/tahrirlash
     */
    public function edit()
    {
        $user = Auth::user();

        return view('profil.edit', compact('user'));
    }

    /**
     * O'z profilini yangilash.
     *
     * Faqat: name, email, login, phone, address, avatar.
     * role va staff_id ushbu forma orqali HECH QACHON o'zgarmaydi.
     *
     * PUT /profil/tahrirlash
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'login' => ['nullable', 'string', 'max:255', 'unique:users,login,' . $user->id],
                'phone' => ['nullable', 'string', 'max:50'],
                'address' => ['nullable', 'string'],
                'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            ],
            [
                'name.required' => 'Ismingizni kiriting.',
                'email.required' => 'Email kiritish majburiy.',
                'email.email' => 'Email formati noto\'g\'ri.',
                'email.unique' => 'Bu email allaqachon band.',
                'login.unique' => 'Bu login allaqachon band.',
                'avatar.image' => 'Yuklangan fayl rasm bo\'lishi kerak.',
                'avatar.mimes' => 'Faqat JPG, JPEG yoki PNG formatlari qabul qilinadi.',
                'avatar.max' => 'Rasm hajmi 2 MB dan katta bo\'lmasligi kerak.',
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->login = $request->filled('login') ? $request->login : $user->login;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('avatar')) {

            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return redirect()
            ->route('profil')
            ->with('success', 'Profil ma\'lumotlari muvaffaqiyatli yangilandi.');
    }

    /**
     * Parolni o'zgartirish.
     *
     * PUT /profil/parol
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => ['required', 'string'],
                'new_password' => ['required', 'string', 'min:6', 'confirmed'],
            ],
            [
                'current_password.required' => 'Joriy parolni kiriting.',
                'new_password.required' => 'Yangi parolni kiriting.',
                'new_password.min' => 'Yangi parol kamida 6 belgidan iborat bo\'lishi kerak.',
                'new_password.confirmed' => 'Yangi parollar mos kelmadi.',
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator, 'password')
                ->withInput();
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()
                ->back()
                ->withErrors(['current_password' => 'Joriy parol noto\'g\'ri.'], 'password')
                ->withInput();
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()
            ->route('profil')
            ->with('success', 'Parol muvaffaqiyatli yangilandi.');
    }
}