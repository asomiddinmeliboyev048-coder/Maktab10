<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class OquvchilarController extends Controller
{
    public function index()
    {
        $oquvchilar = DB::table('oquvchilar')
            ->join('sinflar', 'oquvchilar.sinf_id', '=', 'sinflar.id')
            ->select(
                'oquvchilar.id',
                'oquvchilar.sinf_id',
                'oquvchilar.fio',
                'oquvchilar.tugilgan_sana',
                'oquvchilar.telefon',
                'oquvchilar.manzil',
                'oquvchilar.created_at',
                'sinflar.nomi as sinf_nomi'
            )
            ->orderBy('oquvchilar.fio')
            ->get();

        $sinflar = DB::table('sinflar')
            ->orderBy('nomi')
            ->get();

        return view('oquvchilar', compact(
            'oquvchilar',
            'sinflar'
        ));
    }

    public function create()
    {
        return redirect()->route('oquvchilar.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'sinf_id' => [
                    'required',
                    'integer',
                    'exists:sinflar,id'
                ],
                'fio' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255'
                ],
                'tugilgan_sana' => [
                    'required',
                    'date',
                    'before_or_equal:today'
                ],
                'telefon' => [
                    'nullable',
                    'string',
                    'max:30'
                ],
                'manzil' => [
                    'nullable',
                    'string',
                    'max:500'
                ],
            ],
            [
                'sinf_id.required' => 'Sinfni tanlang.',
                'sinf_id.integer' => 'Sinf ID noto‘g‘ri.',
                'sinf_id.exists' => 'Tanlangan sinf mavjud emas.',
                'fio.required' => 'O‘quvchining F.I.O.sini kiriting.',
                'fio.min' => 'F.I.O. kamida 3 ta belgidan iborat bo‘lishi kerak.',
                'fio.max' => 'F.I.O. 255 belgidan oshmasligi kerak.',
                'tugilgan_sana.required' => 'Tug‘ilgan sanani kiriting.',
                'tugilgan_sana.date' => 'Tug‘ilgan sana noto‘g‘ri.',
                'tugilgan_sana.before_or_equal' => 'Tug‘ilgan sana kelajakdagi sana bo‘lishi mumkin emas.',
                'telefon.max' => 'Telefon raqami 30 belgidan oshmasligi kerak.',
                'manzil.max' => 'Manzil 500 belgidan oshmasligi kerak.',
            ]
        );

        try {
            DB::transaction(function () use ($validated) {
                DB::table('oquvchilar')->insert([
                    'sinf_id' => $validated['sinf_id'],
                    'fio' => trim($validated['fio']),
                    'tugilgan_sana' => $validated['tugilgan_sana'],
                    'telefon' => isset($validated['telefon'])
                        ? trim($validated['telefon'])
                        : null,
                    'manzil' => isset($validated['manzil'])
                        ? trim($validated['manzil'])
                        : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

            return redirect()
                ->route('oquvchilar.index')
                ->with('success', 'O‘quvchi muvaffaqiyatli qo‘shildi.');
        } catch (Throwable $e) {
            Log::error('O‘quvchi qo‘shishda xatolik', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'O‘quvchini qo‘shishda xatolik yuz berdi.');
        }
    }

    public function show(string $oquvchi)
    {
        return redirect()->route('oquvchilar.index');
    }

    public function edit(string $oquvchi)
    {
        return redirect()->route('oquvchilar.index');
    }

    public function update(Request $request, string $oquvchi)
    {
        $oquvchiData = DB::table('oquvchilar')
            ->where('id', $oquvchi)
            ->first();

        if (!$oquvchiData) {
            return redirect()
                ->route('oquvchilar.index')
                ->with('error', 'O‘quvchi topilmadi.');
        }

        $validated = $request->validate(
            [
                'sinf_id' => [
                    'required',
                    'integer',
                    'exists:sinflar,id'
                ],
                'fio' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255'
                ],
                'tugilgan_sana' => [
                    'required',
                    'date',
                    'before_or_equal:today'
                ],
                'telefon' => [
                    'nullable',
                    'string',
                    'max:30'
                ],
                'manzil' => [
                    'nullable',
                    'string',
                    'max:500'
                ],
            ],
            [
                'sinf_id.required' => 'Sinfni tanlang.',
                'sinf_id.exists' => 'Tanlangan sinf mavjud emas.',
                'fio.required' => 'O‘quvchining F.I.O.sini kiriting.',
                'fio.min' => 'F.I.O. kamida 3 ta belgidan iborat bo‘lishi kerak.',
                'fio.max' => 'F.I.O. 255 belgidan oshmasligi kerak.',
                'tugilgan_sana.required' => 'Tug‘ilgan sanani kiriting.',
                'tugilgan_sana.date' => 'Tug‘ilgan sana noto‘g‘ri.',
                'tugilgan_sana.before_or_equal' => 'Tug‘ilgan sana kelajakdagi sana bo‘lishi mumkin emas.',
                'telefon.max' => 'Telefon raqami 30 belgidan oshmasligi kerak.',
                'manzil.max' => 'Manzil 500 belgidan oshmasligi kerak.',
            ]
        );

        try {
            DB::transaction(function () use ($validated, $oquvchi) {
                DB::table('oquvchilar')
                    ->where('id', $oquvchi)
                    ->update([
                        'sinf_id' => $validated['sinf_id'],
                        'fio' => trim($validated['fio']),
                        'tugilgan_sana' => $validated['tugilgan_sana'],
                        'telefon' => isset($validated['telefon'])
                            ? trim($validated['telefon'])
                            : null,
                        'manzil' => isset($validated['manzil'])
                            ? trim($validated['manzil'])
                            : null,
                        'updated_at' => now(),
                    ]);
            });

            return redirect()
                ->route('oquvchilar.index')
                ->with('success', 'O‘quvchi ma’lumotlari muvaffaqiyatli yangilandi.');
        } catch (Throwable $e) {
            Log::error('O‘quvchi yangilashda xatolik', [
                'oquvchi_id' => $oquvchi,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'O‘quvchini yangilashda xatolik yuz berdi.');
        }
    }

    public function destroy(string $oquvchi)
    {
        $oquvchiData = DB::table('oquvchilar')
            ->where('id', $oquvchi)
            ->first();

        if (!$oquvchiData) {
            return redirect()
                ->route('oquvchilar.index')
                ->with('error', 'O‘quvchi topilmadi.');
        }

        try {
            DB::transaction(function () use ($oquvchi) {
                DB::table('oquvchilar')
                    ->where('id', $oquvchi)
                    ->delete();
            });

            return redirect()
                ->route('oquvchilar.index')
                ->with('success', 'O‘quvchi muvaffaqiyatli o‘chirildi.');
        } catch (Throwable $e) {
            Log::error('O‘quvchi o‘chirishda xatolik', [
                'oquvchi_id' => $oquvchi,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->route('oquvchilar.index')
                ->with('error', 'O‘quvchini o‘chirishda xatolik yuz berdi.');
        }
    }
}