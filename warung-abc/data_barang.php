<?php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$sql = "SELECT * FROM tbl_barang ORDER BY nama_barang ASC";
$hasil = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Warung ABC</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f1f5f9;
            color: #1e293b;
        }

        .container {
            width: 92%;
            max-width: 1250px;
            margin: 40px auto;
        }

        /* HEADER */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg,  #e62f93,  #e62f93);
            padding: 25px 30px;
            border-radius: 18px;
            color: white;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(245, 152, 206, 0.2);
        }

        .page-header h1 {
            font-size: 27px;
            margin-bottom: 7px;
        }

        .page-header p {
            font-size: 14px;
            opacity: .85;
        }

        .dashboard-btn {
            text-decoration: none;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
            color: white;
            padding: 11px 17px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
            transition: .3s;
        }

        .dashboard-btn:hover {
            background: white;
            color:   #e62f93
            transform: translateY(-2px);
        }

        /* CARD */
        .content-card {
            background: white;
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 5px 25px rgba(15, 23, 42, .07);
        }

        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .title-icon {
            width: 48px;
            height: 48px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #eff6ff;
            border-radius: 12px;
            font-size: 23px;
        }

        .card-title h2 {
            font-size: 20px;
            color: #1e293b;
        }

        .card-title p {
            margin-top: 4px;
            color: #64748b;
            font-size: 13px;
        }

        /* BUTTON TAMBAH */
        .btn-tambah {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            background: #e580c7;
            color: white;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 5px 12px rgba(37, 99, 235, .20);
            transition: .3s;
        }

        .btn-tambah:hover {
            background: #cfd1d8;
            transform: translateY(-2px);
            box-shadow: 0 7px 16px rgba(37, 99, 235, .25);
        }

        /* TABLE */
        .table-container {
            overflow-x: auto;
            border: 1px solid #e2e8f0;
            border-radius: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        thead {
            background: #f8fafc;
        }

        th {
            padding: 15px;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .4px;
            border-bottom: 1px solid #e2e8f0;
        }

        td {
            padding: 15px;
            text-align: center;
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

        /* DATA */
        .kode {
            font-weight: bold;
            color: #2563eb;
        }

        .nama {
            color: #1e293b;
            font-weight: 600;
        }

        .harga {
            color: #16a34a;
            font-weight: bold;
        }

        .stok {
            display: inline-block;
            min-width: 55px;
            padding: 6px 11px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .tanggal {
            color: #64748b;
        }

        /* AKSI */
        .aksi {
            display: flex;
            justify-content: center;
            gap: 7px;
        }

        .edit,
        .hapus {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: bold;
            transition: .25s;
        }

        .edit {
            background: #22c55e;
        }

        .edit:hover {
            background: #16a34a;
            transform: translateY(-2px);
        }

        .hapus {
            background: #ef4444;
        }

        .hapus:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        /* FOOTER */
        .footer {
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            margin-top: 20px;
        }

        /* RESPONSIVE */
        @media (max-width: 700px) {

            .container {
                width: 94%;
                margin: 20px auto;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 18px;
                padding: 22px;
            }

            .page-header h1 {
                font-size: 22px;
            }

            .dashboard-btn {
                width: 100%;
                text-align: center;
            }

            .content-card {
                padding: 18px;
            }

            .card-top {
                flex-direction: column;
                align-items: flex-start;
                gap: 18px;
            }

            .btn-tambah {
                width: 100%;
                justify-content: center;
            }

            .title-icon {
                width: 42px;
                height: 42px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="page-header">

        <div>
            <h1>📦 Data Barang</h1>
            <p>Kelola data barang Warung ABC dengan mudah.</p>
        </div>

        <a href="dashboard.php" class="dashboard-btn">
            🏠 Kembali ke Dashboard
        </a>

    </div>


    <!-- CONTENT -->
    <div class="content-card">

        <div class="card-top">

            <div class="card-title">

                <div class="title-icon">
                    📦
                </div>

                <div>
                    <h2>Daftar Barang</h2>
                    <p>Daftar barang yang tersedia di Warung ABC</p>
                </div>

            </div>

            <a href="tambah_barang.php" class="btn-tambah">
                ➕ Tambah Barang
            </a>

        </div>


        <!-- TABLE -->
        <div class="table-container">

            <table>

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Stok</th>
                        <th>Kadaluarsa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $no = 1;

                while ($row = mysqli_fetch_assoc($hasil)) {
                ?>

                    <tr>

                        <td>
                            <?php echo $no++; ?>
                        </td>

                        <td class="kode">
                            <?php echo htmlspecialchars($row['kode_barang']); ?>
                        </td>

                        <td class="nama">
                            <?php echo htmlspecialchars($row['nama_barang']); ?>
                        </td>

                        <td class="harga">
                            Rp <?php
                            echo number_format(
                                $row['harga_satuan'],
                                0,
                                ',',
                                '.'
                            );
                            ?>
                        </td>

                        <td>
                            <span class="stok">
                                <?php echo $row['stok']; ?> pcs
                            </span>
                        </td>

                        <td class="tanggal">
                            <?php echo htmlspecialchars($row['tanggal_kadaluarsa']); ?>
                        </td>

                        <td>

                            <div class="aksi">

                                <a
                                    href="edit_barang.php?id=<?php echo $row['id_barang']; ?>"
                                    class="edit"
                                >
                                    ✏️ Edit
                                </a>

                                <a
                                    href="hapus_barang.php?id=<?php echo $row['id_barang']; ?>"
                                    class="hapus"
                                    onclick="return confirm('Yakin ingin menghapus barang ini?')"
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