
<?php
// tambah_pelanggan.php

include 'includes/cek_session.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Pelanggan - Warung ABC</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #f1f5f9;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 25px;
        }

        .container {
            width: 100%;
            max-width: 470px;

            background: #ffffff;

            padding: 35px;

            border-radius: 14px;

            border: 1px solid #e2e8f0;

            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        /* =========================
           JUDUL
        ========================= */

        h1 {
            text-align: center;

            color: #1e293b;

            font-size: 26px;
            font-weight: 700;

            margin-bottom: 8px;
        }

        h1::after {
            content: "";

            display: block;

            width: 45px;
            height: 3px;

            background: #2563eb;

            margin: 10px auto 28px;

            border-radius: 10px;
        }

        /* =========================
           FORM
        ========================= */

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;

            margin-bottom: 8px;

            color: #334155;

            font-size: 14px;
            font-weight: 600;
        }

        input[type="text"] {
            width: 100%;
            height: 45px;

            padding: 0 14px;

            border: 1px solid #cbd5e1;
            border-radius: 8px;

            outline: none;

            background: #ffffff;
            color: #1e293b;

            font-size: 14px;

            transition: 0.2s ease;
        }

        input[type="text"]::placeholder {
            color: #94a3b8;
        }

        input[type="text"]:hover {
            border-color: #94a3b8;
        }

        input[type="text"]:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* =========================
           TOMBOL SIMPAN
        ========================= */

        .btn-simpan {
            width: 100%;
            height: 45px;

            margin-top: 5px;

            border: none;
            border-radius: 8px;

            background: #2563eb;
            color: #ffffff;

            font-size: 14px;
            font-weight: 600;

            cursor: pointer;

            transition: 0.2s ease;
        }

        .btn-simpan:hover {
            background: #1d4ed8;

            transform: translateY(-1px);

            box-shadow:
                0 5px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-simpan:active {
            transform: translateY(0);
        }

        /* =========================
           TOMBOL KEMBALI
        ========================= */

        .btn-kembali {
            display: flex;

            justify-content: center;
            align-items: center;

            width: 100%;
            height: 45px;

            margin-top: 10px;

            background: #f1f5f9;

            border: 1px solid #e2e8f0;
            border-radius: 8px;

            color: #475569;

            text-decoration: none;

            font-size: 14px;
            font-weight: 600;

            transition: 0.2s ease;
        }

        .btn-kembali:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 500px) {

            body {
                padding: 15px;
            }

            .container {
                padding: 28px 22px;
            }

            h1 {
                font-size: 23px;
            }

            input[type="text"],
            .btn-simpan,
            .btn-kembali {
                height: 44px;
            }
        }

    </style>

</head>

<body>

    <div class="container">

        <h1>Tambah Pelanggan</h1>

        <form
            action="proses_tambah_pelanggan.php"
            method="POST"
        >

            <div class="form-group">

                <label>
                    Nama Pelanggan
                </label>

                <input
                    type="text"
                    name="nama_pelanggan"
                    placeholder="Masukkan nama pelanggan"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    No. HP
                </label>

                <input
                    type="text"
                    name="no_hp"
                    placeholder="Masukkan nomor HP"
                >

            </div>


            <div class="form-group">

                <label>
                    Alamat
                </label>

                <input
                    type="text"
                    name="alamat"
                    placeholder="Masukkan alamat pelanggan"
                >

            </div>


            <button
                type="submit"
                class="btn-simpan"
            >
                Simpan Pelanggan
            </button>

        </form>


        <a
            href="data_pelanggan.php"
            class="btn-kembali"
        >
            ← Kembali
        </a>

    </div>

</body>

</html>