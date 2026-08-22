<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OquvchilarImport;

class SinflarController extends Controller
{
    public function index()
    {
        $sinflar = DB::table('sinflar')->orderBy('raqam', 'asc')->get();
        return view('sinflar', compact('sinflar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'raqam' => 'required|numeric',
            'harf'  => 'required|string|max:5',
            'excel_file' => 'nullable|file|mimes:xlsx,xls,csv'
        ]);

        $sinf_nomi = $request->raqam . '-' . strtoupper($request->harf);

        $sinf_id = DB::table('sinflar')->insertGetId([
            'raqam'        => $request->raqam,
            'harf'         => strtoupper($request->harf),
            'nomi'         => $sinf_nomi,
            'sinf_rahbari' => $request->sinf_rahbari,
            'xona'         => $request->xona,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        if ($request->hasFile('excel_file')) {
            Excel::import(new OquvchilarImport($sinf_id), $request->file('excel_file'));
        }

        return redirect()->back()->with('success', 'Sinf va o‘quvchilar muvaffaqiyatli saqlandi!');
    }

    // Sinf va undagi o'quvchilarni ko'rish
    public function show($id)
    {
        $sinf = DB::table('sinflar')->where('id', $id)->first();
        if (!$sinf) {
            return redirect()->route('sinflar.index')->with('error', 'Sinf topilmadi!');
        }

        $oquvchilar = DB::table('oquvchilar')->where('sinf_id', $id)->get();

        return view('sinflar_show', compact('sinf', 'oquvchilar'));
    }

    // Sinf ma'lumotlarini tahrirlash
    public function update(Request $request, $id)
    {
        $request->validate([
            'raqam' => 'required|numeric',
            'harf'  => 'required|string|max:5',
        ]);

        $sinf_nomi = $request->raqam . '-' . strtoupper($request->harf);

        DB::table('sinflar')->where('id', $id)->update([
            'raqam'        => $request->raqam,
            'harf'         => strtoupper($request->harf),
            'nomi'         => $sinf_nomi,
            'sinf_rahbari' => $request->sinf_rahbari,
            'xona'         => $request->xona,
            'updated_at'   => now(),
        ]);

        return redirect()->back()->with('success', 'Sinf ma’lumotlari yangilandi!');
    }

    // Sinfni o'chirish
    public function destroy($id)
    {
        DB::table('sinflar')->where('id', $id)->delete();
        DB::table('oquvchilar')->where('sinf_id', $id)->delete();

        return redirect()->route('sinflar.index')->with('success', 'Sinf va uning o‘quvchilari o‘chirildi!');
    }
}