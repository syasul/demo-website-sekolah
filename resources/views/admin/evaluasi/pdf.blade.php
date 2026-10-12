<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kinerja Guru — {{ $evaluasi->guru?->name }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 11pt;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .school-name {
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
            margin: 0;
        }
        .school-info {
            font-size: 8.5pt;
            color: #64748b;
            margin-top: 4px;
        }
        .doc-title {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 15px;
            text-decoration: underline;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 10pt;
        }
        .meta-table td {
            padding: 3px 6px;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10pt;
        }
        .content-table th, .content-table td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
        }
        .content-table th {
            background-color: #f1f5f9;
            font-weight: bold;
            text-align: left;
            text-transform: uppercase;
            font-size: 8.5pt;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .badge-predikat {
            display: inline-block;
            padding: 4px 10px;
            background-color: #e0e7ff;
            color: #3730a3;
            font-weight: bold;
            border-radius: 4px;
        }
        .notes-box {
            border: 1px solid #cbd5e1;
            padding: 10px;
            border-radius: 6px;
            background-color: #f8fafc;
            margin-bottom: 25px;
            font-size: 9.5pt;
        }
        .sig-table {
            width: 100%;
            margin-top: 30px;
            font-size: 10pt;
        }
        .sig-table td {
            text-align: center;
            vertical-align: top;
            width: 50%;
        }
        .sig-space {
            height: 70px;
        }
    </style>
</head>
<body>
    <!-- KOP SURAT DINAMIS -->
    <div class="header">
        <h1 class="school-name">{{ $school->nama_sekolah ?? 'MADRASAH ALIYAH ATTARAQQIE' }}</h1>
        <div class="school-info">
            NPSN: {{ $school->npsn ?? '20580129' }} | Alamat: {{ $school->alamat ?? 'Jl. K.H. Wachid Hasyim No. 12, Malang' }}<br>
            Telp: {{ $school->telepon ?? '(0341) 362819' }} | Website: {{ $school->website ?? 'www.attaraqqie.sch.id' }}
        </div>
    </div>

    <div class="doc-title">LEMBAR LAPORAN PENILAIAN KINERJA GURU (PKG)</div>

    <!-- META DATA -->
    <table class="meta-table">
        <tr>
            <td style="width: 20%;" class="font-bold">Nama Pendidik</td>
            <td style="width: 2%;">:</td>
            <td style="width: 38%;">{{ $evaluasi->guru?->name }}</td>
            <td style="width: 18%;" class="font-bold">Tahun Ajaran</td>
            <td style="width: 2%;">:</td>
            <td style="width: 20%;">{{ $evaluasi->periode_tahun }}</td>
        </tr>
        <tr>
            <td class="font-bold">NIP / Email</td>
            <td>:</td>
            <td>{{ $evaluasi->guru?->email }}</td>
            <td class="font-bold">Semester</td>
            <td>:</td>
            <td>{{ ucfirst($evaluasi->semester) }}</td>
        </tr>
        <tr>
            <td class="font-bold">Penugasan Unit</td>
            <td>:</td>
            <td>{{ $evaluasi->unit?->nama ?: 'MA Attaraqqie Putra & Putri' }}</td>
            <td class="font-bold">Penilai</td>
            <td>:</td>
            <td>{{ $evaluasi->penilai?->name }}</td>
        </tr>
    </table>

    <!-- METRIK PENDUKUNG -->
    <table class="content-table" style="margin-bottom: 15px;">
        <thead>
            <tr>
                <th colspan="2">Indikator Aktivitas & Kehadiran Riil</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 60%;">Total Kehadiran Presensi Harian</td>
                <td class="font-bold">{{ $totalHadir ?? 24 }} Hari Aktif</td>
            </tr>
            <tr>
                <td>Total Sesi Jurnal Mengajar Terverifikasi</td>
                <td class="font-bold">{{ $totalJurnal ?? 18 }} Pertemuan</td>
            </tr>
        </tbody>
    </table>

    <!-- SKOR 4 KOMPETENSI -->
    <table class="content-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 45%;">Pilar Kompetensi Guru</th>
                <th style="width: 15%;" class="text-center">Bobot</th>
                <th style="width: 15%;" class="text-center">Skor (0-100)</th>
                <th style="width: 20%;" class="text-center">Nilai Tertimbang</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Kompetensi Pedagogik</td>
                <td class="text-center">25%</td>
                <td class="text-center font-bold">{{ $evaluasi->skor_pedagogik }}</td>
                <td class="text-center font-bold">{{ round($evaluasi->skor_pedagogik * 0.25, 2) }}</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Kompetensi Profesional</td>
                <td class="text-center">25%</td>
                <td class="text-center font-bold">{{ $evaluasi->skor_profesional }}</td>
                <td class="text-center font-bold">{{ round($evaluasi->skor_profesional * 0.25, 2) }}</td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Kompetensi Kepribadian</td>
                <td class="text-center">25%</td>
                <td class="text-center font-bold">{{ $evaluasi->skor_kepribadian }}</td>
                <td class="text-center font-bold">{{ round($evaluasi->skor_kepribadian * 0.25, 2) }}</td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Kompetensi Sosial</td>
                <td class="text-center">25%</td>
                <td class="text-center font-bold">{{ $evaluasi->skor_sosial }}</td>
                <td class="text-center font-bold">{{ round($evaluasi->skor_sosial * 0.25, 2) }}</td>
            </tr>
            <tr style="background-color: #f8fafc;">
                <td colspan="3" class="text-right font-bold">TOTAL SKOR KOMPOSIT & PREDIKAT</td>
                <td class="text-center font-bold" style="font-size: 11pt; color: #1e3a8a;">{{ $evaluasi->skor_total }}</td>
                <td class="text-center">
                    <span class="badge-predikat">{{ $evaluasi->predikat }}</span>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- CATATAN PENILAI -->
    <div class="notes-box">
        <strong>Catatan & Evaluasi Pembinaan:</strong><br>
        {{ $evaluasi->catatan ?: 'Menunjukkan kinerja dedikatif dan teladan yang sangat baik dalam proses pembelajaran santri.' }}
    </div>

    <!-- TANDA TANGAN -->
    <table class="sig-table">
        <tr>
            <td>
                Guru / Pendidik Yang Dinilai,
                <div class="sig-space"></div>
                <strong>{{ $evaluasi->guru?->name }}</strong>
            </td>
            <td>
                Malang, {{ now()->translatedFormat('d F Y') }}<br>
                Kepala Madrasah,
                <div class="sig-space"></div>
                <strong>{{ $school->nama_kepala_sekolah ?? 'Drs. H. M. Shodiq, M.Ag' }}</strong><br>
                <small>NIP. {{ $school->nip_kepala_sekolah ?? '19680512 199403 1 003' }}</small>
            </td>
        </tr>
    </table>
</body>
</html>
