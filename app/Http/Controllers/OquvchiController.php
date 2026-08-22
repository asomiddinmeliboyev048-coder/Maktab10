<?php

namespace App\Http\Controllers;

use App\Oquvchi;
use App\Sinf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OquvchiController extends Controller
{
    /**
     * O'quvchilar ro'yxati
     */
    public function index(Request $request)
    {
        $query = Oquvchi::with('sinf');

        // Qidiruv
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('fio', 'like', '%' . $search . '%')
                  ->orWhere('student_id', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');

            });
        }

        // Sinf bo'yicha filter
        if ($request->filled('sinf_id')) {

            $query->where('sinf_id', $request->sinf_id);

        }

        $oquvchilar = $query
            ->orderBy('fio')
            ->paginate(15)
            ->appends($request->all());

        $sinflar = Sinf::orderBy('name')->get();

        return view('oquvchilar.index', compact(
            'oquvchilar',
            'sinflar'
        ));
    }


    /**
     * O'quvchi qo'shish formasi
     */
    public function create()
    {
        $sinflar = Sinf::orderBy('name')->get();

        return view('oquvchilar.create', compact('sinflar'));
    }


    /**
     * O'quvchini saqlash
     */
    public function store(Request $request)
    {
        $request->validate([
            'fio' => 'required|string|max:255',
            'sinf_id' => 'required|exists:sinflar,id',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ], [
            'fio.required' => 'O‘quvchining F.I.O sini kiriting.',
            'sinf_id.required' => 'Sinfni tanlang.',
            'sinf_id.exists' => 'Tanlangan sinf mavjud emas.',
        ]);


        // Unikal student ID
        do {

            $studentId = 'ST-' . random_int(10000, 99999);

        } while (
            Oquvchi::where('student_id', $studentId)->exists()
        );


        Oquvchi::create([
            'student_id' => $studentId,
            'sinf_id' => $request->sinf_id,
            'fio' => $request->fio,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);


        return redirect()
            ->route('oquvchilar.index')
            ->with(
                'success',
                'O‘quvchi muvaffaqiyatli qo‘shildi.'
            );
    }


    /**
     * O'quvchini ko'rish
     */
    public function show($id)
    {
        $oquvchi = Oquvchi::with('sinf')->findOrFail($id);

        return view('oquvchilar.show', compact('oquvchi'));
    }


    /**
     * Tahrirlash formasi
     */
    public function edit($id)
    {
        $oquvchi = Oquvchi::findOrFail($id);

        $sinflar = Sinf::orderBy('name')->get();

        return view('oquvchilar.edit', compact(
            'oquvchi',
            'sinflar'
        ));
    }


    /**
     * Yangilash
     */
    public function update(Request $request, $id)
    {
        $oquvchi = Oquvchi::findOrFail($id);

        $request->validate([
            'fio' => 'required|string|max:255',
            'sinf_id' => 'required|exists:sinflar,id',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ], [
            'fio.required' => 'O‘quvchining F.I.O sini kiriting.',
            'sinf_id.required' => 'Sinfni tanlang.',
            'sinf_id.exists' => 'Tanlangan sinf mavjud emas.',
        ]);


        $oquvchi->update([
            'sinf_id' => $request->sinf_id,
            'fio' => $request->fio,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);


        return redirect()
            ->route('oquvchilar.index')
            ->with(
                'success',
                'O‘quvchi ma’lumotlari yangilandi.'
            );
    }


    /**
     * O'chirish
     */
    public function destroy($id)
    {
        $oquvchi = Oquvchi::findOrFail($id);

        $oquvchi->delete();

        return redirect()
            ->route('oquvchilar.index')
            ->with(
                'success',
                'O‘quvchi o‘chirildi.'
            );
    }
}