<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class OqituvchilarController extends Controller
{
    public function index()
    {
        $oqituvchilar = DB::table('oqituvchilar')
            ->orderBy('fio')
            ->get();

        return view('oqituvchilar', compact(
            'oqituvchilar'
        ));
    }

    public function create()
    {
        return redirect()->route('oqituvchilar.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'fio' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255'
                ],
                'fan' => [
                    'required',
                    'string',
                    'min:2',
                    'max:150'
                ],
                'telefon' => [
                    'nullable',
                    'string',
                    'max:30'
                ],
            ],
            [
                'fio.required' => 'O‘qituvchining F.I.O.sini kiriting.',
                'fio.min' => 'F.I.O. kamida 3 ta belgidan iborat bo‘lishi kerak.',
                'fio.max' => 'F.I.O. 255 belgidan oshmasligi kerak.',
                'fan.required' => 'Fanni kiriting.',
                'fan.min' => 'Fan nomi kamida 2 ta belgidan iborat bo‘lishi kerak.',
                'fan.max' => 'Fan nomi 150 belgidan oshmasligi kerak.',
                'telefon.max' => 'Telefon raqami 30 belgidan oshmasligi kerak.',
            ]
        );

        try {
            DB::transaction(function () use ($validated) {
                DB::table('oqituvchilar')->insert([
                    'fio' => trim($validated['fio']),
                    'fan' => trim($validated['fan']),
                    'telefon' => isset($validated['telefon'])
                        ? trim($validated['telefon'])
                        : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

            return redirect()
                ->route('oqituvchilar.index')
                ->with('success', 'O‘qituvchi muvaffaqiyatli qo‘shildi.');
        } catch (Throwable $e) {
            Log::error('O‘qituvchi qo‘shishda xatolik', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'O‘qituvchini qo‘shishda xatolik yuz berdi.');
        }
    }

    public function show(string $oqituvchi)
    {
        return redirect()->route('oqituvchilar.index');
    }

    public function edit(string $oqituvchi)
    {
        return redirect()->route('oqituvchilar.index');
    }

    public function update(Request $request, string $oqituvchi)
    {
        $oqituvchiData = DB::table('oqituvchilar')
            ->where('id', $oqituvchi)
            ->first();

        if (!$oqituvchiData) {
            return redirect()
                ->route('oqituvchilar.index')
                ->with('error', 'O‘qituvchi topilmadi.');
        }

        $validated = $request->validate(
            [
                'fio' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255'
                ],
                'fan' => [
                    'required',
                    'string',
                    'min:2',
                    'max:150'
                ],
                'telefon' => [
                    'nullable',
                    'string',
                    'max:30'
                ],
            ],
            [
                'fio.required' => 'O‘qituvchining F.I.O.sini kiriting.',
                'fio.min' => 'F.I.O. kamida 3 ta belgidan iborat bo‘lishi kerak.',
                'fio.max' => 'F.I.O. 255 belgidan oshmasligi kerak.',
                'fan.required' => 'Fanni kiriting.',
                'fan.min' => 'Fan nomi kamida 2 ta belgidan iborat bo‘lishi kerak.',
                'fan.max' => 'Fan nomi 150 belgidan oshmasligi kerak.',
                'telefon.max' => 'Telefon raqami 30 belgidan oshmasligi kerak.',
            ]
        );

        try {
            DB::transaction(function () use ($validated, $oqituvchi) {
                DB::table('oqituvchilar')
                    ->where('id', $oqituvchi)
                    ->update([
                        'fio' => trim($validated['fio']),
                        'fan' => trim($validated['fan']),
                        'telefon' => isset($validated['telefon'])
                            ? trim($validated['telefon'])
                            : null,
                        'updated_at' => now(),
                    ]);
            });

            return redirect()
                ->route('oqituvchilar.index')
                ->with('success', 'O‘qituvchi ma’lumotlari muvaffaqiyatli yangilandi.');
        } catch (Throwable $e) {
            Log::error('O‘qituvchi yangilashda xatolik', [
                'oqituvchi_id' => $oqituvchi,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'O‘qituvchini yangilashda xatolik yuz berdi.');
        }
    }

    public function destroy(string $oqituvchi)
    {
        $oqituvchiData = DB::table('oqituvchilar')
            ->where('id', $oqituvchi)
            ->first();

        if (!$oqituvchiData) {
            return redirect()
                ->route('oqituvchilar.index')
                ->with('error', 'O‘qituvchi topilmadi.');
        }

        try {
            DB::transaction(function () use ($oqituvchi) {
                DB::table('oqituvchilar')
                    ->where('id', $oqituvchi)
                    ->delete();
            });

            return redirect()
                ->route('oqituvchilar.index')
                ->with('success', 'O‘qituvchi muvaffaqiyatli o‘chirildi.');
        } catch (Throwable $e) {
            Log::error('O‘qituvchi o‘chirishda xatolik', [
                'oqituvchi_id' => $oqituvchi,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->route('oqituvchilar.index')
                ->with('error', 'O‘qituvchini o‘chirishda xatolik yuz berdi.');
        }
    }
}