<?php
// edit_barang.php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = $_GET['id'];

$sql = "SELECT * FROM tbl_barang WHERE id_barang = '$id'";
$hasil = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($hasil);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Barang - Warung ABC</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #333;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 650px;
            margin: 50px auto;
        }

        .card {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
            color: #1f2937;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #374151;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: 0.2s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }

        .btn-update {
            background: #2563eb;
            color: white;
        }

        .btn-update:hover {
            background: #1d4ed8;
        }

        .btn-kembali {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-kembali:hover {
            background: #d1d5db;
        }

        @media (max-width: 600px) {
            .container {
                width: 95%;
                margin: 25px auto;
            }

            .card {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="card">

            <h1>Edit Barang</h1>

            <form action="proses_edit_barang.php" method="POST">

                <input type="hidden"
                    name="id_barang"
                    value="<?php echo $data['id_barang']; ?>">

                <div class="form-group">
                    <label>Kode Barang</label>

                    <input type="text"
                        name="kode_barang"
                        value="<?php echo htmlspecialchars($data['kode_barang']); ?>"
                        required>
                </div>

                <div class="form-group">
                    <label>Nama Barang</label>

                    <input type="text"
                        name="nama_barang"
                        value="<?php echo htmlspecialchars($data['nama_barang']); ?>"
                        required>
                </div>

                <div class="form-group">
                    <label>Harga Satuan</label>

                    <input type="number"
                        name="harga_satuan"
                        step="0.01"
                        value="<?php echo $data['harga_satuan']; ?>"
                        required>
                </div>

                <div class="form-group">
                    <label>Stok</label>

                    <input type="number"
                        name="stok"
                        value="<?php echo $data['stok']; ?>"
                        required>
                </div>

                <div class="form-group">
                    <label>Tanggal Kadaluarsa</label>

                    <input type="date"
                        name="tanggal_kadaluarsa"
                        value="<?php echo $data['tanggal_kadaluarsa']; ?>">
                </div>

                <div class="button-group">

                    <button type="submit" class="btn btn-update">
                        Update Barang
                    </button>

                    <a href="data_barang.php" class="btn btn-kembali">
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>


