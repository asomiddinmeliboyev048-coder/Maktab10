<?php

namespace App\Http\Controllers;

use App\Oquvchi;
use App\Sinf;
use Illuminate\Http\Request;

class OquvchiController extends Controller
{
    /**
     * O'quvchilar ro'yxati
     */
    public function index(Request $request)
    {
        $query = Oquvchi::with('sinf');

        /*
        |--------------------------------------------------------------------------
        | QIDIRUV
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('fio', 'like', '%' . $search . '%')
                    ->orWhere('student_id', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');

            });
        }

        /*
        |--------------------------------------------------------------------------
        | SINF BO'YICHA FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('sinf_id')) {

            $query->where(
                'sinf_id',
                $request->sinf_id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | O'QUVCHILAR
        |--------------------------------------------------------------------------
        */

        $oquvchilar = $query
            ->orderBy('fio', 'asc')
            ->paginate(15)
            ->appends($request->except('page'));

        /*
        |--------------------------------------------------------------------------
        | SINFLAR
        |--------------------------------------------------------------------------
        */

        $sinflar = Sinf::orderBy(
            'name',
            'asc'
        )->get();

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'oquvchilar.index',
            compact(
                'oquvchilar',
                'sinflar'
            )
        );
    }


    /**
     * O'quvchi qo'shish sahifasi
     */
    public function create()
    {
        $sinflar = Sinf::orderBy(
            'name',
            'asc'
        )->get();

        return view(
            'oquvchilar.create',
            compact('sinflar')
        );
    }


    /**
     * Yangi o'quvchini saqlash
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate(
            [
                'fio' => 'required|string|max:255',

                'sinf_id' => 'required|exists:sinflar,id',

                'phone' => 'nullable|string|max:50',

                'address' => 'nullable|string|max:1000',
            ],
            [
                'fio.required' =>
                    'O‘quvchining F.I.O sini kiriting.',

                'fio.string' =>
                    'F.I.O faqat matn bo‘lishi kerak.',

                'fio.max' =>
                    'F.I.O juda uzun.',

                'sinf_id.required' =>
                    'Sinfni tanlang.',

                'sinf_id.exists' =>
                    'Tanlangan sinf mavjud emas.',

                'phone.max' =>
                    'Telefon raqami juda uzun.',

                'address.max' =>
                    'Manzil juda uzun.',
            ]
        );


        try {

            /*
            |--------------------------------------------------------------------------
            | MA'LUMOTLARNI TOZALASH
            |--------------------------------------------------------------------------
            */

            $fio = trim($request->fio);

            $phone = $request->filled('phone')
                ? trim($request->phone)
                : null;

            $address = $request->filled('address')
                ? trim($request->address)
                : null;


            /*
            |--------------------------------------------------------------------------
            | STUDENT ID GENERATSIYA
            |--------------------------------------------------------------------------
            */

            do {

                $studentId =
                    'ST-' . random_int(10000, 99999);

            } while (
                Oquvchi::where(
                    'student_id',
                    $studentId
                )->exists()
            );


            /*
            |--------------------------------------------------------------------------
            | O'QUVCHINI YARATISH
            |--------------------------------------------------------------------------
            */

            Oquvchi::create([
                'student_id' => $studentId,

                'sinf_id' => $request->sinf_id,

                'fio' => $fio,

                'phone' => $phone,

                'address' => $address,
            ]);


            /*
            |--------------------------------------------------------------------------
            | MUVAFFAQIYAT
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('oquvchilar.index')
                ->with(
                    'success',
                    'O‘quvchi muvaffaqiyatli qo‘shildi.'
                );

        } catch (\Exception $e) {

            /*
            |--------------------------------------------------------------------------
            | XATOLIK
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'O‘quvchini qo‘shishda xatolik yuz berdi: '
                    . $e->getMessage()
                );
        }
    }


    /**
     * O'quvchi ma'lumotlarini ko'rish
     */
    public function show($id)
    {
        $oquvchi = Oquvchi::with('sinf')
            ->findOrFail($id);

        return view(
            'oquvchilar.show',
            compact('oquvchi')
        );
    }


    /**
     * O'quvchini tahrirlash sahifasi
     */
    public function edit($id)
    {
        /*
        |--------------------------------------------------------------------------
        | O'QUVCHI
        |--------------------------------------------------------------------------
        */

        $oquvchi = Oquvchi::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | SINFLAR
        |--------------------------------------------------------------------------
        */

        $sinflar = Sinf::orderBy(
            'name',
            'asc'
        )->get();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'oquvchilar.edit',
            compact(
                'oquvchi',
                'sinflar'
            )
        );
    }


    /**
     * O'quvchini yangilash
     */
    public function update(
        Request $request,
        $id
    ) {
        /*
        |--------------------------------------------------------------------------
        | O'QUVCHINI TOPISH
        |--------------------------------------------------------------------------
        */

        $oquvchi = Oquvchi::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $request->validate(
            [
                'fio' => 'required|string|max:255',

                'sinf_id' => 'required|exists:sinflar,id',

                'phone' => 'nullable|string|max:50',

                'address' => 'nullable|string|max:1000',
            ],
            [
                'fio.required' =>
                    'O‘quvchining F.I.O sini kiriting.',

                'fio.string' =>
                    'F.I.O faqat matn bo‘lishi kerak.',

                'fio.max' =>
                    'F.I.O juda uzun.',

                'sinf_id.required' =>
                    'Sinfni tanlang.',

                'sinf_id.exists' =>
                    'Tanlangan sinf mavjud emas.',

                'phone.max' =>
                    'Telefon raqami juda uzun.',

                'address.max' =>
                    'Manzil juda uzun.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | MA'LUMOTLARNI TOZALASH
        |--------------------------------------------------------------------------
        */

        $fio = trim($request->fio);

        $phone = $request->filled('phone')
            ? trim($request->phone)
            : null;

        $address = $request->filled('address')
            ? trim($request->address)
            : null;


        /*
        |--------------------------------------------------------------------------
        | YANGILASH
        |--------------------------------------------------------------------------
        */

        $oquvchi->update([
            'fio' => $fio,

            'sinf_id' => $request->sinf_id,

            'phone' => $phone,

            'address' => $address,
        ]);


        /*
        |--------------------------------------------------------------------------
        | MUVAFFAQIYAT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('oquvchilar.index')
            ->with(
                'success',
                'O‘quvchi ma’lumotlari muvaffaqiyatli yangilandi.'
            );
    }


    /**
     * O'quvchini o'chirish
     */
    public function destroy($id)
    {
        /*
        |--------------------------------------------------------------------------
        | O'QUVCHINI TOPISH
        |--------------------------------------------------------------------------
        */

        $oquvchi = Oquvchi::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | O'CHIRISH
        |--------------------------------------------------------------------------
        */

        $oquvchi->delete();


        /*
        |--------------------------------------------------------------------------
        | RO'YXATGA QAYTISH
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('oquvchilar.index')
            ->with(
                'success',
                'O‘quvchi muvaffaqiyatli o‘chirildi.'
            );
    }
}