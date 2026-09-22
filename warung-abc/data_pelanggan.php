<?php
// data_pelanggan.php
include "includes/cek_session.php";
include "config/koneksi.php";

$sql = "SELECT * FROM tbl_pelanggan ORDER BY nama_pelanggan ASC";
$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Pelanggan - Warung ABC</title>

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
            padding: 40px 20px;
        }

        /* CONTAINER */

        .container {
            width: 100%;
            max-width: 1150px;
            margin: auto;
        }

        /* HEADER */

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            padding: 25px 30px;
            border-radius: 18px;
            color: white;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(37, 99, 235, .20);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-icon {
            width: 55px;
            height: 55px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.20);
            border-radius: 14px;
            font-size: 26px;
        }

        .page-header h1 {
            font-size: 26px;
            margin-bottom: 5px;
        }

        .page-header p {
            font-size: 13px;
            opacity: .85;
        }

        .dashboard-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            color: white;
            padding: 11px 16px;
            border-radius: 10px;
            background: rgba(255,255,255,.14);
            border: 1px solid rgba(255,255,255,.22);
            font-size: 13px;
            font-weight: bold;
            transition: .25s;
        }

        .dashboard-btn:hover {
            background: white;
            color: #2563eb;
            transform: translateY(-2px);
        }

        /* CARD */

        .content-card {
            background: white;
            padding: 28px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .07);
        }

        /* CARD HEADER */

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 23px;
        }

        .title-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .title-icon {
            width: 45px;
            height: 45px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .title-area h2 {
            font-size: 19px;
            color: #1e293b;
        }

        .title-area p {
            margin-top: 4px;
            font-size: 12px;
            color: #64748b;
        }

        /* BUTTON TAMBAH */

        .btn-tambah {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 11px 17px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: bold;
            box-shadow: 0 5px 13px rgba(37, 99, 235, .20);
            transition: .25s;
        }

        .btn-tambah:hover {
            transform: translateY(-2px);
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
            min-width: 750px;
        }

        th {
            background: #f8fafc;
            color: #475569;
            padding: 15px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .4px;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
            font-size: 14px;
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

        /* DATA PELANGGAN */

        .nama {
            font-weight: bold;
            color: #1e293b;
        }

        .nama::before {
            content: "👤";
            margin-right: 8px;
        }

        .hp {
            color: #2563eb;
            font-weight: 600;
        }

        .alamat {
            color: #64748b;
        }

        /* AKSI */

        .aksi {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        .btn-edit,
        .btn-hapus {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
            transition: .25s;
        }

        .btn-edit {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .btn-edit:hover {
            background: #f59e0b;
            color: white;
            transform: translateY(-2px);
        }

        .btn-hapus {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .btn-hapus:hover {
            background: #ef4444;
            color: white;
            transform: translateY(-2px);
        }

        /* FOOTER */

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #94a3b8;
            font-size: 11px;
        }

        /* RESPONSIVE */

        @media (max-width: 700px) {

            body {
                padding: 20px 10px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                padding: 22px;
            }

            .page-header h1 {
                font-size: 22px;
            }

            .dashboard-btn {
                width: 100%;
                justify-content: center;
            }

            .content-card {
                padding: 18px;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .btn-tambah {
                width: 100%;
                justify-content: center;
            }

            .aksi {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-edit,
            .btn-hapus {
                justify-content: center;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <!-- HEADER -->

    <div class="page-header">

        <div class="header-left">

            <div class="header-icon">
                👥
            </div>

            <div>

                <h1>Data Pelanggan</h1>

                <p>
                    Kelola data pelanggan Warung ABC
                </p>

            </div>

        </div>

        <a href="dashboard.php" class="dashboard-btn">
            🏠 Dashboard
        </a>

    </div>


    <!-- CONTENT -->

    <div class="content-card">

        <div class="card-header">

            <div class="title-area">

                <div class="title-icon">
                    👥
                </div>

                <div>

                    <h2>Daftar Pelanggan</h2>

                    <p>
                        Informasi pelanggan yang terdaftar
                    </p>

                </div>

            </div>


            <a
                href="tambah_pelanggan.php"
                class="btn-tambah"
            >
                ➕ Tambah Pelanggan
            </a>

        </div>


        <!-- TABLE -->

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>Nama Pelanggan</th>

                        <th>No. HP</th>

                        <th>Alamat</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while ($row = mysqli_fetch_assoc($hasil)) { ?>

                    <tr>

                        <td class="nama">

                            <?php
                            echo htmlspecialchars(
                                $row['nama_pelanggan']
                            );
                            ?>

                        </td>


                        <td class="hp">

                            📱
                            <?php
                            echo htmlspecialchars(
                                $row['no_hp']
                            );
                            ?>

                        </td>


                        <td class="alamat">

                            📍
                            <?php
                            echo htmlspecialchars(
                                $row['alamat']
                            );
                            ?>

                        </td>


                        <td>

                            <div class="aksi">

                                <a
                                    href="edit_pelanggan.php?id=<?php echo $row['id_pelanggan']; ?>"
                                    class="btn-edit"
                                >
                                    ✏️ Edit
                                </a>

                                <a
                                    href="hapus_pelanggan.php?id=<?php echo $row['id_pelanggan']; ?>"
                                    class="btn-hapus"
                                    onclick="return confirm('Yakin hapus pelanggan ini?');"
                                >
                                    🗑️ Hapus
                                </a>

                            </div>

                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>


    <div class="footer">
        © 2026 Warung ABC • Sistem Informasi Warung
    </div>

</div>

</body>

</html>