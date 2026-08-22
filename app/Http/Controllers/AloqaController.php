<?php

namespace App\Http\Controllers;

use App\Aloqa;
use Illuminate\Http\Request;

class AloqaController extends Controller
{
    public function index()
    {
        $aloqalar = Aloqa::latest()->get();

        return view('aloqa', compact('aloqalar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Aloqa::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()
            ->route('aloqa.index')
            ->with('success', 'Xabar muvaffaqiyatli saqlandi!');
    }

    public function destroy($id)
    {
        $item = Aloqa::findOrFail($id);
        $item->delete();

        return redirect()
            ->route('aloqa.index')
            ->with('success', 'Xabar o‘chirildi!');
    }
}