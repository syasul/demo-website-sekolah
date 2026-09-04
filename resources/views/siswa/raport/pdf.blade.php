<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Raport_{{ $siswa->name }}_{{ $semester }}_{{ str_replace('/', '-', $tahunAjaran) }}</title>
    <style>
        @page {
            margin: 1.2cm 1.5cm;
            size: A4 portrait;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #111;
            font-size: 11pt;
            line-height: 1.35;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat Resmi */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .kop-logo {
            width: 75px;
            text-align: center;
            vertical-align: middle;
        }

        .kop-logo img {
            width: 70px;
            height: auto;
        }

        .kop-text {
            text-align: center;
            vertical-align: middle;
        }

        .kop-yayasan {
            font-size: 11pt;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: normal;
        }

        .kop-nama-sekolah {
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 2px 0;
        }

        .kop-npsn {
            font-size: 9pt;
            font-weight: normal;
        }

        .kop-alamat {
            font-size: 8.5pt;
            color: #333;
            margin-top: 2px;
        }

        .garis-kop {
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin-bottom: 15px;
        }

        /* Judul Dokumen */
        .doc-title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            text-decoration: underline;
        }

        /* Identitas Siswa */
        .identitas-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 10pt;
        }

        .identitas-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        /* Tabel Raport Nilai */
        .nilai-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 9.5pt;
        }

        .nilai-table th, .nilai-table td {
            border: 1px solid #333;
            padding: 5px 6px;
        }

        .nilai-table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
            font-size: 9pt;
            text-transform: uppercase;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        /* Catatan & Kehadiran */
        .box-section {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 9.5pt;
        }

        .box-section td {
            vertical-align: top;
        }

        .catatan-box {
            border: 1px solid #333;
            padding: 8px 10px;
            min-height: 50px;
            font-size: 9pt;
            font-style: italic;
        }

        /* Tanda Tangan */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10pt;
            page-break-inside: avoid;
        }

        .ttd-table td {
            vertical-align: top;
            text-align: center;
            width: 33.33%;
        }

        .ttd-space {
            height: 60px;
        }

        .nama-pejabat {
            font-weight: bold;
            text-decoration: underline;
        }

        .nip-pejabat {
            font-size: 8.5pt;
        }
    </style>
</head>
<body>
    <!-- KOP SURAT RESMI -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if ($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo">
                @endif
            </td>
            <td class="kop-text">
                <div class="kop-yayasan">KEMENTERIAN AGAMA / LEMBAGA PENDIDIKAN</div>
                <div class="kop-nama-sekolah">{{ strtoupper($setting->nama_sekolah ?? 'Madrasah Aliyah At-Taraqqie') }}</div>
                <div class="kop-npsn">
                    NSM: {{ $setting->nsm ?? '131235730005' }} &bull; NPSN: {{ $setting->npsn ?? '20584478' }} &bull; {{ $setting->akreditasi ?? 'Terakreditasi A' }}
                </div>
                <div class="kop-alamat">
                    {{ $setting->alamat ?? 'Jl. Arjuno No. 34' }}, {{ $setting->kota ?? 'Malang' }}, {{ $setting->provinsi ?? 'Jawa Timur' }} | Telp: {{ $setting->telepon ?? '(0341) 362819' }} | Website: {{ $setting->website ?? 'attaraqqie.sch.id' }}
                </div>
            </td>
        </tr>
    </table>

    <div class="garis-kop"></div>

    <!-- JUDUL RAPORT -->
    <div class="doc-title">LAPORAN HASIL CAPAIAN KOMPETENSI PESERTA DIDIK</div>

    <!-- IDENTITAS SISWA -->
    <table class="identitas-table">
        <tr>
            <td style="width: 18%;">Nama Peserta Didik</td>
            <td style="width: 2%;">:</td>
            <td style="width: 40%; font-weight: bold;">{{ strtoupper($siswa->name) }}</td>
            <td style="width: 18%;">Kelas</td>
            <td style="width: 2%;">:</td>
            <td style="width: 20%; font-weight: bold;">{{ $siswa->kelas ? $siswa->kelas->nama_lengkap : '-' }}</td>
        </tr>
        <tr>
            <td>Nomor Induk / NISN</td>
            <td>:</td>
            <td>{{ $siswa->nisn }}</td>
            <td>Semester</td>
            <td>:</td>
            <td>{{ ucfirst($semester) }} ({{ strtolower($semester) === 'ganjil' ? 'Satu' : 'Dua' }})</td>
        </tr>
        <tr>
            <td>Nama Madrasah</td>
            <td>:</td>
            <td>{{ $setting->nama_sekolah ?? 'MA At-Taraqqie Malang' }}</td>
            <td>Tahun Pelajaran</td>
            <td>:</td>
            <td>{{ $tahunAjaran }}</td>
        </tr>
    </table>

    <!-- TABEL HASIL BELAJAR -->
    <table class="nilai-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 4%;">No</th>
                <th rowspan="2" style="width: 32%;">Mata Pelajaran</th>
                <th rowspan="2" style="width: 7%;">KKM</th>
                <th colspan="2" style="width: 20%;">Pengetahuan</th>
                <th colspan="2" style="width: 20%;">Keterampilan</th>
                <th rowspan="2" style="width: 7%;">Sikap</th>
                <th rowspan="2" style="width: 10%;">Nilai Akhir</th>
            </tr>
            <tr>
                <th style="width: 10%;">Angka</th>
                <th style="width: 10%;">Predikat</th>
                <th style="width: 10%;">Angka</th>
                <th style="width: 10%;">Predikat</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($nilais as $idx => $item)
                @php
                    $kkm = $item->mapel ? $item->mapel->kkm : 75;
                    $p = $item->nilai_pengetahuan;
                    $k = $item->nilai_keterampilan;
                    $predP = $p >= 90 ? 'A' : ($p >= 80 ? 'B' : ($p >= $kkm ? 'C' : 'D'));
                    $predK = $k >= 90 ? 'A' : ($k >= 80 ? 'B' : ($k >= $kkm ? 'C' : 'D'));
                @endphp
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td>{{ $item->mapel ? $item->mapel->nama_mapel : 'Mata Pelajaran' }}</td>
                    <td class="text-center">{{ $kkm }}</td>
                    <td class="text-center font-bold">{{ $p !== null ? number_format($p, 1) : '-' }}</td>
                    <td class="text-center">{{ $predP }}</td>
                    <td class="text-center">{{ $k !== null ? number_format($k, 1) : '-' }}</td>
                    <td class="text-center">{{ $predK }}</td>
                    <td class="text-center font-bold">{{ $item->nilai_sikap ?? 'B' }}</td>
                    <td class="text-center font-bold">{{ $item->nilai_akhir !== null ? number_format($item->nilai_akhir, 1) : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 15px;">Belum ada nilai yang terdata.</td>
                </tr>
            @endforelse
        </tbody>
        @if ($nilais->isNotEmpty())
            <tfoot>
                <tr style="background-color: #f9f9f9; font-weight: bold;">
                    <td colspan="3" class="text-right" style="padding-right: 10px;">RATA-RATA:</td>
                    <td class="text-center">{{ $rataRataPengetahuan }}</td>
                    <td class="text-center">-</td>
                    <td class="text-center">{{ $rataRataKeterampilan }}</td>
                    <td class="text-center">-</td>
                    <td class="text-center">-</td>
                    <td class="text-center">{{ $rataRataAkhir }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <!-- KETIDAKHADIRAN & CATATAN WALI KELAS -->
    <table class="box-section">
        <tr>
            <!-- Ketidakhadiran -->
            <td style="width: 35%; padding-right: 15px;">
                <table class="nilai-table" style="margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th colspan="2">Ketidakhadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sakit</td>
                            <td class="text-center" style="width: 35%;">0 hari</td>
                        </tr>
                        <tr>
                            <td>Izin</td>
                            <td class="text-center">1 hari</td>
                        </tr>
                        <tr>
                            <td>Tanpa Keterangan</td>
                            <td class="text-center">0 hari</td>
                        </tr>
                    </tbody>
                </table>
            </td>

            <!-- Catatan Wali Kelas -->
            <td style="width: 65%;">
                <div style="font-size: 9pt; font-weight: bold; margin-bottom: 3px;">Catatan Wali Kelas:</div>
                <div class="catatan-box">
                    "Alhamdulillah, ananda menunjukkan semangat belajar dan kedisiplinan yang baik. Pertahankan pencapaian ini dan tingkatkan pemahaman pada mata pelajaran eksakta."
                </div>
            </td>
        </tr>
    </table>

    <!-- KETERANGAN KELULUSAN / KENAIKAN -->
    <div style="border: 1px solid #333; padding: 6px 10px; font-size: 9.5pt; margin-bottom: 15px;">
        <strong>Keputusan:</strong> Berdasarkan capaian seluruh kompetensi, peserta didik dinyatakan: <strong>LULUS / NAIK KELAS</strong>.
    </div>

    <!-- TANDA TANGAN RESMI -->
    <table class="ttd-table">
        <tr>
            <td>
                Mengetahui,<br>
                Orang Tua / Wali Murid
                <div class="ttd-space"></div>
                <div class="nama-pejabat">( ........................................ )</div>
            </td>
            <td>
                {{ $setting->kota ?? 'Malang' }}, {{ $tanggalCetak }}<br>
                Wali Kelas,
                <div class="ttd-space"></div>
                <div class="nama-pejabat">{{ $siswa->kelas && $siswa->kelas->waliKelas ? $siswa->kelas->waliKelas->name : 'Wali Kelas' }}</div>
                <div class="nip-pejabat">NIP. 19820315 200801 1 005</div>
            </td>
            <td>
                Mengetahui,<br>
                Kepala Madrasah / Sekolah,
                <div class="ttd-space"></div>
                <div class="nama-pejabat">{{ $setting->nama_kepala_sekolah ?? 'Drs. H. M. Zainul Arifin, M.Pd.I' }}</div>
                <div class="nip-pejabat">{{ $setting->nip_kepala_sekolah ? 'NIP. ' . $setting->nip_kepala_sekolah : '-' }}</div>
            </td>
        </tr>
    </table>
</body>
</html>
