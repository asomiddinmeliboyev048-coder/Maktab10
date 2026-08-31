<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class OqituvchiController extends Controller
{
    /**
     * O'qituvchilar va direktor o'rinbosarlari ro'yxati
     */
    public function index()
    {
        $oqituvchilar = User::whereIn('role', ['teacher', 'deputy'])
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('oqituvchilar.index', compact('oqituvchilar'));
    }

    /**
     * O'qituvchi/o'rinbosar qo'shish sahifasi
     */
    public function create()
    {
        return view('oqituvchilar.create');
    }

    /**
     * O'qituvchi/o'rinbosarni saqlash
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:teacher,deputy',
            'subject' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $avatarPath = null;

        if ($request->hasFile('avatar')) {
            // 'public' diski -> storage/app/public/avatars ichiga saqlaydi
            // va bazaga "avatars/filename.jpg" ko'rinishida yo'l yozadi
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $staffId = $this->generateStaffId($request->role);

        User::create([
            'staff_id' => $staffId,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'subject' => $request->subject,
            'phone' => $request->phone,
            'address' => $request->address,
            'avatar' => $avatarPath,
        ]);

        return redirect()
            ->route('oqituvchilar.index')
            ->with(
                'success',
                'Xodim muvaffaqiyatli qo‘shildi. Xodim ID: ' . $staffId
            );
    }

    /**
     * O'qituvchi/o'rinbosarni ko'rish
     */
    public function show($id)
    {
        $oqituvchi = User::whereIn('role', ['teacher', 'deputy'])
            ->findOrFail($id);

        return view('oqituvchilar.show', compact('oqituvchi'));
    }

    /**
     * O'qituvchi/o'rinbosarni tahrirlash
     */
    public function edit($id)
    {
        $oqituvchi = User::whereIn('role', ['teacher', 'deputy'])
            ->findOrFail($id);

        return view('oqituvchilar.edit', compact('oqituvchi'));
    }

    /**
     * O'qituvchi/o'rinbosarni yangilash
     */
    public function update(Request $request, $id)
    {
        $oqituvchi = User::whereIn('role', ['teacher', 'deputy'])
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $oqituvchi->id,
            'role' => 'required|in:teacher,deputy',
            'subject' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:6',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $oqituvchi->name = $request->name;
        $oqituvchi->email = $request->email;
        $oqituvchi->subject = $request->subject;
        $oqituvchi->phone = $request->phone;
        $oqituvchi->address = $request->address;

        /*
        |--------------------------------------------------------------------------
        | Rol o'zgargan bo'lsa - staff_id ham yangi prefiks bilan qayta yaratiladi
        |--------------------------------------------------------------------------
        */

        if ($oqituvchi->role !== $request->role) {

            $oqituvchi->role = $request->role;
            $oqituvchi->staff_id = $this->generateStaffId($request->role);
        }

        if ($request->filled('password')) {
            $oqituvchi->password = bcrypt($request->password);
        }

        if ($request->hasFile('avatar')) {

            // Eski rasmni o'chirib tashlaymiz (agar mavjud bo'lsa)
            if ($oqituvchi->avatar) {
                \Storage::disk('public')->delete($oqituvchi->avatar);
            }

            $oqituvchi->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $oqituvchi->save();

        return redirect()
            ->route('oqituvchilar.index')
            ->with('success', 'Xodim ma’lumotlari yangilandi.');
    }

    /**
     * O'qituvchi/o'rinbosarni o'chirish
     */
    public function destroy($id)
    {
        $oqituvchi = User::whereIn('role', ['teacher', 'deputy'])
            ->findOrFail($id);

        if ($oqituvchi->avatar) {
            \Storage::disk('public')->delete($oqituvchi->avatar);
        }

        $oqituvchi->delete();

        return redirect()
            ->route('oqituvchilar.index')
            ->with('success', 'Xodim muvaffaqiyatli o‘chirildi.');
    }

    /**
     * Rolga qarab avtomatik staff_id yaratish.
     *
     * teacher -> T-10023
     * deputy  -> D-10023
     */
    protected function generateStaffId($role)
    {
        $prefix = $role === 'deputy' ? 'D-' : 'T-';

        do {
            $staffId = $prefix . random_int(10000, 99999);
        } while (
            User::where('staff_id', $staffId)->exists()
        );

        return $staffId;
    }
}