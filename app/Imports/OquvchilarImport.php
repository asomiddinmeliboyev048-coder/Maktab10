<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class OquvchilarImport implements ToCollection
{
    protected $sinf_id;

    public function __construct($sinf_id)
    {
        $this->sinf_id = $sinf_id;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // Excel ustunlari:
            // $row[0] -> Tartib raqami (1, 2, 3...)
            // $row[1] -> F.I.O (Ism, familiya)
            // $row[2] -> Manzil
            // $row[3] -> Telefon (agar bo'lsa)

            $fio = $row[1] ?? null;
            $manzil = $row[2] ?? null;
            $telefon = $row[3] ?? null;

            // Birinchi qator sarlavha bo'lsa (masalan, "T/r", "F.I.O") o'tkazib yuboramiz
            if ($index === 0 && !is_numeric($row[0])) {
                continue;
            }

            if (!empty($fio)) {
                DB::table('oquvchilar')->insert([
                    'sinf_id'    => $this->sinf_id,
                    'fio'        => $fio,
                    'manzil'     => $manzil,
                    'telefon'    => $telefon,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}