<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: sans-serif;
            width: 241.89px;
        }

        /* ===================== HALAMAN DEPAN ===================== */
        .kartu-depan {
            width: 241.89px;
            height: 153.07px;
            border: 1.5px solid #cccccc;
            border-radius: 6px;
            overflow: hidden;
            background: #ffffff;
            page-break-after: always;
        }

        .depan-header {
            background-color: #cc785c;
            border-bottom: 2px solid #cc785c;
            padding: 6px 8px;
        }

        .depan-header table { width: 100%; }

        .header-teks { vertical-align: middle; padding-left: 5px; }

        .header-teks .label {
            font-size: 7px;
            color: #ffffff;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .header-teks .nama-perpus {
            font-size: 10px;
            font-weight: bold;
            color: rgb(255, 255, 255);
            letter-spacing: 0.3px;
        }

        .depan-body { padding: 8px 10px 4px 10px; }

        .anggota-nama {
            font-size: 15px;
            font-weight: bold;
            color: #141413;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
        }

        .depan-body .row-info { margin-bottom: 3px; }

        .depan-body .info-label {
            font-size: 8px;
            font-weight: bold;
            color: #3d3d3a;
        }

        .depan-body .info-value {
            font-size: 8px;
            color: #3d3d3a;
        }

        .depan-footer {
            padding: 2px 10px 4px 10px;
            border-top: 1px solid #eeeeee;
        }

        .depan-footer table { width: 100%; }

        .footer-identitas { vertical-align: bottom; }

        .footer-identitas .id-label {
            font-size: 7.5px;
            font-weight: bold;
            color: #3d3d3a;
        }

        .footer-identitas .id-value {
            font-size: 8px;
            color: #3d3d3a;
        }

        .footer-separator {
            width: 1px;
            background: #cccccc;
            vertical-align: bottom;
            padding: 0 4px;
        }

        .footer-separator-line {
            border-left: 1px solid #aaaaaa;
            height: 20px;
            display: inline-block;
        }

        .footer-telp { vertical-align: bottom; }

        .footer-telp .telp-label {
            font-size: 7.5px;
            font-weight: bold;
            color: #3d3d3a;
        }

        .footer-telp .telp-value {
            font-size: 8px;
            color: #3d3d3a;
        }

        .footer-barcode {
            vertical-align: bottom;
            text-align: right;
            width: 70px;
        }

        .footer-barcode .exp {
            font-size: 7px;
            color: #555;
            margin-bottom: 1px;
        }

        .footer-barcode img { width: 65px; height: 22px; }

        /* ===================== HALAMAN BELAKANG ===================== */
        .kartu-belakang {
            width: 241.89px;
            height: 153.07px;
            border: 1.5px solid #cccccc;
            border-radius: 6px;
            overflow: hidden;
            background: #ffffff;
        }

        .belakang-body { 
            padding: 6px 12px 8px 12px; 
        }

        .belakang-header {
            background-color: #cc785c;
            border-bottom: 2px solid #cc785c;
            padding: 3px 8px;
        }

        .belakang-header table { width: 100%; }

        .aturan-judul {
            font-size: 10px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 5px;
            border-bottom: 1px solid #cc785c;
            padding-bottom: 3px;
            vertical-align: middle;
            padding-left: 5px;
        }

        .aturan-list { padding-left: 10px; }

        .aturan-list li {
            font-size: 7.5px;
            color: #3d3d3a;
            margin-bottom: 2.5px;
            line-height: 1.3;
        }

        .belakang-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 5px 12px;
            border-top: 1px solid #eeeeee;
            background: #f9f9f9;
        }

        .belakang-footer table { width: 100%; }

        .footer-sekolah { 
            vertical-align: bottom;
        }

        .footer-sekolah .sekolah-nama {
            font-size: 7.5px;
            font-weight: bold;
            color: #141413;
        }

        .footer-sekolah .sekolah-alamat {
            font-size: 6.5px;
            color: #555555;
        }

        .belakang-wrapper {
            position: relative;
            height: 153.07px;
        }
    </style>
</head>
<body>

    {{-- =================== HALAMAN DEPAN =================== --}}
    <div class="kartu-depan">

        <div class="depan-header">
            <table>
                <tr>
                    <td class="header-teks">
                        <div class="label">Kartu Anggota Perpustakaan</div>
                        <div class="nama-perpus">Sasana Ilmu SMAN 1 Kretek</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="depan-body">
            <div class="anggota-nama">{{ $anggota->nama }}</div>
            <div class="row-info">
                <div class="info-label">Alamat</div>
                <div class="info-value">{{ \Illuminate\Support\Str::limit($anggota->alamat, 60) }}</div>
            </div>
        </div>

        <div class="depan-footer">
            <table>
                <tr>
                    <td class="footer-identitas">
                        <div class="id-label">Nomor Identitas</div>
                        <div class="id-value">{{ str_pad($anggota->id, 10, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td class="footer-separator">
                        <span class="footer-separator-line"></span>
                    </td>
                    <td class="footer-telp">
                        <div class="telp-label">Nomor Telepon</div>
                        <div class="telp-value">{{ $anggota->no_hp }}</div>
                    </td>
                    <td class="footer-barcode">
                        <div class="exp">Exp. {{ now()->addYears(3)->format('Y-m-d') }}</div>
                        <img src="{{ $barcode }}" alt="barcode">
                    </td>
                </tr>
            </table>
        </div>

    </div>

    {{-- =================== HALAMAN BELAKANG =================== --}}
    <div class="kartu-belakang">
        <div class="belakang-wrapper">

            <div class="belakang-header">
                <table>
                    <tr>
                        <td class="aturan-judul">
                            Aturan Perpustakaan
                        </td>
                    </tr>
                </table>
            </div>

            <div class="belakang-body">
                <ul class="aturan-list">
                    <li>Kartu Perpustakaan Sasana Ilmu SMAN 1 Kretek berlaku 3 tahun.</li>
                    <li>Peminjaman buku maksimal 2 judul/eksemplar.</li>
                    <li>Lama peminjaman 7 hari.</li>
                    <li>Denda keterlambatan pengembalian Rp. 2000,-/hari.</li>
                    <li>Kartu hilang mengganti Rp. 10.000,-</li>
                </ul>
            </div>

            <div class="belakang-footer">
                <table>
                    <tr>
                        <td class="footer-sekolah">
                            <div class="sekolah-nama">SASANA ILMU SMAN 1 KRETEK</div>
                            <div class="sekolah-alamat">Genting, Tirtomulyo, Kretek, Bantul. 55772</div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

</body>
</html>