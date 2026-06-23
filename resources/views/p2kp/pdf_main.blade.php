<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>P2KP - {{ $p2kp->employee->name }}</title>
    <style>
        @page { size: a4 landscape; margin: 0.5cm 1cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 10pt; line-height: 1.1; margin: 0; padding: 0; color: #000; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .underline { text-decoration: underline; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
        table.bordered th, table.bordered td { border: 1px solid black; padding: 3px 5px; }
        table.no-border td { border: none; padding: 1px 3px; }
        
        .page-break { page-break-after: always; }
        
        /* Layout for Cover */
        .cover-container { width: 100%; display: table; table-layout: fixed; }
        .cover-left { width: 45%; display: table-cell; vertical-align: top; padding-right: 15px; }
        .cover-right { width: 55%; display: table-cell; vertical-align: top; padding-left: 15px; }
        
        .signature-block { margin-bottom: 40px; }
        .signature-space { height: 90px; }
        
        .logo-box { text-align: center; margin-top: 0; margin-bottom: 0; }
        .logo-img { width: 280px; height: auto; }
        
        .title-box { text-align: center; font-weight: bold; font-size: 12pt; margin-top: -5px; margin-bottom: 10px; line-height: 1.2; }
    </style>
</head>
<body>

@php
    $imageSrc = '';
    if(file_exists(public_path('Logo Universitas Sumatera Selatan.png'))) {
        $imageData = base64_encode(file_get_contents(public_path('Logo Universitas Sumatera Selatan.png')));
        $imageSrc = 'data:image/png;base64,' . $imageData;
    }
    
    // Grade logic
    if (!function_exists('getGradeLabel')) {
        function getGradeLabel($score) {
            if ($score >= 91) return 'Sangat Baik';
            if ($score >= 76) return 'Baik';
            if ($score >= 61) return 'Cukup';
            if ($score >= 51) return 'Kurang';
            return 'Buruk';
        }
    }

    // SKP Score calculation (Target vs Realisasi)
    $totalCapaian = 0;
    $validItemCount = 0;
    foreach($p2kp->items as $item) {
        $real_qty = $item->real_qty ?? 0;
        
        if ($real_qty == 0) {
            $nilai_capaian = 0;
        } else {
            $real_quality = $item->real_quality ?? 0;
            $real_time = $item->real_time ?? 0;
            
            $score_qty = $item->target_qty > 0 ? ($real_qty / $item->target_qty) * 100 : 0;
            $score_quality = $item->target_quality > 0 ? ($real_quality / $item->target_quality) * 100 : 0;
            $score_time = $item->target_time > 0 ? ((1.76 * $item->target_time) - $real_time) / $item->target_time * 100 : 0;
            
            $nilai_capaian = ($score_qty + $score_quality + $score_time) / 3;
        }
        
        $totalCapaian += $nilai_capaian;
        $validItemCount++;
    }
    $skpScore = $validItemCount > 0 ? $totalCapaian / $validItemCount : 0;
    $skp60 = $skpScore * 0.6;
    
    // Behavior Score
    $elements = [
        'Orientasi Pelayanan' => $p2kp->service_orientation,
        'Integritas' => $p2kp->integrity,
        'Komitmen' => $p2kp->commitment,
        'Disiplin' => $p2kp->discipline,
        'Kerjasama' => $p2kp->cooperation,
    ];
    if ($p2kp->leadership > 0) $elements['Kepemimpinan'] = $p2kp->leadership;
    $totalBehavior = array_sum($elements);
    $avgBehavior = count($elements) > 0 ? $totalBehavior / count($elements) : 0;
    $behavior40 = $avgBehavior * 0.4;
    
    $finalScore = $avgBehavior;
@endphp

<!-- PAGE 1: COVER & REKOMENDASI -->
<div class="cover-container">
    <!-- LEFT SIDE: REKOMENDASI & SIGNATURES -->
    <div class="cover-left">
        <div class="font-bold" style="margin-bottom: 15px; margin-top: 60px; font-size: 12pt;">REKOMENDASI</div>
        
        <!-- Rekomendasi removed as requested -->

        <div style="margin-top: 40px;"> <!-- Adjusted margin to account for lowered header -->
            <div class="signature-block" style="font-size: 11pt;">
                DIBUAT TANGGAL, {{ \Carbon\Carbon::parse($p2kp->date_signed)->locale('id')->isoFormat('D MMMM Y') }}<br>
                <span class="font-bold">PEJABAT PENILAI</span>
                <div class="signature-space"></div>
                <span class="font-bold underline">{{ $p2kp->ratingOfficial->name }}</span><br>
                NUPTK. {{ $p2kp->ratingOfficial->nuptk }}
            </div>

            <div class="signature-block" style="font-size: 11pt;">
                DITERIMA TANGGAL, {{ \Carbon\Carbon::parse($p2kp->date_signed)->locale('id')->isoFormat('D MMMM Y') }}<br>
                <span class="font-bold">PEGAWAI YANG DINILAI</span>
                <div class="signature-space"></div>
                <span class="font-bold underline">{{ $p2kp->employee->name }}</span><br>
                NUPTK. {{ $p2kp->employee->nuptk }}
            </div>

            <div class="signature-block" style="font-size: 11pt;">
                DITERIMA TANGGAL, {{ \Carbon\Carbon::parse($p2kp->date_signed)->locale('id')->isoFormat('D MMMM Y') }}<br>
                <span class="font-bold">ATASAN PEJABAT PENILAI</span>
                <div class="signature-space"></div>
                <span class="font-bold underline">{{ $p2kp->higherOfficial->name ?? '................................................' }}</span><br>
                NIP. {{ $p2kp->higherOfficial->nuptk ?? '................................................' }}
            </div>
        </div>
    </div>
    
    <!-- RIGHT SIDE: LOGO & DETAILS -->
    <div class="cover-right">
        <div class="logo-box">
            @if($imageSrc)
                <img src="{{ $imageSrc }}" class="logo-img">
            @endif
        </div>

        <div class="title-box" style="font-size: 14pt; margin-top: 15px;">
            PENILAIAN PRESTASI KERJA<br>
            UNIVERSITAS SUMATERA SELATAN
        </div>

        <table class="no-border" style="font-size: 11pt; margin-bottom: 15px;">
            <tr><td style="width: 40%;">UNIT KERJA</td><td>: {{ $p2kp->employee->unit }}</td></tr>
            <tr><td>JANGKA WAKTU PENILAIAN</td><td>: 1 Tahun</td></tr>
            <tr><td>BULAN</td><td>: {{ \Carbon\Carbon::parse($p2kp->period_start)->locale('id')->isoFormat('MMMM Y') }} s/d {{ \Carbon\Carbon::parse($p2kp->period_end)->locale('id')->isoFormat('MMMM Y') }}</td></tr>
        </table>

        <!-- Table border removed as requested (Kotak Merah) -->
        <table class="no-border" style="font-size: 11pt; margin-top: 20px;">
            <tr class="font-bold"><td style="width: 5%;">1.</td><td colspan="2">YANG DINILAI</td></tr>
            <tr><td></td><td style="width: 35%;">a. Nama</td><td>: {{ $p2kp->employee->name }}</td></tr>
            <tr><td></td><td>b. NUPTK</td><td>: {{ $p2kp->employee->nuptk }}</td></tr>
            <tr><td></td><td>c. Pangkat/Gol.</td><td>: {{ $p2kp->employee->rank }}</td></tr>
            <tr><td></td><td>d. Jabatan</td><td>: {{ $p2kp->employee->position }}</td></tr>
            <tr><td></td><td>e. Unit Organisasi</td><td>: {{ $p2kp->employee->unit }}</td></tr>

            <tr class="font-bold"><td style="padding-top: 15px;">2.</td><td colspan="2" style="padding-top: 15px;">PEJABAT PENILAI</td></tr>
            <tr><td></td><td>a. Nama</td><td>: {{ $p2kp->ratingOfficial->name }}</td></tr>
            <tr><td></td><td>b. NUPTK</td><td>: {{ $p2kp->ratingOfficial->nuptk }}</td></tr>
            <tr><td></td><td>c. Pangkat/Gol.</td><td>: {{ $p2kp->ratingOfficial->rank }}</td></tr>
            <tr><td></td><td>d. Jabatan</td><td>: {{ $p2kp->ratingOfficial->position }}</td></tr>
            <tr><td></td><td>e. Unit Organisasi</td><td>: {{ $p2kp->ratingOfficial->unit }}</td></tr>

            <tr class="font-bold"><td style="padding-top: 15px;">3.</td><td colspan="2" style="padding-top: 15px;">ATASAN PEJABAT PENILAI</td></tr>
            <tr><td></td><td>a. Nama</td><td>: {{ $p2kp->higherOfficial->name ?? '-' }}</td></tr>
            <tr><td></td><td>b. NIP</td><td>: {{ $p2kp->higherOfficial->nuptk ?? '-' }}</td></tr>
            <tr><td></td><td>c. Pangkat/Gol.</td><td>: {{ $p2kp->higherOfficial->rank ?? '-' }}</td></tr>
            <tr><td></td><td>d. Jabatan</td><td>: {{ $p2kp->higherOfficial->position ?? '-' }}</td></tr>
            <tr><td></td><td>e. Unit Organisasi</td><td>: {{ $p2kp->higherOfficial->unit ?? '-' }}</td></tr>
        </table>
    </div>
</div>

<div class="page-break"></div>

<!-- PAGE 2: UNSUR PENILAIAN & FEEDBACK -->
<table class="bordered" style="font-size: 9.5pt; width: 100%; border-collapse: collapse;">
    <tr>
        <td style="width: 3%; text-align: center;" class="font-bold">4</td>
        <td colspan="4" class="font-bold">UNSUR YANG DINILAI</td>
        <td style="width: 10%; text-align: center;" class="font-bold">Jumlah</td>
        <td style="width: 35%; border-bottom: 0;" class="font-bold">6. TANGGAPAN PEJABAT PENILAI</td>
    </tr>
    <!-- Row SKP -->
    <tr>
        <td style="border-bottom: 0;"></td>
        <td colspan="2">Sasaran Kinerja Pegawai (SKP)</td>
        <td style="width: 15%; text-align: center;">x 60%</td>
        <td style="width: 10%;"></td>
        <td style="text-align: center;"></td>
        <td rowspan="11" style="vertical-align: top; padding: 5px; border-top: 0;">
            <span class="font-bold">ATAS KEBERATAN</span><br><br>
            {{ $p2kp->response }}
            <br><br><br><br><br><br><br><br><br><br><br><br>
            Tanggal, ....................................
        </td>
    </tr>
    <!-- Row Perilaku Kerja Starts -->
    <tr>
        <td style="border-top: 0; border-bottom: 0;"></td>
        <td rowspan="10" style="width: 12%; vertical-align: top;">a. Perilaku kerja</td>
        <td style="width: 25%;">1. Orientasi Pelayanan</td>
        <td class="text-center">{{ number_format($p2kp->service_orientation, 2) }}</td>
        <td class="text-center">Baik</td>
        <td></td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;"></td>
        <td>2. Integritas</td>
        <td class="text-center">{{ number_format($p2kp->integrity, 2) }}</td>
        <td class="text-center">Baik</td>
        <td></td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;"></td>
        <td>3. Komitment</td>
        <td class="text-center">{{ number_format($p2kp->commitment, 2) }}</td>
        <td class="text-center">Baik</td>
        <td></td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;"></td>
        <td>4. Disiplin</td>
        <td class="text-center">{{ number_format($p2kp->discipline, 2) }}</td>
        <td class="text-center">Baik</td>
        <td></td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;"></td>
        <td>5. Kerjasama</td>
        <td class="text-center">{{ number_format($p2kp->cooperation, 2) }}</td>
        <td class="text-center">Baik</td>
        <td></td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;"></td>
        <td>6. Kepemimpinan</td>
        <td class="text-center">{{ $p2kp->leadership ? number_format($p2kp->leadership, 2) : '-' }}</td>
        <td class="text-center">{{ $p2kp->leadership ? 'Baik' : '-' }}</td>
        <td></td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;"></td>
        <td>7. Jumlah</td>
        <td class="text-center">{{ number_format($totalBehavior, 2) }}</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;"></td>
        <td>8. Nilai rata-rata</td>
        <td class="text-center">{{ number_format($avgBehavior, 2) }}</td>
        <td class="text-center">Baik</td>
        <td></td>
    </tr>
    <tr>
        <td style="border-top: 0; border-bottom: 0;"></td>
        <td>9. Nilai Perilaku Kerja</td>
        <td class="text-center">{{ number_format($avgBehavior, 2) }} x 40%</td>
        <td></td>
        <td class="text-center">{{ number_format($behavior40, 2) }}</td>
    </tr>
    <!-- Final Result Row -->
    <tr>
        <td style="border-top: 0;"></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="text-center font-bold">
            {{ number_format($finalScore, 2) }}<br>
            ({{ getGradeLabel($finalScore) }})
        </td>
    </tr>
</table>

<table style="width: 100%; font-size: 9.5pt; margin-top: 15px; border-collapse: collapse; table-layout: fixed;">
    <tr>
        <td style="width: 40%; vertical-align: top; border: 0; text-align: left;">
            <span class="font-bold">5. KEBERATAN DARI PEGAWAI</span><br>
            <span class="font-bold">KEBERATAN</span><br>
            <span class="font-bold">YANG DINILAI (APABILA ADA)</span><br><br>
            {{ $p2kp->objection }}
            <br><br><br><br><br><br><br><br>
            Tanggal, ....................................
        </td>
        <td style="width: 20%; border: 0;"></td>
        <td style="width: 40%; vertical-align: top; border: 0; text-align: left;">
            <div style="width: 100%;">
                <span class="font-bold">7. KEPUTUSAN ATASAN PEJABAT PENILAI</span><br>
                <span class="font-bold">ATAS KEBERATAN</span><br><br><br>
                {{ $p2kp->decision }}
                <br><br><br><br><br><br><br><br>
                Tanggal, ....................................
            </div>
        </td>
    </tr>
</table>

<div class="page-break"></div>

<!-- PAGE 3: CAPAIAN SKP -->
<div class="logo-box">
    @if($imageSrc)
        <img src="{{ $imageSrc }}" style="width: 250px;">
    @endif
</div><div class="title-box" style="margin-top: 15px;">PENILAIAN CAPAIAN SASARAN KINERJA<br>PEGAWAI UNIVERSITAS SUMATERA SELATAN</div>
<div style="text-align: center; margin-bottom: 10px;">Jangka Waktu penilaian {{ \Carbon\Carbon::parse($p2kp->period_start)->locale('id')->isoFormat('D MMMM Y') }} s.d {{ \Carbon\Carbon::parse($p2kp->period_end)->locale('id')->isoFormat('D MMMM Y') }}</div>

<table class="bordered" style="font-size: 8pt;">
    <thead>
        <tr class="text-center font-bold">
            <th rowspan="2" style="width: 3%;">No.</th>
            <th rowspan="2" style="width: 30%;">1. Kegiatan Tugas Jabatan</th>
            <th rowspan="2" style="width: 3%;">AK</th>
            <th colspan="4">TARGET</th>
            <th rowspan="2" style="width: 3%;">AK</th>
            <th colspan="4">Realisasi</th>
            <th rowspan="2" style="width: 8%;">PERHITUNGAN</th>
            <th rowspan="2" style="width: 8%;">NILAI CAPAIAN SKP</th>
        </tr>
        <tr class="text-center font-bold">
            <th style="font-size: 7pt;">Kuantitas/ Output</th><th style="font-size: 7pt;">Kualitas/ Mutu</th><th style="font-size: 7pt;">Waktu</th><th style="font-size: 7pt;">Biaya</th>
            <th style="font-size: 7pt;">Kuantitas/ Output</th><th style="font-size: 7pt;">Kualitas/ Mutu</th><th style="font-size: 7pt;">Waktu</th><th style="font-size: 7pt;">Biaya</th>
        </tr>
    </thead>
    <tbody>
        @php 
            $totalScore = 0; 
            $totalItems = count($p2kp->items);
            $globalIndex = 1;
            
            if (!function_exists('renderItemsAll')) {
                function renderItemsAll($items, &$globalIndex, &$totalScore) {
                    foreach($items as $item) {
                        $real_qty = $item->real_qty ?? 0;
                        $real_quality = $item->real_quality ?? 0;
                        $real_time = $item->real_time ?? 0;
                        
                        if ($real_qty == 0) {
                            $penghitungan = 0;
                            $nilai_capaian = 0;
                        } else {
                            $score_qty = $item->target_qty > 0 ? ($real_qty / $item->target_qty) * 100 : 0;
                            $score_quality = $item->target_quality > 0 ? ($real_quality / $item->target_quality) * 100 : 0;
                            $score_time = $item->target_time > 0 ? ((1.76 * $item->target_time) - $real_time) / $item->target_time * 100 : 0;
                            $penghitungan = $score_qty + $score_quality + $score_time;
                            $nilai_capaian = $penghitungan / 3;
                        }
                        
                        $totalScore += $nilai_capaian;
                        
                        // Output the credit_score properly formatted or blank if 0
                        $cs_val = $item->credit_score > 0 ? rtrim(rtrim(number_format($item->credit_score, 3, ',', '.'), '0'), ',') : '0';
                        
                        echo "<tr>
                            <td class='text-center font-bold'>{$globalIndex}</td>
                            <td>{$item->activity}</td>
                            <td class='text-center'>{$cs_val}</td>
                            <td class='text-center'>{$item->target_qty}/{$item->target_output}</td>
                            <td class='text-center'>{$item->target_quality}</td>
                            <td class='text-center'>{$item->target_time} {$item->target_time_unit}</td>
                            <td class='text-center'>-</td>
                            <td class='text-center'>{$cs_val}</td>
                            <td class='text-center'>{$real_qty}/{$item->target_output}</td>
                            <td class='text-center'>{$real_quality}</td>
                            <td class='text-center'>{$real_time} {$item->target_time_unit}</td>
                            <td class='text-center'>-</td>
                            <td class='text-center'>" . number_format($penghitungan, 0) . "</td>
                            <td class='text-center'>" . number_format($nilai_capaian, 0) . "</td>
                        </tr>";
                        $globalIndex++;
                    }
                }
            }
        @endphp

        {{-- 1. Kegiatan Tugas Jabatan --}}
        @php 
            $utamaItems = $p2kp->items->where('type', 'utama');
            if($utamaItems->count() > 0) {
                renderItemsAll($utamaItems, $globalIndex, $totalScore); 
            } else {
                echo "<tr><td colspan='14' class='text-center'>-</td></tr>";
            }
        @endphp

        {{-- II. Tugas Tambahan dan Kreatifitas --}}
        <tr class="font-bold">
            <td></td>
            <td colspan="13">II. TUGAS TAMBAHAN DAN KREATIFITAS/UNSUR PENUNJANG</td>
        </tr>
        <tr>
            <td class="text-center font-bold">1</td>
            <td colspan="13">(TUGAS TAMBAHAN)</td>
        </tr>
        @php 
            $tambahanItems = $p2kp->items->where('type', 'tambahan');
            $globalIndex = 1; // Reset index for tambahan? Usually it might continue, but let's reset or skip index for this. Let's just use empty or continue. The image shows no items under it. If there are, let's render them.
            if($tambahanItems->count() > 0) {
                renderItemsAll($tambahanItems, $globalIndex, $totalScore); 
            }
        @endphp
        <tr>
            <td class="text-center font-bold">2</td>
            <td colspan="13">(KREATIFITAS)</td>
        </tr>
        @php 
            $kreatifitasItems = $p2kp->items->whereIn('type', ['kreatifitas', 'penunjang']);
            $globalIndex = 1; // Reset index
            if($kreatifitasItems->count() > 0) {
                renderItemsAll($kreatifitasItems, $globalIndex, $totalScore); 
            }
        @endphp

        @php $avgScore = $totalItems > 0 ? $totalScore / $totalItems : 0; @endphp
        <tr class="font-bold">
            <td colspan="13" class="text-right" style="padding-right: 15px;">Nilai Capaian SKP</td>
            <td class="text-center">
                {{ getGradeLabel($avgScore) }}<br>
                ({{ number_format($avgScore, 2) }})
            </td>
        </tr>
    </tbody>
</table>

</body>
</html>
