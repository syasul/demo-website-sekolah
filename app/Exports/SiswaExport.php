<?php

namespace App\Exports;

use App\Models\Siswa;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected ?int $kelasId;

    public function __construct(?int $kelasId = null)
    {
        $this->kelasId = $kelasId;
    }

    public function collection(): Enumerable
    {
        $query = Siswa::with(['user', 'kelas']);
        if ($this->kelasId) {
            $query->where('kelas_id', $this->kelasId);
        }
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'NIS',
            'NISN',
            'Nama Lengkap',
            'Email Akun',
            'Kelas',
            'Jenis Kelamin (L/P)',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'Nama Orang Tua / Wali',
            'No HP Orang Tua',
            'Status',
        ];
    }

    /**
     * @param Siswa $siswa
     */
    public function map($siswa): array
    {
        return [
            $siswa->nis,
            $siswa->nisn ?? '-',
            $siswa->user ? $siswa->user->name : '-',
            $siswa->user ? $siswa->user->email : '-',
            $siswa->kelas ? $siswa->kelas->nama_lengkap : '-',
            $siswa->jenis_kelamin,
            $siswa->tempat_lahir ?? '-',
            $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '-',
            $siswa->alamat ?? '-',
            $siswa->nama_orang_tua ?? '-',
            $siswa->no_hp_orang_tua ?? '-',
            ucfirst($siswa->status),
        ];
    }
}
