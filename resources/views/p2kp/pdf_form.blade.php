<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Formulir P2KP - {{ $p2kp->employee->name }}</title>
    <style>
        @page { size: a4 portrait; margin: 1cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 10pt; line-height: 1.1; margin: 0; padding: 0; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .underline { text-decoration: underline; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.bordered th, table.bordered td { border: 1px solid black; padding: 4px; }
        
        .logo-box { text-align: center; margin-bottom: 10px; }
        .title-box { text-align: center; font-weight: bold; font-size: 11pt; margin-bottom: 15px; }
    </style>
</head>
<body>

@php
    $imageSrc = '';
    if(file_exists(public_path('Logo Universitas Sumatera Selatan.png'))) {
        $imageData = base64_encode(file_get_contents(public_path('Logo Universitas Sumatera Selatan.png')));
        $imageSrc = 'data:image/png;base64,' . $imageData;
    }
@endphp

<div class="logo-box">
    @if($imageSrc)
        <img src="{{ $imageSrc }}" style="width: 250px;">
    @endif
</div>
<div class="title-box" style="margin-top: 15px;">
    FORMULIR SASARAN KERJA PEGAWAI<br>
    UNIVERSITAS SUMATERA SELATAN
</div>

<table class="bordered" style="font-size: 9pt;">
    <tr>
        <th style="width: 5%;">NO</th>
        <th colspan="2" style="width: 45%;">I. PEJABAT PENILAI</th>
        <th style="width: 5%;">NO</th>
        <th colspan="5" style="width: 45%;">II. PEGAWAI YANG DINILAI</th>
    </tr>
    <tr>
        <td class="text-center">1</td><td style="width: 15%;">Nama</td><td>{{ $p2kp->ratingOfficial->name }}</td>
        <td class="text-center">1</td><td style="width: 15%;">Nama</td><td colspan="4">{{ $p2kp->employee->name }}</td>
    </tr>
    <tr>
        <td class="text-center">2</td><td>NUPTK</td><td>{{ $p2kp->ratingOfficial->nuptk }}</td>
        <td class="text-center">2</td><td>NUPTK</td><td colspan="4">{{ $p2kp->employee->nuptk }}</td>
    </tr>
    <tr>
        <td class="text-center">3</td><td>Pangkat/Gol.</td><td>{{ $p2kp->ratingOfficial->rank }}</td>
        <td class="text-center">3</td><td>Pangkat/Gol.</td><td colspan="4">{{ $p2kp->employee->rank }}</td>
    </tr>
    <tr>
        <td class="text-center">4</td><td>Jabatan</td><td>{{ $p2kp->ratingOfficial->position }}</td>
        <td class="text-center">4</td><td>Jabatan</td><td colspan="4">{{ $p2kp->employee->position }}</td>
    </tr>
    <tr>
        <td class="text-center">5</td><td>Unit Organisasi</td><td>{{ $p2kp->ratingOfficial->unit }}</td>
        <td class="text-center">5</td><td>Unit Organisasi</td><td colspan="4">{{ $p2kp->employee->unit }}</td>
    </tr>
    <tr>
        <td class="text-center">6</td><td>Unit Kerja</td><td>{{ $p2kp->ratingOfficial->work_unit }}</td>
        <td class="text-center">6</td><td>Unit Kerja</td><td colspan="4">{{ $p2kp->employee->work_unit }}</td>
    </tr>
</table>

<table class="bordered" style="font-size: 9pt;">
    <thead>
        <tr class="text-center font-bold">
            <th rowspan="2" style="width: 5%;">NO</th>
            <th rowspan="2" style="width: 40%;">III. KEGIATAN TUGAS JABATAN</th>
            <th rowspan="2" style="width: 7%;">AK</th>
            <th colspan="4">TARGET</th>
        </tr>
        <tr class="text-center font-bold">
            <th>KUANT</th><th>KUAL</th><th>WAKTU</th><th>BIAYA</th>
        </tr>
    </thead>
    <tbody>
        @php
            $pendidikanItems = $p2kp->items->where('type', 'utama');
            $penelitianItems = $p2kp->items->where('type', 'tambahan');
            $pengabdianItems = $p2kp->items->where('type', 'kreatifitas');
            $penunjangItems = $p2kp->items->where('type', 'penunjang');
            $globalIndex = 1;
        @endphp

        {{-- 1. Unsur Pelaksanaan Pendidikan --}}
        <tr class="font-bold bg-slate-50">
            <td class="text-center">I.</td>
            <td colspan="6">UNSUR PELAKSANAAN PENDIDIKAN</td>
        </tr>
        @foreach($pendidikanItems as $item)
        <tr>
            <td class="text-center">{{ $globalIndex++ }}</td>
            <td>{{ $item->activity }}</td>
            <td class="text-center">-</td>
            <td class="text-center">{{ $item->target_qty }} {{ $item->target_output }}</td>
            <td class="text-center">{{ $item->target_quality }}</td>
            <td class="text-center">{{ $item->target_time }} {{ $item->target_time_unit }}</td>
            <td class="text-center">-</td>
        </tr>
        @endforeach

        {{-- 2. Unsur Pelaksanaan Penelitian --}}
        <tr class="font-bold bg-slate-50">
            <td class="text-center">II.</td>
            <td colspan="6">UNSUR PELAKSANAAN PENELITIAN</td>
        </tr>
        @foreach($penelitianItems as $item)
        <tr>
            <td class="text-center">{{ $globalIndex++ }}</td>
            <td>{{ $item->activity }}</td>
            <td class="text-center">-</td>
            <td class="text-center">{{ $item->target_qty }} {{ $item->target_output }}</td>
            <td class="text-center">{{ $item->target_quality }}</td>
            <td class="text-center">{{ $item->target_time }} {{ $item->target_time_unit }}</td>
            <td class="text-center">-</td>
        </tr>
        @endforeach

        {{-- 3. Unsur Pelaksanaan Pengabdian --}}
        <tr class="font-bold bg-slate-50">
            <td class="text-center">III.</td>
            <td colspan="6">UNSUR PELAKSANAAN PENGABDIAN KEPADA MASYARAKAT</td>
        </tr>
        @foreach($pengabdianItems as $item)
        <tr>
            <td class="text-center">{{ $globalIndex++ }}</td>
            <td>{{ $item->activity }}</td>
            <td class="text-center">-</td>
            <td class="text-center">{{ $item->target_qty }} {{ $item->target_output }}</td>
            <td class="text-center">{{ $item->target_quality }}</td>
            <td class="text-center">{{ $item->target_time }} {{ $item->target_time_unit }}</td>
            <td class="text-center">-</td>
        </tr>
        @endforeach

        {{-- 4. Unsur Pelaksanaan Penunjang --}}
        <tr class="font-bold bg-slate-50">
            <td class="text-center">IV.</td>
            <td colspan="6">UNSUR PELAKSANAAN PENUNJANG TRIDHARMA PERGURUAN TINGGI</td>
        </tr>
        @foreach($penunjangItems as $item)
        <tr>
            <td class="text-center">{{ $globalIndex++ }}</td>
            <td>{{ $item->activity }}</td>
            <td class="text-center">-</td>
            <td class="text-center">{{ $item->target_qty }} {{ $item->target_output }}</td>
            <td class="text-center">{{ $item->target_quality }}</td>
            <td class="text-center">{{ $item->target_time }} {{ $item->target_time_unit }}</td>
            <td class="text-center">-</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 20px;">
    <table class="no-border">
        <tr>
            <td style="width: 50%;" class="text-center">
                Pejabat Penilai,<br><br><br><br><br><br><br><br>
                <span class="font-bold underline">{{ $p2kp->ratingOfficial->name }}</span><br>
                NUPTK. {{ $p2kp->ratingOfficial->nuptk }}
            </td>
            <td style="width: 50%;" class="text-center">
                Palembang, {{ \Carbon\Carbon::parse($p2kp->date_signed)->locale('id')->isoFormat('D MMMM Y') }}<br>
                Pegawai Yang Dinilai,<br><br><br><br><br><br><br><br>
                <span class="font-bold underline">{{ $p2kp->employee->name }}</span><br>
                NUPTK. {{ $p2kp->employee->nuptk }}
            </td>
        </tr>
    </table>
</div>

</body>
</html>
