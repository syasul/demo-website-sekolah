<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'NIS (Wajib, Unik)',
            'NISN (Opsional)',
            'Nama Lengkap (Wajib)',
            'Email (Opsional, otomatis dibuat jika kosong)',
            'Nama Kelas (Contoh: 10 A, 11 B, 12 C)',
            'Jenis Kelamin (L/P)',
            'Tempat Lahir',
            'Tanggal Lahir (YYYY-MM-DD)',
            'Alamat',
            'Nama Orang Tua / Wali',
            'No HP Orang Tua',
        ];
    }

    public function array(): array
    {
        return [
            [
                '1001',
                '0071234567',
                'Muhammad Rayhan Akbar',
                'rayhan@sekolah.test',
                '10 A',
                'L',
                'Malang',
                '2008-05-12',
                'Jl. Ijen No. 12 Malang',
                'Bambang Sutejo',
                '081234567890',
            ],
            [
                '1002',
                '0079876543',
                'Siti Fatimah Zahra',
                '',
                '10 A',
                'P',
                'Surabaya',
                '2008-08-20',
                'Jl. Veteran No. 45 Malang',
                'Ahmad Fauzi',
                '081298765432',
            ],
        ];
    }
}
