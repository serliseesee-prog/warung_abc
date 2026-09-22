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

        /* =========================
           RESET
        ========================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }


        /* =========================
           BODY
        ========================= */

        body {
            background: #f4f7fb;
            color: #1f2937;
            min-height: 100vh;
            padding: 35px 20px;
        }


        /* =========================
           CONTAINER
        ========================= */

        .container {
            width: 100%;
            max-width: 1100px;
            margin: auto;
        }


        /* =========================
           HEADER
        ========================= */

        .header {
            background: linear-gradient(
                135deg,
                #2563eb,
                #1e3a8a
            );

            color: white;

            padding: 30px;

            border-radius: 18px;

            margin-bottom: 25px;

            box-shadow:
                0 10px 30px rgba(30, 58, 138, 0.18);
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 8px;
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

            border-radius: 15px;

            margin-bottom: 20px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .filter-card form {
            display: flex;

            align-items: end;

            gap: 12px;
        }

        .filter-group {
            flex: 1;
        }

        .filter-group label {
            display: block;

            font-size: 13px;

            font-weight: bold;

            color: #374151;

            margin-bottom: 8px;
        }

        .filter-group input {
            width: 100%;

            padding: 12px 14px;

            border: 1px solid #d1d5db;

            border-radius: 9px;

            font-size: 14px;

            outline: none;

            transition: 0.3s;
        }

        .filter-group input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-tampilkan {
            border: none;

            background: #2563eb;

            color: white;

            padding: 12px 22px;

            border-radius: 9px;

            font-size: 14px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;
        }

        .btn-tampilkan:hover {
            background: #1d4ed8;

            transform: translateY(-2px);
        }


        /* =========================
           STATISTIK
        ========================= */

        .stats {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 18px;

            margin-bottom: 20px;
        }

        .stat-card {
            background: white;

            padding: 22px;

            border-radius: 15px;

            display: flex;

            align-items: center;

            gap: 15px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, 0.05);

            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-4px);

            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .stat-icon {
            width: 52px;

            height: 52px;

            border-radius: 13px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 24px;
        }

        .blue {
            background: #dbeafe;
        }

        .green {
            background: #dcfce7;
        }

        .stat-info small {
            display: block;

            color: #6b7280;

            font-size: 12px;

            margin-bottom: 5px;
        }

        .stat-info strong {
            font-size: 22px;

            color: #111827;
        }


        /* =========================
           TABLE CARD
        ========================= */

        .table-card {
            background: white;

            padding: 25px;

            border-radius: 15px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .table-title {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 20px;
        }

        .table-title h2 {
            font-size: 19px;

            color: #111827;
        }

        .table-title span {
            color: #6b7280;

            font-size: 12px;
        }


        /* =========================
           TABLE
        ========================= */

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

        tbody td:first-child {
            font-weight: bold;

            color: #2563eb;
        }

        .tanggal {
            color: #6b7280;
        }

        .kasir {
            font-weight: 500;
        }

        .harga {
            text-align: right;

            color: #16a34a;

            font-weight: bold;
        }


        /* =========================
           TOTAL
        ========================= */

        .summary {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-top: 22px;

            padding-top: 18px;

            border-top: 1px solid #e5e7eb;
        }

        .jumlah {
            color: #4b5563;

            font-size: 14px;
        }

        .pendapatan {
            color: #16a34a;

            font-size: 17px;

            font-weight: bold;
        }


        /* =========================
           BUTTON KEMBALI
        ========================= */

        .footer {
            margin-top: 20px;
        }

        .btn-kembali {
            display: inline-block;

            padding: 11px 18px;

            background: #6b7280;

            color: white;

            text-decoration: none;

            border-radius: 9px;

            font-size: 13px;

            font-weight: bold;

            transition: 0.3s;
        }

        .btn-kembali:hover {
            background: #4b5563;

            transform: translateY(-2px);
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 700px) {

            body {
                padding: 20px 10px;
            }

            .header {
                padding: 22px;
            }

            .header h1 {
                font-size: 23px;
            }

            .filter-card form {
                flex-direction: column;

                align-items: stretch;
            }

            .btn-tampilkan {
                width: 100%;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .table-card {
                padding: 18px;
            }

            .table-title {
                display: block;
            }

            .table-title span {
                display: block;

                margin-top: 5px;
            }

            .summary {
                display: block;
            }

            .pendapatan {
                display: block;

                margin-top: 10px;
            }

            .btn-kembali {
                width: 100%;

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

            .header {
                box-shadow: none;
            }

            .table-card,
            .stat-card {
                box-shadow: none;

                border: 1px solid #ddd;
            }

        }

    </style>

</head>

<body>


<div class="container">


    <!-- =========================
         HEADER
    ========================= -->

    <div class="header">

        <h1>
            📊 Laporan Transaksi Bulanan
        </h1>

        <p>
            Rekap transaksi dan pendapatan Warung ABC
        </p>

    </div>


    <!-- =========================
         FILTER BULAN
    ========================= -->

    <div class="filter-card">

        <form method="GET">

            <div class="filter-group">

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


    <!-- =========================
         STATISTIK
    ========================= -->

    <div class="stats">


        <div class="stat-card">

            <div class="stat-icon blue">
                🧾
            </div>

            <div class="stat-info">

                <small>
                    Jumlah Transaksi
                </small>

                <strong>
                    <?php echo $jumlah_transaksi; ?>
                </strong>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon green">
                💰
            </div>

            <div class="stat-info">

                <small>
                    Total Pendapatan
                </small>

                <strong>
                    Rp
                    <?php
                    echo number_format(
                        $total_bulanan,
                        0,
                        ',',
                        '.'
                    );
                    ?>
                </strong>

            </div>

        </div>

    </div>


    <!-- =========================
         TABLE
    ========================= -->

    <div class="table-card">


        <div class="table-title">

            <h2>
                📋 Detail Transaksi
            </h2>

            <span>
                Laporan bulan <?php echo htmlspecialchars($bulan); ?>
            </span>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>
                            No. Transaksi
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Kasir
                        </th>

                        <th>
                            Total Bayar
                        </th>

                    </tr>

                </thead>


                <tbody>


                    <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>


                        <?php

                        $total_bulanan += $row['total_bayar'];

                        $jumlah_transaksi++;

                        ?>


                        <tr>

                            <td>
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

                            <td class="harga">

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


                </tbody>

            </table>

        </div>


        <!-- =========================
             SUMMARY
        ========================= -->

        <div class="summary">

            <div class="jumlah">

                🧾 Jumlah Transaksi:

                <strong>
                    <?php echo $jumlah_transaksi; ?>
                </strong>

            </div>


            <div class="pendapatan">

                Total Pendapatan:

                Rp
                <?php
                echo number_format(
                    $total_bulanan,
                    0,
                    ',',
                    '.'
                );
                ?>

            </div>

        </div>


        <!-- =========================
             FOOTER
        ========================= -->

        <div class="footer">

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