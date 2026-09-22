<?php
// laporan_bulanan.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');
$bulan = mysqli_real_escape_string($koneksi, $bulan);

$sql = "SELECT t.no_transaksi, t.tanggal, t.total_bayar,
                u.nama_lengkap AS nama_kasir
        FROM tbl_transaksi t
        JOIN tbl_user u ON u.id_user = t.id_kasir
        WHERE DATE_FORMAT(t.tanggal, '%Y-%m') = '$bulan'
        ORDER BY t.tanggal ASC";

$hasil = mysqli_query($koneksi, $sql);

$total_bulanan = 0;
$jumlah_transaksi = 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Bulanan - Warung ABC</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f4f7fb;
            color: #1f2937;
            min-height: 100vh;
            padding: 35px 20px;
        }

        .container {
            width: 100%;
            max-width: 1100px;
            margin: auto;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            background: linear-gradient(135deg, #2563eb, #1e3a8a);
            color: white;
            padding: 28px 30px;
            border-radius: 16px;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.18);
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 7px;
        }

        .header p {
            color: #dbeafe;
            font-size: 14px;
        }

        /* =========================
           FILTER
        ========================= */

        .filter-card {
            background: white;
            padding: 22px;
            border-radius: 14px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .filter-card label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            color: #374151;
            margin-bottom: 8px;
        }

        .filter-form {
            display: flex;
            align-items: end;
            gap: 12px;
        }

        .input-group {
            flex: 1;
        }

        .input-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-tampilkan {
            border: none;
            background: #2563eb;
            color: white;
            padding: 12px 20px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-tampilkan:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        /* =========================
           STATISTIK
        ========================= */

        .summary {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            margin-bottom: 20px;
        }

        .summary-card {
            background: white;
            padding: 22px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .summary-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .icon-blue {
            background: #dbeafe;
        }

        .icon-green {
            background: #dcfce7;
        }

        .summary-info small {
            display: block;
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .summary-info strong {
            font-size: 21px;
            color: #111827;
        }

        /* =========================
           TABLE
        ========================= */

        .table-card {
            background: white;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .table-header h2 {
            font-size: 18px;
            color: #111827;
        }

        .table-header span {
            font-size: 12px;
            color: #6b7280;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        thead th {
            background: #2563eb;
            color: white;
            padding: 14px 12px;
            text-align: left;
            font-size: 13px;
        }

        thead th:first-child {
            border-radius: 8px 0 0 8px;
        }

        thead th:last-child {
            border-radius: 0 8px 8px 0;
        }

        tbody td {
            padding: 14px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        tbody tr {
            transition: 0.2s;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .nomor {
            font-weight: bold;
            color: #2563eb;
        }

        .tanggal {
            color: #6b7280;
        }

        .kasir {
            font-weight: 500;
        }

        .total {
            text-align: right;
            font-weight: bold;
            color: #16a34a;
        }

        /* =========================
           FOOTER BUTTON
        ========================= */

        .footer {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-kembali {
            display: inline-block;
            text-decoration: none;
            background: #6b7280;
            color: white;
            padding: 11px 18px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-kembali:hover {
            background: #4b5563;
            transform: translateY(-1px);
        }

        /* =========================
           DATA KOSONG
        ========================= */

        .empty {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
        }

        .empty-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 650px) {

            body {
                padding: 20px 10px;
            }

            .header {
                padding: 22px;
            }

            .header h1 {
                font-size: 23px;
            }

            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-tampilkan {
                width: 100%;
            }

            .summary {
                grid-template-columns: 1fr;
            }

            .table-card {
                padding: 18px;
            }

            .footer {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .btn-kembali {
                text-align: center;
            }

        }

        /* =========================
           PRINT
        ========================= */

        @media print {

            body {
                background: white;
                padding: 0;
            }

            .filter-card,
            .btn-kembali {
                display: none;
            }

            .container {
                max-width: 100%;
            }

            .header {
                box-shadow: none;
            }

            .summary-card,
            .table-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <!-- HEADER -->

    <div class="header">

        <h1>
            📊 Laporan Transaksi Bulanan
        </h1>

        <p>
            Laporan transaksi dan pendapatan Warung ABC
        </p>

    </div>


    <!-- FILTER BULAN -->

    <div class="filter-card">

        <form method="GET" class="filter-form">

            <div class="input-group">

                <label>
                    Pilih Bulan
                </label>

                <input
                    type="month"
                    name="bulan"
                    value="<?php echo htmlspecialchars($bulan); ?>"
                >

            </div>

            <button
                type="submit"
                class="btn-tampilkan">

                🔍 Tampilkan

            </button>

        </form>

    </div>


    <!-- SUMMARY -->

    <div class="summary">

        <div class="summary-card">

            <div class="summary-icon icon-blue">
                🧾
            </div>

            <div class="summary-info">

                <small>
                    Jumlah Transaksi
                </small>

                <strong>
                    <?php echo $jumlah_transaksi; ?>
                </strong>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon icon-green">
                💰
            </div>

            <div class="summary-info">

                <small>
                    Total Pendapatan
                </small>

                <strong>
                    Rp <?php echo number_format(
                        $total_bulanan,
                        0,
                        ',',
                        '.'
                    ); ?>
                </strong>

            </div>

        </div>

    </div>


    <!-- TABEL -->

    <div class="table-card">

        <div class="table-header">

            <h2>
                📋 Detail Transaksi
            </h2>

            <span>
                Data transaksi berdasarkan bulan yang dipilih
            </span>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>No. Transaksi</th>

                        <th>Tanggal</th>

                        <th>Kasir</th>

                        <th>Total Bayar</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if (mysqli_num_rows($hasil) > 0) { ?>

                        <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>

                            <?php

                            $total_bulanan += 0;

                            $jumlah_transaksi++;

                            ?>

                            <tr>

                                <td class="nomor">

                                    <?php
                                    echo htmlspecialchars(
                                        $row['no_transaksi']
                                    );
                                    ?>

                                </td>

                                <td class="tanggal">

                                    <?php
                                    echo htmlspecialchars(
                                        $row['tanggal']
                                    );
                                    ?>

                                </td>

                                <td class="kasir">

                                    <?php
                                    echo htmlspecialchars(
                                        $row['nama_kasir']
                                    );
                                    ?>

                                </td>

                                <td class="total">

                                    Rp
                                    <?php
                                    echo number_format(
                                        $row['total_bayar'],
                                        0,
                                        ',',
                                        '.'
                                    );
                                    ?>

                                </td>

                            </tr>

                        <?php } ?>

                    <?php } else { ?>

                        <tr>

                            <td colspan="4">

                                <div class="empty">

                                    <div class="empty-icon">
                                        📭
                                    </div>

                                    <strong>
                                        Tidak ada transaksi
                                    </strong>

                                    <p>
                                        Belum ada transaksi pada bulan ini.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>


        <!-- FOOTER -->

        <div class="footer">

            <strong>
                Total Pendapatan:
                Rp <?php echo number_format(
                    $total_bulanan,
                    0,
                    ',',
                    '.'
                ); ?>
            </strong>

            <a
                href="dashboard.php"
                class="btn-kembali">

                ← Kembali ke Dashboard

            </a>

        </div>

    </div>

</div>

</body>

</html>