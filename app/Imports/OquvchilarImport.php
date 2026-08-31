<?php

namespace App\Imports;

use App\Oquvchi;
use App\Sinf;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class OquvchilarImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * Excel orqali kelgan o'quvchilarni vaqtincha saqlash.
     */
    protected $sinfId;

    /**
     * Import natijasidagi qo'shilgan o'quvchilar soni.
     */
    protected $importedCount = 0;

    /**
     * Excel faylda xatolik bo'lgan qatorlar.
     */
    protected $errors = [];

    /**
     * Constructor.
     */
    public function __construct($sinfId)
    {
        $this->sinfId = $sinfId;
    }

    /**
     * Excel ma'lumotlarini o'qish.
     */
    public function collection(Collection $rows)
    {
        /*
        |--------------------------------------------------------------------------
        | Sinf mavjudligini tekshirish
        |--------------------------------------------------------------------------
        */

        $sinf = Sinf::find($this->sinfId);

        if (!$sinf) {
            throw new \Exception('Tanlangan sinf topilmadi.');
        }

        /*
        |--------------------------------------------------------------------------
        | Har bir Excel qatorini qayta ishlash
        |--------------------------------------------------------------------------
        */

        foreach ($rows as $index => $row) {

            /*
            |--------------------------------------------------------------------------
            | Bo'sh qatorni o'tkazib yuborish
            |--------------------------------------------------------------------------
            */

            if ($this->isEmptyRow($row)) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Excel ustunlari
            |--------------------------------------------------------------------------
            |
            | Excel fayl quyidagi ustunlardan iborat bo'ladi:
            |
            | fio
            | phone
            | address
            | kitoblar
            |
            */

            $fio = isset($row['fio'])
                ? trim($row['fio'])
                : null;

            $phone = isset($row['phone'])
                ? trim($row['phone'])
                : null;

            $address = isset($row['address'])
                ? trim($row['address'])
                : null;

            // YANGI: "kitoblar" ustunini o'qish
            $kitoblarRaw = isset($row['kitoblar'])
                ? $row['kitoblar']
                : null;

            /*
            |--------------------------------------------------------------------------
            | F.I.O majburiy
            |--------------------------------------------------------------------------
            */

            if (empty($fio)) {
                $this->errors[] = [
                    'row' => $index + 2,
                    'message' => 'F.I.O kiritilmagan.',
                ];

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | F.I.O uzunligi
            |--------------------------------------------------------------------------
            */

            if (mb_strlen($fio) > 255) {
                $this->errors[] = [
                    'row' => $index + 2,
                    'message' => 'F.I.O 255 belgidan oshmasligi kerak.',
                ];

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Telefon raqami uzunligi
            |--------------------------------------------------------------------------
            */

            if (!empty($phone) && mb_strlen($phone) > 50) {
                $this->errors[] = [
                    'row' => $index + 2,
                    'message' => 'Telefon raqami juda uzun.',
                ];

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Takroriy o'quvchini tekshirish
            |--------------------------------------------------------------------------
            |
            | Bir xil F.I.O + bir xil sinf qayta import qilinmasligi uchun.
            |
            */

            $exists = Oquvchi::where('sinf_id', $this->sinfId)
                ->where('fio', $fio)
                ->exists();

            if ($exists) {
                $this->errors[] = [
                    'row' => $index + 2,
                    'message' => 'Bu o‘quvchi ushbu sinfda allaqachon mavjud.',
                ];

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Student ID yaratish
            |--------------------------------------------------------------------------
            */

            $studentId = $this->generateStudentId();

            /*
            |--------------------------------------------------------------------------
            | "kitoblar" matnini parse qilish
            |--------------------------------------------------------------------------
            |
            | Excel'dagi format:
            |
            | ✓ O'zbek tili, Adabiyot, Algebra, ...
            | ✗ Biologiya
            |
            */

            $kitoblar = $this->parseKitoblarText($kitoblarRaw);

            /*
            |--------------------------------------------------------------------------
            | O'quvchini yaratish
            |--------------------------------------------------------------------------
            */

            Oquvchi::create([
                'student_id' => $studentId,
                'sinf_id' => $this->sinfId,
                'fio' => $fio,
                'phone' => $phone,
                'address' => $address,
                'kitoblar' => $kitoblar,
            ]);

            $this->importedCount++;
        }
    }

    /**
     * Excel ustunlarini tekshirish.
     */
    public function rules(): array
    {
        return [
            'fio' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'kitoblar' => [
                'nullable',
                'string',
            ],
        ];
    }

    /**
     * Validation xabarlari.
     */
    public function customValidationMessages()
    {
        return [
            'fio.required' => 'F.I.O kiritilishi shart.',
            'fio.string' => 'F.I.O matn bo‘lishi kerak.',
            'fio.max' => 'F.I.O 255 belgidan oshmasligi kerak.',

            'phone.string' => 'Telefon raqami matn ko‘rinishida bo‘lishi kerak.',
            'phone.max' => 'Telefon raqami 50 belgidan oshmasligi kerak.',

            'address.string' => 'Manzil matn ko‘rinishida bo‘lishi kerak.',

            'kitoblar.string' => 'Kitoblar ustuni matn ko‘rinishida bo‘lishi kerak.',
        ];
    }

    /**
     * Student ID avtomatik yaratish.
     */
    protected function generateStudentId()
    {
        do {
            $studentId = 'ST-' . random_int(10000, 99999);
        } while (
            Oquvchi::where('student_id', $studentId)->exists()
        );

        return $studentId;
    }

    /**
     * Excel qatori bo'sh yoki yo'qligini tekshirish.
     */
    protected function isEmptyRow($row)
    {
        return empty(trim((string) ($row['fio'] ?? '')))
            && empty(trim((string) ($row['phone'] ?? '')))
            && empty(trim((string) ($row['address'] ?? '')));
    }

    /**
     * YANGI METOD:
     *
     * Excel'dagi "kitoblar" katagidagi matnni parse qilib,
     * ['berilgan' => [...], 'berilmagan' => [...]] ko'rinishiga o'tkazadi.
     *
     * Kutilayotgan format:
     *
     * ✓ Fan1, Fan2, Fan3
     * ✗ Fan4
     *
     * Ikkala qator ham ixtiyoriy bo'lishi mumkin.
     */
    protected function parseKitoblarText($text)
    {
        if (empty($text) || !is_string($text)) {
            return null;
        }

        $berilgan = [];
        $berilmagan = [];

        $lines = preg_split('/\r\n|\r|\n/', trim($text));

        foreach ($lines as $line) {

            $line = trim($line);

            if ($line === '') {
                continue;
            }

            if (mb_substr($line, 0, 1) === '✓') {

                $list = mb_substr($line, 1);
                $berilgan = array_merge(
                    $berilgan,
                    $this->splitSubjects($list)
                );

            } elseif (mb_substr($line, 0, 1) === '✗') {

                $list = mb_substr($line, 1);
                $berilmagan = array_merge(
                    $berilmagan,
                    $this->splitSubjects($list)
                );
            }
        }

        if (empty($berilgan) && empty($berilmagan)) {
            return null;
        }

        return [
            'berilgan' => $berilgan,
            'berilmagan' => $berilmagan,
        ];
    }

    /**
     * YANGI METOD:
     *
     * Vergul bilan ajratilgan fanlar ro'yxatini
     * tozalab, array ko'rinishida qaytaradi.
     */
    protected function splitSubjects($text)
    {
        $items = explode(',', $text);

        $items = array_map(function ($item) {
            return trim($item);
        }, $items);

        $items = array_filter($items, function ($item) {
            return $item !== '';
        });

        return array_values($items);
    }

    /**
     * Import qilingan o'quvchilar soni.
     */
    public function getImportedCount()
    {
        return $this->importedCount;
    }

    /**
     * Importdagi xatolar.
     */
    public function getErrors()
    {
        return $this->errors;
    }
}