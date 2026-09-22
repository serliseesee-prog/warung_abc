
<?php
// struk.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

$id_transaksi = $_GET['id'] ?? '';

$sql_header = "SELECT t.*, u.nama_lengkap AS nama_kasir, p.nama_pelanggan
                FROM tbl_transaksi t
                JOIN tbl_user u ON t.id_kasir = u.id_user
                LEFT JOIN tbl_pelanggan p ON t.id_pelanggan = p.id_pelanggan
                WHERE t.id_transaksi = '$id_transaksi'";

$query_header = mysqli_query($koneksi, $sql_header);
$transaksi = mysqli_fetch_assoc($query_header);

$sql_detail = "SELECT d.jumlah, d.subtotal, b.nama_barang, b.harga_satuan
                FROM tbl_detail_transaksi d
                JOIN tbl_barang b ON d.id_barang = b.id_barang
                WHERE d.id_transaksi = '$id_transaksi'";

$detail = mysqli_query($koneksi, $sql_detail);
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Struk Transaksi - Warung ABC</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #eef2f7;
            color: #1e293b;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            width: 100%;
            max-width: 780px;
            margin: auto;
        }

        /* =========================
           STRUK
        ========================= */

        .struk {
            background: #ffffff;
            border-radius: 14px;
            padding: 35px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.08);
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            text-align: center;
            padding-bottom: 25px;
            border-bottom: 2px dashed #d7dee8;
        }

        .header h1 {
            font-size: 30px;
            font-weight: 800;
            color: #2563eb;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .header p {
            color: #64748b;
            font-size: 14px;
        }

        /* =========================
           INFORMASI TRANSAKSI
        ========================= */

        .info {
            margin-top: 25px;
            margin-bottom: 28px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 18px 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 1px solid #e8edf3;
            font-size: 14px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row span:first-child {
            color: #64748b;
        }

        .info-row span:last-child {
            color: #1e293b;
            font-weight: 600;
            text-align: right;
        }

        /* =========================
           TABEL
        ========================= */

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: #2563eb;
            color: white;
            padding: 14px 12px;
            font-size: 13px;
            font-weight: 600;
            text-align: left;
            white-space: nowrap;
        }

        tbody td {
            padding: 13px 12px;
            border-bottom: 1px solid #e8edf3;
            font-size: 13px;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .harga,
        .subtotal {
            text-align: right;
            white-space: nowrap;
        }

        .jumlah {
            text-align: center;
        }

        /* =========================
           TOTAL
        ========================= */

        .total-row td {
            border-top: 2px solid #334155;
            border-bottom: none;
            padding-top: 18px;
            padding-bottom: 18px;
            font-size: 16px;
            font-weight: 700;
            background: #f8fafc;
        }

        .total-bayar {
            color: #16a34a;
            text-align: right;
            font-size: 18px !important;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            text-align: center;
            margin-top: 28px;
            padding-top: 22px;
            border-top: 2px dashed #d7dee8;
        }

        .footer p {
            color: #64748b;
            font-size: 12px;
            line-height: 1.8;
        }

        .footer p:first-child {
            color: #334155;
            font-size: 13px;
            font-weight: 600;
        }

        /* =========================
           BUTTON
        ========================= */

        .buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 11px 18px;
            border-radius: 7px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-cetak {
            background: #2563eb;
            color: white;
        }

        .btn-cetak:hover {
            background: #1d4ed8;
        }

        .btn-riwayat {
            background: #16a34a;
            color: white;
        }

        .btn-riwayat:hover {
            background: #15803d;
        }

        .btn-dashboard {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-dashboard:hover {
            background: #cbd5e1;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 600px) {

            body {
                padding: 15px 10px;
            }

            .struk {
                padding: 22px 15px;
                border-radius: 10px;
            }

            .header h1 {
                font-size: 24px;
            }

            .header p {
                font-size: 12px;
            }

            .info {
                padding: 15px;
            }

            .info-row {
                font-size: 12px;
                gap: 10px;
            }

            thead th,
            tbody td {
                padding: 10px 7px;
                font-size: 11px;
            }

            .total-row td {
                font-size: 14px;
            }

            .total-bayar {
                font-size: 15px !important;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        /* =========================
           PRINT
        ========================= */

        @media print {

            @page {
                margin: 10mm;
            }

            body {
                background: white;
                padding: 0;
            }

            .container {
                max-width: 100%;
            }

            .struk {
                box-shadow: none;
                border-radius: 0;
                padding: 10px;
            }

            .buttons {
                display: none;
            }

            thead th {
                background: #2563eb !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .total-row td {
                background: white !important;
            }
        }

    </style>

</head>

<body>

<div class="container">

    <div class="struk">

        <!-- HEADER -->
        <div class="header">

            <h1>WARUNG ABC</h1>

            <p>Struk Transaksi Pembelian</p>

        </div>


        <!-- INFORMASI TRANSAKSI -->
        <div class="info">

            <div class="info-row">

                <span>No. Transaksi</span>

                <span>
                    <?php
                    echo htmlspecialchars($transaksi['no_transaksi']);
                    ?>
                </span>

            </div>


            <div class="info-row">

                <span>Tanggal</span>

                <span>
                    <?php
                    echo htmlspecialchars($transaksi['tanggal']);
                    ?>
                </span>

            </div>


            <div class="info-row">

                <span>Kasir</span>

                <span>
                    <?php
                    echo htmlspecialchars($transaksi['nama_kasir']);
                    ?>
                </span>

            </div>


            <div class="info-row">

                <span>Pelanggan</span>

                <span>
                    <?php
                    echo htmlspecialchars(
                        $transaksi['nama_pelanggan'] ?? 'Umum'
                    );
                    ?>
                </span>

            </div>

        </div>


        <!-- DETAIL BARANG -->
        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>Nama Barang</th>

                        <th>Harga</th>

                        <th>Jumlah</th>

                        <th>Subtotal</th>

                    </tr>

                </thead>


                <tbody>

                    <?php while ($item = mysqli_fetch_assoc($detail)) { ?>

                    <tr>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $item['nama_barang']
                            );
                            ?>
                        </td>


                        <td class="harga">

                            Rp
                            <?php
                            echo number_format(
                                $item['harga_satuan'],
                                0,
                                ',',
                                '.'
                            );
                            ?>

                        </td>


                        <td class="jumlah">

                            <?php
                            echo $item['jumlah'];
                            ?>

                        </td>


                        <td class="subtotal">

                            Rp
                            <?php
                            echo number_format(
                                $item['subtotal'],
                                0,
                                ',',
                                '.'
                            );
                            ?>

                        </td>

                    </tr>

                    <?php } ?>


                    <!-- TOTAL -->

                    <tr class="total-row">

                        <td colspan="3">
                            Total Bayar
                        </td>

                        <td class="total-bayar">

                            Rp
                            <?php
                            echo number_format(
                                $transaksi['total_bayar'],
                                0,
                                ',',
                                '.'
                            );
                            ?>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        <!-- FOOTER -->

        <div class="footer">

            <p>
                Terima kasih telah berbelanja di Warung ABC
            </p>

            <p>
                Barang yang sudah dibeli tidak dapat dikembalikan.
            </p>

        </div>


        <!-- BUTTON -->

        <div class="buttons">

            <button
                onclick="window.print()"
                class="btn btn-cetak">
                🖨 Cetak Struk
            </button>


            <a
                href="riwayat_transaksi.php"
                class="btn btn-riwayat">
                Riwayat Transaksi
            </a>


            <a
                href="dashboard.php"
                class="btn btn-dashboard">
                Dashboard
            </a>

        </div>

    </div>

</div>

</body>

</html>