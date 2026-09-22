<?php
// riwayat_transaksi.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

// Ambil data transaksi dari database
$sql = "SELECT 
            t.id_transaksi,
            t.no_transaksi,
            t.tanggal,
            t.total_bayar,
            u.nama_lengkap AS nama_kasir
        FROM tbl_transaksi t
        JOIN tbl_user u ON t.id_kasir = u.id_user
        ORDER BY t.tanggal DESC";

$hasil = mysqli_query($koneksi, $sql);

// Cek jika query gagal
if (!$hasil) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Transaksi - Warung ABC</title>

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
            min-height: 100vh;
            background: linear-gradient(
                135deg,
                #eff6ff,
                #f8fafc
            );
            color: #1e293b;
            padding: 35px 20px;
        }


        /* =========================
           CONTAINER
        ========================= */

        .container {
            width: 100%;
            max-width: 1150px;
            margin: auto;
        }


        /* =========================
           HEADER
        ========================= */

        .page-header {
            background: linear-gradient(
                135deg,
                #2563eb,
                #1d4ed8
            );

            color: white;
            padding: 28px 30px;
            border-radius: 20px;
            margin-bottom: 22px;

            display: flex;
            align-items: center;
            gap: 16px;

            box-shadow:
                0 10px 25px rgba(37, 99, 235, .20);
        }


        .header-icon {
            width: 58px;
            height: 58px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.20);

            border-radius: 15px;

            font-size: 28px;
        }


        .page-header h1 {
            font-size: 27px;
            margin-bottom: 6px;
        }


        .page-header p {
            font-size: 13px;
            opacity: .85;
        }


        /* =========================
           CARD
        ========================= */

        .card {
            background: white;

            padding: 27px;

            border-radius: 18px;

            border: 1px solid #e2e8f0;

            box-shadow:
                0 8px 25px rgba(15, 23, 42, .06);
        }


        /* =========================
           CARD TOP
        ========================= */

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 22px;
        }


        .card-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }


        .card-icon {
            width: 45px;
            height: 45px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #eff6ff;

            border-radius: 11px;

            font-size: 21px;
        }


        .card-title h2 {
            font-size: 19px;
            color: #1e293b;
        }


        .card-title p {
            margin-top: 4px;

            color: #64748b;

            font-size: 12px;
        }


        /* =========================
           TABLE
        ========================= */

        .table-wrapper {
            width: 100%;
            overflow-x: auto;

            border: 1px solid #e2e8f0;

            border-radius: 13px;
        }


        table {
            width: 100%;
            border-collapse: collapse;

            min-width: 750px;
        }


        thead {
            background: #f8fafc;
        }


        thead th {
            padding: 15px;

            text-align: left;

            color: #475569;

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: .4px;

            border-bottom: 2px solid #e2e8f0;

            white-space: nowrap;
        }


        tbody td {
            padding: 15px;

            border-bottom: 1px solid #f1f5f9;

            color: #475569;

            font-size: 14px;

            white-space: nowrap;
        }


        tbody tr {
            transition: .2s;
        }


        tbody tr:hover {
            background: #f8fbff;
        }


        tbody tr:last-child td {
            border-bottom: none;
        }


        /* =========================
           NOMOR TRANSAKSI
        ========================= */

        .no-transaksi {
            display: inline-block;

            padding: 6px 10px;

            background: #eff6ff;

            color: #2563eb;

            border-radius: 7px;

            font-size: 12px;

            font-weight: bold;
        }


        /* =========================
           KASIR
        ========================= */

        .kasir {
            display: flex;
            align-items: center;
            gap: 8px;

            color: #334155;

            font-weight: 500;
        }


        .kasir-icon {
            width: 30px;
            height: 30px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #f1f5f9;

            border-radius: 50%;

            font-size: 14px;
        }


        /* =========================
           TOTAL
        ========================= */

        .total {
            color: #16a34a !important;

            font-size: 14px;

            font-weight: bold;
        }


        /* =========================
           BUTTON CETAK
        ========================= */

        .btn-cetak {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 6px;

            padding: 8px 13px;

            background: linear-gradient(
                135deg,
                #2563eb,
                #1d4ed8
            );

            color: white;

            text-decoration: none;

            border-radius: 8px;

            font-size: 12px;

            font-weight: bold;

            box-shadow:
                0 4px 10px rgba(37, 99, 235, .18);

            transition: .25s;
        }


        .btn-cetak:hover {
            transform: translateY(-2px);

            box-shadow:
                0 7px 15px rgba(37, 99, 235, .28);
        }


        /* =========================
           EMPTY
        ========================= */

        .empty {
            text-align: center;

            padding: 45px !important;

            color: #94a3b8 !important;

            font-size: 14px !important;
        }


        .empty-icon {
            display: block;

            font-size: 35px;

            margin-bottom: 8px;
        }


        /* =========================
           BACK BUTTON
        ========================= */

        .back-link {
            display: inline-flex;

            align-items: center;

            gap: 7px;

            margin-top: 20px;

            padding: 11px 17px;

            background: white;

            color: #475569;

            border: 1px solid #dbe3ee;

            border-radius: 10px;

            text-decoration: none;

            font-size: 13px;

            font-weight: bold;

            box-shadow:
                0 3px 10px rgba(15, 23, 42, .05);

            transition: .25s;
        }


        .back-link:hover {
            background: #eff6ff;

            color: #2563eb;

            border-color: #bfdbfe;

            transform: translateY(-2px);
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 700px) {

            body {
                padding: 20px 10px;
            }


            .page-header {
                padding: 22px;
            }


            .header-icon {
                width: 48px;
                height: 48px;

                font-size: 23px;
            }


            .page-header h1 {
                font-size: 22px;
            }


            .page-header p {
                font-size: 12px;
            }


            .card {
                padding: 18px;
            }


            .card-top {
                align-items: flex-start;
            }


            table {
                min-width: 750px;
            }

        }

    </style>

</head>

<body>

<div class="container">


    <!-- HEADER -->

    <div class="page-header">

        <div class="header-icon">
            📊
        </div>

        <div>

            <h1>Riwayat Transaksi</h1>

            <p>
                Lihat dan cetak seluruh riwayat transaksi Warung ABC
            </p>

        </div>

    </div>


    <!-- CARD -->

    <div class="card">


        <!-- CARD HEADER -->

        <div class="card-top">

            <div class="card-title">

                <div class="card-icon">
                    🧾
                </div>

                <div>

                    <h2>Daftar Transaksi</h2>

                    <p>
                        Informasi transaksi yang telah dilakukan
                    </p>

                </div>

            </div>

        </div>


        <!-- TABLE -->

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>No Transaksi</th>

                        <th>Tanggal</th>

                        <th>Kasir</th>

                        <th>Total Bayar</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    <?php if (mysqli_num_rows($hasil) == 0): ?>

                        <tr>

                            <td
                                colspan="5"
                                class="empty">

                                <span class="empty-icon">
                                    🧾
                                </span>

                                Belum ada transaksi.

                            </td>

                        </tr>


                    <?php else: ?>


                        <?php while ($row = mysqli_fetch_assoc($hasil)): ?>

                            <tr>


                                <!-- NOMOR TRANSAKSI -->

                                <td>

                                    <span class="no-transaksi">

                                        #
                                        <?= htmlspecialchars(
                                            $row['no_transaksi']
                                        ) ?>

                                    </span>

                                </td>


                                <!-- TANGGAL -->

                                <td>

                                    📅
                                    <?= htmlspecialchars(
                                        $row['tanggal']
                                    ) ?>

                                </td>


                                <!-- KASIR -->

                                <td>

                                    <div class="kasir">

                                        <span class="kasir-icon">
                                            👤
                                        </span>

                                        <?= htmlspecialchars(
                                            $row['nama_kasir']
                                        ) ?>

                                    </div>

                                </td>


                                <!-- TOTAL -->

                                <td class="total">

                                    Rp
                                    <?= number_format(
                                        $row['total_bayar'],
                                        0,
                                        ',',
                                        '.'
                                    ) ?>

                                </td>


                                <!-- AKSI -->

                                <td>

                                    <a
                                        href="struk.php?id=<?= $row['id_transaksi'] ?>"
                                        class="btn-cetak">

                                        🖨️ Cetak

                                    </a>

                                </td>


                            </tr>

                        <?php endwhile; ?>


                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>


    <!-- BACK -->

    <a
        href="dashboard.php"
        class="back-link">

        ← Kembali ke Dashboard

    </a>


</div>

</body>

</html>