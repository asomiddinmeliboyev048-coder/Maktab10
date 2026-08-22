<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class XonalarController extends Controller
{
    public function index()
    {
        $xonalar = DB::table('xonalar')
            ->orderBy('nomi')
            ->get();

        return view('xonalar', compact(
            'xonalar'
        ));
    }

    public function create()
    {
        return redirect()->route('xonalar.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'nomi' => [
                    'required',
                    'string',
                    'max:100',
                    'unique:xonalar,nomi'
                ],
                'sigimi' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:10000'
                ],
            ],
            [
                'nomi.required' => 'Xona nomini kiriting.',
                'nomi.string' => 'Xona nomi matn bo‘lishi kerak.',
                'nomi.max' => 'Xona nomi 100 belgidan oshmasligi kerak.',
                'nomi.unique' => 'Bu xona allaqachon mavjud.',
                'sigimi.required' => 'Xona sig‘imini kiriting.',
                'sigimi.integer' => 'Sig‘im butun son bo‘lishi kerak.',
                'sigimi.min' => 'Sig‘im kamida 1 bo‘lishi kerak.',
                'sigimi.max' => 'Sig‘im 10000 dan katta bo‘lishi mumkin emas.',
            ]
        );

        try {
            DB::transaction(function () use ($validated) {
                DB::table('xonalar')->insert([
                    'nomi' => trim($validated['nomi']),
                    'sigimi' => $validated['sigimi'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

            return redirect()
                ->route('xonalar.index')
                ->with('success', 'Xona muvaffaqiyatli qo‘shildi.');
        } catch (Throwable $e) {
            Log::error('Xona qo‘shishda xatolik', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Xonani qo‘shishda xatolik yuz berdi.');
        }
    }

    public function show(string $xona)
    {
        return redirect()->route('xonalar.index');
    }

    public function edit(string $xona)
    {
        return redirect()->route('xonalar.index');
    }

    public function update(Request $request, string $xona)
    {
        $xonaData = DB::table('xonalar')
            ->where('id', $xona)
            ->first();

        if (!$xonaData) {
            return redirect()
                ->route('xonalar.index')
                ->with('error', 'Xona topilmadi.');
        }

        $validated = $request->validate(
            [
                'nomi' => [
                    'required',
                    'string',
                    'max:100',
                    'unique:xonalar,nomi,' . $xona
                ],
                'sigimi' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:10000'
                ],
            ],
            [
                'nomi.required' => 'Xona nomini kiriting.',
                'nomi.string' => 'Xona nomi matn bo‘lishi kerak.',
                'nomi.max' => 'Xona nomi 100 belgidan oshmasligi kerak.',
                'nomi.unique' => 'Bu xona allaqachon mavjud.',
                'sigimi.required' => 'Xona sig‘imini kiriting.',
                'sigimi.integer' => 'Sig‘im butun son bo‘lishi kerak.',
                'sigimi.min' => 'Sig‘im kamida 1 bo‘lishi kerak.',
                'sigimi.max' => 'Sig‘im 10000 dan katta bo‘lishi mumkin emas.',
            ]
        );

        try {
            DB::transaction(function () use ($validated, $xona) {
                DB::table('xonalar')
                    ->where('id', $xona)
                    ->update([
                        'nomi' => trim($validated['nomi']),
                        'sigimi' => $validated['sigimi'],
                        'updated_at' => now(),
                    ]);
            });

            return redirect()
                ->route('xonalar.index')
                ->with('success', 'Xona ma’lumotlari muvaffaqiyatli yangilandi.');
        } catch (Throwable $e) {
            Log::error('Xona yangilashda xatolik', [
                'xona_id' => $xona,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Xonani yangilashda xatolik yuz berdi.');
        }
    }

    public function destroy(string $xona)
    {
        $xonaData = DB::table('xonalar')
            ->where('id', $xona)
            ->first();

        if (!$xonaData) {
            return redirect()
                ->route('xonalar.index')
                ->with('error', 'Xona topilmadi.');
        }

        try {
            DB::transaction(function () use ($xonaData, $xona) {
                DB::table('xonalar')
                    ->where('id', $xona)
                    ->delete();
            });

            return redirect()
                ->route('xonalar.index')
                ->with('success', 'Xona muvaffaqiyatli o‘chirildi.');
        } catch (Throwable $e) {
            Log::error('Xona o‘chirishda xatolik', [
                'xona_id' => $xona,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->route('xonalar.index')
                ->with('error', 'Xonani o‘chirishda xatolik yuz berdi.');
        }
    }
}