<?php
include 'includes/cek_session.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Barang - Warung ABC</title>

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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
            color: #1e293b;
        }

        /* CONTAINER */

        .container {
            width: 100%;
            max-width: 550px;
            background: #ffffff;
            padding: 35px;
            border-radius: 22px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 15px 40px rgba(15, 23, 42, .10);
        }

        /* HEADER */

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .icon {
            width: 65px;
            height: 65px;
            margin: 0 auto 15px;
            border-radius: 18px;
            background: linear-gradient(135deg, #c7387b, #c7387b);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            box-shadow: 0 8px 18px rgba(37, 99, 235, .25);
        }

        h1 {
            font-size: 25px;
            color: #8a1e66;
            margin-bottom: 7px;
        }

        .subtitle {
            color: #64748b;
            font-size: 13px;
        }

        /* BACK BUTTON */

        .back {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            background: #eff6ff;
            color: #c7387b;
            padding: 10px 15px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 25px;
            transition: .25s;
        }

        .back:hover {
            background: #dbeafe;
            transform: translateX(-3px);
        }

        /* FORM */

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            color: #334155;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .input-box {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            pointer-events: none;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            height: 46px;
            padding: 0 13px 0 42px;
            border: 1px solid #dbe3ee;
            border-radius: 10px;
            background: #f8fafc;
            color: #1e293b;
            font-size: 14px;
            outline: none;
            transition: .25s;
        }

        input:hover {
            border-color: #93c5fd;
        }

        input:focus {
            background: white;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .10);
        }

        /* SUBMIT */

        .submit-btn {
            width: 100%;
            height: 48px;
            margin-top: 7px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #eb259f, #eb259f);
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 7px 16px rgba(37, 99, 235, .20);
            transition: .25s;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, .28);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* FOOTER */

        .footer {
            text-align: center;
            margin-top: 22px;
            color: #94a3b8;
            font-size: 11px;
        }

        /* RESPONSIVE */

        @media (max-width: 600px) {

            body {
                padding: 15px;
                align-items: flex-start;
                padding-top: 25px;
            }

            .container {
                padding: 25px 20px;
                border-radius: 18px;
            }

            h1 {
                font-size: 22px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <!-- HEADER -->

    <div class="header">

        <div class="icon">
            📦
        </div>

        <h1>Tambah Barang</h1>

        <p class="subtitle">
            Tambahkan barang baru ke dalam sistem Warung ABC
        </p>

    </div>


    <!-- KEMBALI -->

    <a href="data_barang.php" class="back">
        ← Kembali ke Data Barang
    </a>


    <!-- FORM -->

    <form action="proses_tambah_barang.php" method="POST">

        <div class="form-group">

            <label>Kode Barang</label>

            <div class="input-box">

                <span class="input-icon">🏷️</span>

                <input
                    type="text"
                    name="kode_barang"
                    placeholder="Contoh: BRG001"
                    required
                >

            </div>

        </div>


        <div class="form-group">

            <label>Nama Barang</label>

            <div class="input-box">

                <span class="input-icon">📦</span>

                <input
                    type="text"
                    name="nama_barang"
                    placeholder="Masukkan nama barang"
                    required
                >

            </div>

        </div>


        <div class="form-group">

            <label>Harga Satuan</label>

            <div class="input-box">

                <span class="input-icon">💰</span>

                <input
                    type="number"
                    name="harga_satuan"
                    step="0.01"
                    placeholder="Contoh: 10000"
                    required
                >

            </div>

        </div>


        <div class="form-group">

            <label>Stok Barang</label>

            <div class="input-box">

                <span class="input-icon">🔢</span>

                <input
                    type="number"
                    name="stok"
                    placeholder="Masukkan jumlah stok"
                    required
                >

            </div>

        </div>


        <div class="form-group">

            <label>Tanggal Kadaluarsa</label>

            <div class="input-box">

                <span class="input-icon">📅</span>

                <input
                    type="date"
                    name="tanggal_kadaluarsa"
                >

            </div>

        </div>


        <button type="submit" class="submit-btn">
            💾 Simpan Barang
        </button>

    </form>


    <div class="footer">
        © 2026 Warung ABC • Sistem Informasi Warung
    </div>

</div>

</body>

</html>