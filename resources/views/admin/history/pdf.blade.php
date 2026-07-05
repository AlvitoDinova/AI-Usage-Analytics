<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Evaluasi TOPSIS — {{ $project->nama_proyek }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        
        /* Header Logo Section */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        
        .logo-text {
            font-size: 22px;
            font-weight: bold;
            color: #1e293b;
            margin: 0;
        }
        
        .logo-text span {
            color: #2563eb;
        }
        
        .doc-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: right;
            color: #64748b;
            margin: 0;
            letter-spacing: 0.5px;
        }
        
        .subtitle {
            font-size: 8px;
            color: #94a3b8;
            text-align: right;
            margin: 2px 0 0 0;
        }

        /* Project Info & Weights */
        .section-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #1e293b;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
            margin-bottom: 10px;
            margin-top: 15px;
            letter-spacing: 0.5px;
        }
        
        .info-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        
        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        
        .info-label {
            width: 120px;
            color: #64748b;
            font-weight: bold;
        }
        
        .info-value {
            color: #0f172a;
        }

        /* Weights Grid Table */
        .weights-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        
        .weights-table th, .weights-table td {
            border: 1px solid #e2e8f0;
            padding: 5px 8px;
            text-align: left;
        }
        
        .weights-table th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: bold;
            font-size: 10px;
        }

        /* Conclusion Card */
        .conclusion-box {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 20px;
        }
        
        .conclusion-header {
            font-weight: bold;
            color: #15803d;
            font-size: 11px;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .conclusion-text {
            color: #166534;
            margin: 0;
            font-size: 10.5px;
            line-height: 1.4;
        }

        /* Ranks Table */
        .ranks-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .ranks-table th, .ranks-table td {
            padding: 6px 8px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .ranks-table th {
            background-color: #2563eb;
            color: #ffffff;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }
        
        .ranks-table tr.rank-1 {
            background-color: #f0fdf4;
            font-weight: bold;
        }
        
        .ranks-table tr:nth-child(even) {
            background-color: #fafafa;
        }
        
        .ranks-table tr.rank-1:nth-child(even) {
            background-color: #f0fdf4;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 5px;
            font-weight: bold;
            border-radius: 3px;
            font-size: 9px;
            text-align: center;
        }
        
        .badge-rank1 {
            background-color: #fef08a;
            color: #854d0e;
            border: 1px solid #fef08a;
        }
        
        .badge-rank2 {
            background-color: #e2e8f0;
            color: #334155;
        }
        
        .badge-rank3 {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }

        .footer-note {
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
            margin-top: 30px;
            border-top: 1px dashed #cbd5e1;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <table class="header-table" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <h1 class="logo-text">A<span>Insight</span></h1>
            </td>
            <td>
                <h2 class="doc-title">Laporan Rekomendasi TOPSIS</h2>
                <p class="subtitle">Notch Creative Agency — Tangerang Selatan</p>
            </td>
        </tr>
    </table>

    <!-- Project Information -->
    <div class="section-title">Informasi Proyek & Evaluasi</div>
    <table class="info-table" cellpadding="0" cellspacing="0">
        <tr>
            <td class="info-label">Nama Proyek:</td>
            <td class="info-value"><strong>{{ $project->nama_proyek }}</strong></td>
            <td class="info-label" style="padding-left: 20px;">Jenis Proyek:</td>
            <td class="info-value">{{ $project->projectType->nama_proyek }}</td>
        </tr>
        <tr>
            <td class="info-label">Client:</td>
            <td class="info-value">{{ $project->client }}</td>
            <td class="info-label" style="padding-left: 20px;">Tanggal Evaluasi:</td>
            <td class="info-value">{{ \Carbon\Carbon::parse($assessment->tanggal_penilaian)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="info-label">Deskripsi Proyek:</td>
            <td class="info-value" colspan="3">{{ $project->deskripsi ?? 'Tidak ada deskripsi proyek.' }}</td>
        </tr>
    </table>

    <!-- Conclusion Section -->
    <div class="conclusion-box">
        <div class="conclusion-header">Kesimpulan Hasil Evaluasi</div>
        <p class="conclusion-text">{{ $conclusion }}</p>
    </div>

    <!-- Criteria Weights Section -->
    <div class="section-title">Parameter Bobot Kriteria yang Digunakan</div>
    <table class="weights-table">
        <thead>
            <tr>
                @foreach($assessment->details as $det)
                    <th class="text-center">{{ $det->criterion->kode }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach($assessment->details as $det)
                    <td class="text-center"><strong>{{ $det->bobot }}</strong></td>
                @endforeach
            </tr>
        </tbody>
    </table>

    <!-- Ranks Table Section -->
    <div class="section-title">Peringkat Alternatif AI Tools (Hasil TOPSIS)</div>
    <table class="ranks-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">Rank</th>
                <th style="width: 130px;">Alternatif AI Tool</th>
                <th style="width: 100px;">Kategori</th>
                <th>Fungsionalitas / Deskripsi</th>
                <th class="text-right" style="width: 100px;">Preferensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $res)
                <tr class="{{ $res->ranking == 1 ? 'rank-1' : '' }}">
                    <td class="text-center">
                        @if($res->ranking == 1)
                            <span class="badge badge-rank1">1</span>
                        @elseif($res->ranking == 2)
                            <span class="badge badge-rank2">2</span>
                        @elseif($res->ranking == 3)
                            <span class="badge badge-rank3">3</span>
                        @else
                            {{ $res->ranking }}
                        @endif
                    </td>
                    <td><strong>{{ $res->aiTool->nama_ai }}</strong></td>
                    <td>{{ $res->aiTool->kategori }}</td>
                    <td style="color: #475569; font-size: 10px;">{{ $res->aiTool->deskripsi }}</td>
                    <td class="text-right" style="font-family: Courier, monospace; font-weight: bold; color: #2563eb;">
                        {{ number_format($res->nilai_preferensi, 6) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer Note -->
    <div class="footer-note">
        Laporan ini dihasilkan secara otomatis oleh Sistem Pendukung Keputusan AInsight menggunakan Metode TOPSIS.<br>
        Notch Creative Agency &copy; {{ date('Y') }}. Dokumen ini sah dan digunakan sebagai rekomendasi pemilihan perangkat AI.
    </div>

</body>
</html>
