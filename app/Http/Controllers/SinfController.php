<?php

namespace App\Http\Controllers;

use App\Sinf;
use App\Oquvchi;
use App\User;
use App\Imports\OquvchilarImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SinfController extends Controller
{
    /**
     * Sinflar ro'yxati.
     *
     * GET /sinflar
     */
    public function index(Request $request)
    {
        try {

            $query = Sinf::withCount('oquvchilar');

            /*
            |--------------------------------------------------------------------------
            | Qidiruv
            |--------------------------------------------------------------------------
            */

            if ($request->filled('search')) {

                $search = trim($request->search);

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('room', 'like', '%' . $search . '%');

                });
            }

            /*
            |--------------------------------------------------------------------------
            | Sinflarni chiqarish
            |--------------------------------------------------------------------------
            */

            $sinflar = $query
                ->orderBy('name', 'asc')
                ->paginate(15)
                ->appends($request->all());

            return view(
                'sinflar.index',
                compact('sinflar')
            );

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Sinflarni yuklashda xatolik yuz berdi: ' . $e->getMessage()
                );
        }
    }


    /**
     * Sinf qo'shish sahifasi.
     *
     * GET /sinflar/create
     */
    public function create()
    {
        $teachers = User::where('role', 'teacher')
            ->orderBy('name', 'asc')
            ->get();

        return view(
            'sinflar.create',
            compact('teachers')
        );
    }


    /**
     * Yangi sinfni saqlash.
     *
     * Bu metod oddiy forma orqali sinf yaratish uchun.
     *
     * Excel yuklash ham shu formadan amalga oshiriladi.
     *
     * POST /sinflar
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validatsiya
        |--------------------------------------------------------------------------
        */

        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'teacher_id' => [
                    'required',
                    'exists:users,id',
                ],

                'subject' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'room' => [
                    'nullable',
                    'string',
                    'max:100',
                ],

                'excel_file' => [
                    'nullable',
                    'file',
                    'mimes:xlsx,xls,csv',
                    'max:10240',
                ],
            ],
            [
                'name.required' =>
                    'Sinf nomini kiriting.',

                'name.string' =>
                    'Sinf nomi matn bo‘lishi kerak.',

                'name.max' =>
                    'Sinf nomi juda uzun.',

                'teacher_id.required' =>
                    'Sinf rahbarini tanlang.',

                'teacher_id.exists' =>
                    'Tanlangan sinf rahbari topilmadi.',

                'subject.string' =>
                    'Fan nomi noto‘g‘ri formatda.',

                'subject.max' =>
                    'Fan nomi juda uzun.',

                'room.string' =>
                    'Xona nomi noto‘g‘ri formatda.',

                'room.max' =>
                    'Xona nomi juda uzun.',

                'excel_file.file' =>
                    'Yuklangan fayl noto‘g‘ri.',

                'excel_file.mimes' =>
                    'Faqat XLSX, XLS yoki CSV fayllarini yuklash mumkin.',

                'excel_file.max' =>
                    'Excel fayli 10 MB dan katta bo‘lmasligi kerak.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Validation xatosi
        |--------------------------------------------------------------------------
        */

        if ($validator->fails()) {

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Transaction
        |--------------------------------------------------------------------------
        */

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Sinf nomi takrorlanmasligi
            |--------------------------------------------------------------------------
            */

            $existingClass = Sinf::where(
                'name',
                trim($request->name)
            )->first();

            if ($existingClass) {

                DB::rollBack();

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Bu nomdagi sinf allaqachon mavjud.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Sinfni yaratish
            |--------------------------------------------------------------------------
            */

            $sinf = Sinf::create([
                'name' => trim($request->name),

                'teacher_id' => $request->teacher_id,

                'subject' =>
                    $request->filled('subject')
                        ? trim($request->subject)
                        : null,

                'room' =>
                    $request->filled('room')
                        ? trim($request->room)
                        : null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Excel fayl yuklangan bo'lsa
            |--------------------------------------------------------------------------
            */

            $importedCount = 0;
            $importErrors = [];

            if (
                $request->hasFile('excel_file')
                && $request->file('excel_file')->isValid()
            ) {

                $import = new OquvchilarImport(
                    $sinf->id
                );

                Excel::import(
                    $import,
                    $request->file('excel_file')
                );

                $importedCount =
                    $import->getImportedCount();

                $importErrors =
                    $import->getErrors();
            }


            /*
            |--------------------------------------------------------------------------
            | Hammasi muvaffaqiyatli
            |--------------------------------------------------------------------------
            */

            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | Natija xabari
            |--------------------------------------------------------------------------
            */

            $message =
                'Sinf muvaffaqiyatli qo‘shildi.';

            if ($importedCount > 0) {

                $message .=
                    ' ' .
                    $importedCount .
                    ' nafar o‘quvchi ham qo‘shildi.';
            }

            if (count($importErrors) > 0) {

                $message .=
                    ' ' .
                    count($importErrors) .
                    ' ta Excel qatorida muammo borligi sababli o‘tkazib yuborildi.';
            }


            return redirect()
                ->route('sinflar.index')
                ->with(
                    'success',
                    $message
                );

        } catch (\Illuminate\Validation\ValidationException $e) {

            DB::rollBack();

            $firstError = collect($e->errors())->flatten()->first();

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Excel faylida xatolik: ' .
                    ($firstError ?? $e->getMessage())
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Sinfni saqlashda xatolik yuz berdi: ' .
                    $e->getMessage()
                );
        }
    }


    /**
     * Sinf ma'lumotlarini ko'rish.
     *
     * GET /sinflar/{id}
     */
    public function show($id)
    {
        try {

            $sinf = Sinf::with([
                'oquvchilar' => function ($query) {

                    $query
                        ->orderBy('fio', 'asc');

                }
            ])
            ->withCount('oquvchilar')
            ->findOrFail($id);


            return view(
                'sinflar.show',
                compact('sinf')
            );

        } catch (\Exception $e) {

            return redirect()
                ->route('sinflar.index')
                ->with(
                    'error',
                    'Sinfni topishda xatolik yuz berdi.'
                );
        }
    }


    /**
     * Sinfni tahrirlash sahifasi.
     *
     * GET /sinflar/{id}/edit
     */
    public function edit($id)
    {
        try {

            $sinf = Sinf::findOrFail($id);

            $teachers = User::where('role', 'teacher')
                ->orderBy('name', 'asc')
                ->get();

            return view(
                'sinflar.edit',
                compact('sinf', 'teachers')
            );

        } catch (\Exception $e) {

            return redirect()
                ->route('sinflar.index')
                ->with(
                    'error',
                    'Sinfni topishda xatolik yuz berdi.'
                );
        }
    }


    /**
     * Sinfni yangilash.
     *
     * PUT/PATCH /sinflar/{id}
     */
    public function update(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | Sinfni topish
        |--------------------------------------------------------------------------
        */

        $sinf = Sinf::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Validatsiya
        |--------------------------------------------------------------------------
        */

        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'teacher_id' => [
                    'required',
                    'exists:users,id',
                ],

                'subject' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'room' => [
                    'nullable',
                    'string',
                    'max:100',
                ],
            ],
            [
                'name.required' =>
                    'Sinf nomini kiriting.',

                'name.string' =>
                    'Sinf nomi matn bo‘lishi kerak.',

                'name.max' =>
                    'Sinf nomi juda uzun.',

                'teacher_id.required' =>
                    'Sinf rahbarini tanlang.',

                'teacher_id.exists' =>
                    'Tanlangan sinf rahbari topilmadi.',

                'subject.string' =>
                    'Fan nomi noto‘g‘ri formatda.',

                'subject.max' =>
                    'Fan nomi juda uzun.',

                'room.string' =>
                    'Xona nomi noto‘g‘ri formatda.',

                'room.max' =>
                    'Xona nomi juda uzun.',
            ]
        );


        if ($validator->fails()) {

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Bir xil sinf nomini tekshirish
        |--------------------------------------------------------------------------
        */

        $duplicate = Sinf::where(
            'name',
            trim($request->name)
        )
        ->where(
            'id',
            '!=',
            $sinf->id
        )
        ->exists();


        if ($duplicate) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Bu nomdagi boshqa sinf allaqachon mavjud.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Yangilash
        |--------------------------------------------------------------------------
        */

        try {

            $sinf->update([
                'name' =>
                    trim($request->name),

                'teacher_id' => $request->teacher_id,

                'subject' =>
                    $request->filled('subject')
                        ? trim($request->subject)
                        : null,

                'room' =>
                    $request->filled('room')
                        ? trim($request->room)
                        : null,
            ]);


            return redirect()
                ->route('sinflar.index')
                ->with(
                    'success',
                    'Sinf ma’lumotlari muvaffaqiyatli yangilandi.'
                );

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Sinfni yangilashda xatolik yuz berdi: ' .
                    $e->getMessage()
                );
        }
    }


    /**
     * Sinfni o'chirish.
     *
     * DELETE /sinflar/{id}
     */
    public function destroy($id)
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | Sinf va unga tegishli o‘quvchilarni birgalikda o‘chirish
            |--------------------------------------------------------------------------
            */

            DB::transaction(function () use ($id) {

                $sinf = Sinf::findOrFail($id);

                // Avval sinfga tegishli o‘quvchilar o‘chiriladi.
                // Shundan keyin sinfning o‘zi o‘chiriladi.
                Oquvchi::where(
                    'sinf_id',
                    $sinf->id
                )->delete();

                $sinf->delete();
            });


            return redirect()
                ->route('sinflar.index')
                ->with(
                    'success',
                    'Sinf va unga tegishli o‘quvchilar muvaffaqiyatli o‘chirildi.'
                );

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Sinfni o‘chirishda xatolik yuz berdi: ' .
                    $e->getMessage()
                );
        }
    }

    /**
     * Sinfga Excel orqali qo'shimcha o'quvchilar yuklash.
     *
     * Bu metod keyinchalik:
     *
     * Sinf → Ko'rish → O'quvchilar → Excel yuklash
     *
     * uchun ishlatiladi.
     *
     * POST /sinflar/{id}/oquvchilar/import
     */
    public function importStudents(
        Request $request,
        $id
    ) {
        /*
        |--------------------------------------------------------------------------
        | Sinfni tekshirish
        |--------------------------------------------------------------------------
        */

        $sinf = Sinf::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | Excel fayl validatsiyasi
        |--------------------------------------------------------------------------
        */

        $validator = Validator::make(
            $request->all(),
            [
                'excel_file' => [
                    'required',
                    'file',
                    'mimes:xlsx,xls,csv',
                    'max:10240',
                ],
            ],
            [
                'excel_file.required' =>
                    'Excel faylini tanlang.',

                'excel_file.file' =>
                    'Yuklangan fayl noto‘g‘ri.',

                'excel_file.mimes' =>
                    'Faqat XLSX, XLS yoki CSV fayllarini yuklash mumkin.',

                'excel_file.max' =>
                    'Excel fayli 10 MB dan katta bo‘lmasligi kerak.',
            ]
        );


        if ($validator->fails()) {

            return redirect()
                ->back()
                ->withErrors($validator);
        }


        /*
        |--------------------------------------------------------------------------
        | Import
        |--------------------------------------------------------------------------
        */

        try {

            $import = new OquvchilarImport(
                $sinf->id
            );


            Excel::import(
                $import,
                $request->file('excel_file')
            );


            $importedCount =
                $import->getImportedCount();

            $errors =
                $import->getErrors();


            /*
            |--------------------------------------------------------------------------
            | Xabar
            |--------------------------------------------------------------------------
            */

            $message =
                $importedCount .
                ' nafar o‘quvchi muvaffaqiyatli qo‘shildi.';


            if (count($errors) > 0) {

                $message .=
                    ' ' .
                    count($errors) .
                    ' ta qator o‘tkazib yuborildi.';
            }


            return redirect()
                ->back()
                ->with(
                    'success',
                    $message
                );

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Excel faylini yuklashda xatolik yuz berdi: ' .
                    $e->getMessage()
                );
        }
    }


    /**
     * Sinfdagi o'quvchilar ro'yxati.
     *
     * Keyinchalik alohida sahifada:
     *
     * - o'quvchi profili
     * - kitoblar
     * - baholar
     * - davomat
     * - tahrirlash
     * - o'chirish
     *
     * shu yerga ulanadi.
     */
    public function students(
        Request $request,
        $id
    ) {
        try {

            $sinf = Sinf::findOrFail($id);


            $query = Oquvchi::where(
                'sinf_id',
                $sinf->id
            );


            /*
            |--------------------------------------------------------------------------
            | Qidiruv
            |--------------------------------------------------------------------------
            */

            if ($request->filled('search')) {

                $search =
                    trim($request->search);


                $query->where(
                    function ($q) use ($search) {

                        $q->where(
                            'fio',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'student_id',
                            'like',
                            '%' . $search . '%'
                        )

                        ->orWhere(
                            'phone',
                            'like',
                            '%' . $search . '%'
                        );
                    }
                );
            }


            /*
            |--------------------------------------------------------------------------
            | O'quvchilar
            |--------------------------------------------------------------------------
            */

            $oquvchilar =
                $query
                    ->orderBy(
                        'fio',
                        'asc'
                    )
                    ->paginate(20)
                    ->appends(
                        $request->all()
                    );


            return view(
                'sinflar.students',
                compact(
                    'sinf',
                    'oquvchilar'
                )
            );

        } catch (\Exception $e) {

            return redirect()
                ->route('sinflar.index')
                ->with(
                    'error',
                    'O‘quvchilarni yuklashda xatolik yuz berdi: ' .
                    $e->getMessage()
                );
        }
    }
}