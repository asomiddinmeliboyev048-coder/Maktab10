<?php

namespace App\Exports;

use App\Sinf;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BaholarHisobotExport implements FromArray, WithHeadings, WithTitle, WithStyles
{
    protected $sinf;
    protected $oquvchilar;
    protected $baholar;

    public function __construct(Sinf $sinf, $oquvchilar, $baholar)
    {
        $this->sinf = $sinf;
        $this->oquvchilar = $oquvchilar;
        $this->baholar = $baholar;
    }

    public function array(): array
    {
        $rows = [];

        foreach ($this->oquvchilar as $i => $o) {
            $recs = $this->baholar->get($o->id, collect());

            $soni = $recs->count();
            $ortacha = $soni > 0 ? round($recs->avg('baho'), 2) : '—';

            $rows[] = [
                $i + 1,
                $o->fio,
                $soni,
                $ortacha,
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['#', 'F.I.O', 'Baholar soni', 'O\'rtacha baho'];
    }

    public function title(): string
    {
        return $this->sinf->name . ' baholar';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}