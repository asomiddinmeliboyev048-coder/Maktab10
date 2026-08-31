<?php

namespace App\Exports;

use App\Sinf;
use App\Davomat;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DavomatHisobotExport implements FromArray, WithHeadings, WithTitle, WithStyles
{
    protected $sinf;
    protected $oquvchilar;
    protected $statuslar;
    protected $statusLabels;
    protected $boshlanish;
    protected $tugash;

    public function __construct(Sinf $sinf, $oquvchilar, $statuslar, $statusLabels, $boshlanish, $tugash)
    {
        $this->sinf = $sinf;
        $this->oquvchilar = $oquvchilar;
        $this->statuslar = $statuslar;
        $this->statusLabels = $statusLabels;
        $this->boshlanish = $boshlanish;
        $this->tugash = $tugash;
    }

    public function array(): array
    {
        $rows = [];

        foreach ($this->oquvchilar as $i => $o) {
            $recs = $this->statuslar->get($o->id, collect());

            $row = [
                $i + 1,
                $o->fio,
            ];

            foreach ($this->statusLabels as $code => $meta) {
                $row[] = $recs->where('status', $code)->count();
            }

            $rows[] = $row;
        }

        return $rows;
    }

    public function headings(): array
    {
        $headings = ['#', 'F.I.O'];

        foreach ($this->statusLabels as $code => $meta) {
            $headings[] = strtoupper($code);
        }

        return $headings;
    }

    public function title(): string
    {
        return $this->sinf->name . ' hisobot';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}