
<?php
// edit_pelanggan.php

include 'includes/cek_session.php';
include 'config/koneksi.php';

$id = $_GET['id'];

$sql = "SELECT * FROM tbl_pelanggan WHERE id_pelanggan = '$id'";
$hasil = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($hasil);
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Pelanggan - Warung ABC</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 450px;
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #444;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            transition: 0.3s;
        }

        input[type="text"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.2);
        }

        .btn-update {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #007bff;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-update:hover {
            background: #0056b3;
        }

        .btn-kembali {
            display: block;
            text-align: center;
            margin-top: 15px;
            padding: 11px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-kembali:hover {
            background: #545b62;
        }

        @media (max-width: 500px) {

            .container {
                width: 100%;
                padding: 25px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <h1>Edit Pelanggan</h1>

    <form action="proses_edit_pelanggan.php" method="POST">

        <input
            type="hidden"
            name="id_pelanggan"
            value="<?php echo htmlspecialchars($data['id_pelanggan']); ?>"
        >

        <div class="form-group">

            <label>Nama Pelanggan</label>

            <input
                type="text"
                name="nama_pelanggan"
                value="<?php echo htmlspecialchars($data['nama_pelanggan']); ?>"
                placeholder="Masukkan nama pelanggan"
                required
            >

        </div>

        <div class="form-group">

            <label>No. HP</label>

            <input
                type="text"
                name="no_hp"
                value="<?php echo htmlspecialchars($data['no_hp']); ?>"
                placeholder="Masukkan nomor HP"
            >

        </div>

        <div class="form-group">

            <label>Alamat</label>

            <input
                type="text"
                name="alamat"
                value="<?php echo htmlspecialchars($data['alamat']); ?>"
                placeholder="Masukkan alamat pelanggan"
            >

        </div>

        <button type="submit" class="btn-update">
            Update Pelanggan
        </button>

    </form>

    <a href="data_pelanggan.php" class="btn-kembali">
        ← Kembali
    </a>

</div>

</body>
</html>