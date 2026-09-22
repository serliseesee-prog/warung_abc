<?php
// transaksi.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array();
}

$sql_pelanggan = "SELECT * FROM tbl_pelanggan ORDER BY nama_pelanggan ASC";
$hasil_pelanggan = mysqli_query($koneksi, $sql_pelanggan);

$daftar_barang = mysqli_query(
    $koneksi,
    "SELECT * FROM tbl_barang WHERE stok > 0"
);

$total = 0;

foreach ($_SESSION['keranjang'] as $item) {
    $total += $item['subtotal'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Transaksi - Warung ABC</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #eff6ff, #f8fafc);
            color: #1e293b;
            padding: 35px 20px;
        }

        /* CONTAINER */

        .container {
            width: 100%;
            max-width: 1150px;
            margin: auto;
        }

        /* HEADER */

        .header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 28px 30px;
            border-radius: 20px;
            margin-bottom: 22px;
            box-shadow: 0 10px 25px rgba(37, 99, 235, .20);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-icon {
            width: 58px;
            height: 58px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.20);
            border-radius: 15px;
            font-size: 28px;
        }

        .header h1 {
            font-size: 27px;
            margin-bottom: 6px;
        }

        .header p {
            font-size: 13px;
            opacity: .85;
        }

        /* ERROR */

        .error {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            padding: 14px 17px;
            border-radius: 11px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        /* CARD */

        .card {
            background: white;
            padding: 27px;
            border-radius: 18px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 25px rgba(15, 23, 42, .06);
        }

        /* CARD HEADER */

        .card-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
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

        .card-title h3 {
            color: #1e293b;
            font-size: 19px;
        }

        .card-title p {
            color: #64748b;
            font-size: 12px;
            margin-top: 4px;
        }

        /* FORM */

        .form-row {
            display: flex;
            gap: 15px;
            align-items: flex-end;
        }

        .form-group {
            flex: 1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-size: 13px;
            font-weight: bold;
        }

        select,
        input[type="number"] {
            width: 100%;
            height: 46px;
            padding: 0 13px;
            border: 1px solid #dbe3ee;
            border-radius: 10px;
            background: #f8fafc;
            color: #334155;
            font-size: 14px;
            outline: none;
            transition: .25s;
        }

        select:hover,
        input[type="number"]:hover {
            border-color: #93c5fd;
        }

        select:focus,
        input[type="number"]:focus {
            background: white;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .10);
        }

        /* BUTTON */

        .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            border: none;
            border-radius: 10px;
            padding: 11px 17px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: .25s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        /* TAMBAH */

        .btn-tambah {
            height: 46px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            box-shadow: 0 5px 13px rgba(37, 99, 235, .20);
            white-space: nowrap;
        }

        .btn-tambah:hover {
            box-shadow: 0 8px 17px rgba(37, 99, 235, .28);
        }

        /* TABLE */

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid #e2e8f0;
            border-radius: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        thead {
            background: #f8fafc;
        }

        thead th {
            color: #475569;
            padding: 14px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .4px;
            border-bottom: 2px solid #e2e8f0;
        }

        tbody td {
            padding: 14px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #475569;
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

        /* HARGA */

        .harga {
            color: #2563eb;
            font-weight: bold;
        }

        .subtotal {
            color: #16a34a;
            font-weight: bold;
        }

        /* HAPUS */

        .btn-hapus {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
            padding: 8px 12px;
            font-size: 12px;
        }

        .btn-hapus:hover {
            background: #ef4444;
            color: white;
        }

        /* EMPTY */

        .empty {
            text-align: center;
            padding: 35px !important;
            color: #94a3b8 !important;
            font-size: 13px !important;
        }

        /* TOTAL */

        .total-row td {
            border-top: 2px solid #cbd5e1;
            padding-top: 18px;
            padding-bottom: 18px;
            font-weight: bold;
            font-size: 16px;
        }

        .total-harga {
            color: #16a34a !important;
            font-size: 19px !important;
        }

        /* PELANGGAN */

        .pelanggan-form {
            max-width: 550px;
        }

        /* SIMPAN */

        .btn-simpan {
            width: 100%;
            height: 48px;
            margin-top: 16px;
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: white;
            box-shadow: 0 6px 14px rgba(22, 163, 74, .18);
        }

        .btn-simpan:hover {
            box-shadow: 0 9px 18px rgba(22, 163, 74, .25);
        }

        /* DASHBOARD */

        .btn-dashboard {
            background: white;
            color: #475569;
            border: 1px solid #dbe3ee;
            box-shadow: 0 3px 10px rgba(15, 23, 42, .05);
        }

        .btn-dashboard:hover {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        /* RESPONSIVE */

        @media (max-width: 750px) {

            body {
                padding: 20px 10px;
            }

            .header {
                padding: 22px;
                align-items: flex-start;
            }

            .header h1 {
                font-size: 22px;
            }

            .header-icon {
                width: 48px;
                height: 48px;
                font-size: 23px;
            }

            .card {
                padding: 19px;
            }

            .form-row {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-tambah {
                width: 100%;
            }

            .pelanggan-form {
                max-width: 100%;
            }

            table {
                min-width: 700px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <!-- HEADER -->

    <div class="header">

        <div class="header-content">

            <div class="header-icon">
                🛒
            </div>

            <div>

                <h1>Transaksi Penjualan</h1>

                <p>
                    Kelola transaksi dan keranjang belanja Warung ABC
                </p>

            </div>

        </div>

    </div>


    <!-- PESAN ERROR -->

    <?php if (isset($_SESSION['pesan_error'])) { ?>

        <div class="error">

            ⚠️
            <?php
            echo htmlspecialchars($_SESSION['pesan_error']);
            unset($_SESSION['pesan_error']);
            ?>

        </div>

    <?php } ?>


    <!-- PILIH BARANG -->

    <div class="card">

        <div class="card-title">

            <div class="card-icon">
                📦
            </div>

            <div>

                <h3>Pilih Barang</h3>

                <p>
                    Pilih barang dan tentukan jumlah yang ingin dibeli
                </p>

            </div>

        </div>


        <form
            action="proses_tambah_keranjang.php"
            method="POST">

            <div class="form-row">

                <div class="form-group">

                    <label>Barang</label>

                    <select name="id_barang" required>

                        <option value="">
                            -- Pilih Barang --
                        </option>

                        <?php while ($b = mysqli_fetch_assoc($daftar_barang)) { ?>

                            <option
                                value="<?php echo $b['id_barang']; ?>">

                                <?php
                                echo htmlspecialchars(
                                    $b['nama_barang']
                                );
                                ?>

                                - Stok:
                                <?php echo $b['stok']; ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>


                <div class="form-group">

                    <label>Jumlah</label>

                    <input
                        type="number"
                        name="jumlah"
                        min="1"
                        required
                        placeholder="Jumlah">

                </div>


                <div>

                    <button
                        type="submit"
                        class="btn btn-tambah">

                        🛒 Tambah ke Keranjang

                    </button>

                </div>

            </div>

        </form>

    </div>


    <!-- KERANJANG -->

    <div class="card">

        <div class="card-title">

            <div class="card-icon">
                🛍️
            </div>

            <div>

                <h3>Keranjang Belanja</h3>

                <p>
                    Daftar barang yang akan dibeli
                </p>

            </div>

        </div>


        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    <?php if (empty($_SESSION['keranjang'])) { ?>

                        <tr>

                            <td
                                colspan="5"
                                class="empty">

                                🛒 Keranjang masih kosong.

                            </td>

                        </tr>

                    <?php } else { ?>


                        <?php foreach (
                            $_SESSION['keranjang']
                            as $id_barang => $item
                        ) { ?>

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
                                        $item['harga'],
                                        0,
                                        ',',
                                        '.'
                                    );
                                    ?>

                                </td>


                                <td>

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


                                <td>

                                    <a
                                        href="hapus_keranjang.php?id=<?php echo $id_barang; ?>"
                                        class="btn btn-hapus">

                                        🗑️ Hapus

                                    </a>

                                </td>

                            </tr>

                        <?php } ?>


                        <!-- TOTAL -->

                        <tr class="total-row">

                            <td colspan="3">
                                Total Pembayaran
                            </td>

                            <td
                                colspan="2"
                                class="total-harga">

                                Rp
                                <?php
                                echo number_format(
                                    $total,
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

    </div>


    <!-- DATA PELANGGAN -->

    <div class="card">

        <div class="card-title">

            <div class="card-icon">
                👤
            </div>

            <div>

                <h3>Data Pelanggan</h3>

                <p>
                    Pilih pelanggan untuk transaksi ini
                </p>

            </div>

        </div>


        <div class="pelanggan-form">

            <form
                action="proses_simpan_transaksi.php"
                method="POST">

                <div class="form-group">

                    <label>Pelanggan</label>

                    <select
                        name="id_pelanggan"
                        required>

                        <option value="">
                            -- Pilih Pelanggan --
                        </option>

                        <?php while (
                            $p = mysqli_fetch_assoc(
                                $hasil_pelanggan
                            )
                        ) { ?>

                            <option
                                value="<?php echo $p['id_pelanggan']; ?>">

                                <?php
                                echo htmlspecialchars(
                                    $p['nama_pelanggan']
                                );
                                ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>


                <input
                    type="submit"
                    value="💾 Simpan Transaksi"
                    class="btn btn-simpan">

            </form>

        </div>

    </div>


    <!-- DASHBOARD -->

    <a
        href="dashboard.php"
        class="btn btn-dashboard">

        ← Kembali ke Dashboard

    </a>

</div>

</body>

</html>