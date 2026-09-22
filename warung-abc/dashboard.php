<?php
include 'includes/cek_session.php';
include 'config/koneksi.php';

$bulan_sekarang = date('Y-m');

$sql_omset = "SELECT SUM(total_bayar) AS omset
                FROM tbl_transaksi
                WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$bulan_sekarang'";

$query_omset = mysqli_query($koneksi, $sql_omset);
$data_omset = mysqli_fetch_assoc($query_omset);

$omset_bulanan = $data_omset['omset'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Warung ABC</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }


        /* =========================================
            BODY
        ========================================= */

        body {
            background:
                radial-gradient(
                    circle at 15% 15%,
                    rgba(37, 99, 235, 0.15),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 85% 85%,
                    rgba(59, 130, 246, 0.12),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #f8faff,
                    #eef3f9
                );

            color: #1f2937;

            min-height: 100vh;
        }


        /* =========================================
            SIDEBAR
        ========================================= */

        .sidebar {
            position: fixed;

            left: 0;
            top: 0;

            width: 260px;
            height: 100vh;

            background: linear-gradient(
                180deg,
                #e77fb3,
                #e75e8c
            );

            color: white;

            padding: 25px 18px;

            box-shadow:
                5px 0 25px rgba(0, 0, 0, 0.12);

            z-index: 100;
        }


        /* =========================================
            LOGO
        ========================================= */

        .logo {
            display: flex;

            align-items: center;

            gap: 12px;

            padding: 5px 10px 30px;

            border-bottom:
                1px solid rgba(255,255,255,0.15);
        }

        .logo-icon {
            width: 45px;
            height: 45px;

            background:
                rgba(255,255,255,0.15);

            border-radius: 12px;

            display: flex;

            justify-content: center;
            align-items: center;

            font-size: 24px;
        }

        .logo h2 {
            font-size: 21px;
        }

        .logo small {
            display: block;

            color: #bfdbfe;

            font-size: 11px;

            margin-top: 3px;
        }


        /* =========================================
            PROFILE
        ========================================= */

        .profile {
            margin: 25px 5px;

            padding: 15px;

            background:
                rgba(255,255,255,0.10);

            border-radius: 12px;

            display: flex;

            align-items: center;

            gap: 12px;
        }

        .profile-icon {
            width: 42px;
            height: 42px;

            background: white;

            color: #1e3a8a;

            border-radius: 50%;

            display: flex;

            justify-content: center;
            align-items: center;

            font-size: 20px;
        }

        .profile-info strong {
            display: block;

            font-size: 14px;
        }

        .profile-info span {
            display: block;

            color: #bfdbfe;

            font-size: 12px;

            margin-top: 4px;
        }


        /* =========================================
            MENU
        ========================================= */

        .menu-title {
            color: #93c5fd;

            font-size: 11px;

            font-weight: bold;

            margin: 25px 10px 10px;

            text-transform: uppercase;

            letter-spacing: 1px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            margin-bottom: 7px;
        }

        .sidebar a {
            display: flex;

            align-items: center;

            gap: 13px;

            padding: 13px 14px;

            color: #e0e7ff;

            text-decoration: none;

            border-radius: 10px;

            font-size: 14px;

            transition: 0.3s;
        }

        .sidebar a:hover {
            background:
                rgba(255,255,255,0.12);

            color: white;

            transform:
                translateX(4px);
        }

        .menu-icon {
            width: 25px;

            text-align: center;

            font-size: 18px;
        }


        /* =========================================
           CONTENT
        ========================================= */

        .content {
            margin-left: 260px;

            padding: 30px;

            min-height: 100vh;
        }


        /* =========================================
           TOPBAR
        ========================================= */

        .topbar {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 20px;
        }

        .topbar h1 {
            color: #111827;

            font-size: 26px;
        }

        .topbar p {
            color: #6b7280;

            margin-top: 5px;

            font-size: 13px;
        }

        .date {
            background: white;

            padding: 10px 15px;

            border-radius: 10px;

            box-shadow:
                0 8px 20px rgba(0,0,0,0.07);

            color: #555;

            font-size: 13px;
        }


        /* =========================================
           WELCOME
        ========================================= */

        .welcome-card {
            background:
                linear-gradient(
                    135deg,
                     #e77fb3,
                    #e75e8c
                );

            color: white;

            border-radius: 14px;

            padding: 20px 24px;

            position: relative;

            overflow: hidden;

            margin-bottom: 18px;

            box-shadow:
                0 10px 30px
                rgba(30,58,138,0.20);
        }

        .welcome-card::after {
            content: "🛒";

            position: absolute;

            right: 35px;
            top: 5px;

            font-size: 80px;

            opacity: 0.07;
        }

        .welcome-card h2 {
            font-size: 18px;

            margin-bottom: 5px;
        }

        .welcome-card p {
            color: #dbeafe;

            font-size: 12px;
        }


        /* =========================================
           OMSET BULANAN
        ========================================= */

        .omset-card {
            background:
                linear-gradient(
                    135deg,
                    #e62f93,
                   #e62f93
                );

            color: white;

            border-radius: 12px;

            padding: 15px 19px;

            margin-bottom: 18px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            box-shadow:
                0 10px 25px
                rgba(22,163,74,0.18);

            transition: 0.3s;
        }

        .omset-card:hover {
            transform: translateY(-2px);

            box-shadow:
                0 14px 30px
                rgba(22,163,74,0.23);
        }

        .omset-info small {
            display: block;

            color: #dcfce7;

            font-size: 10px;

            font-weight: bold;

            letter-spacing: 0.5px;

            margin-bottom: 4px;
        }

        .omset-info h2 {
            font-size: 20px;
        }

        .omset-info p {
            color: #bbf7d0;

            font-size: 10px;

            margin-top: 3px;
        }

        .omset-icon {
            width: 40px;
            height: 40px;

            background:
                rgba(255,255,255,0.15);

            border-radius: 10px;

            display: flex;

            justify-content: center;
            align-items: center;

            font-size: 20px;
        }


        /* =========================================
           STATISTIK
        ========================================= */

        .stats {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 15px;

            margin-bottom: 20px;
        }

        .stat-card {
            background: white;

            padding: 16px;

            border-radius: 12px;

            box-shadow:
                0 10px 25px
                rgba(0,0,0,0.07);

            display: flex;

            align-items: center;

            gap: 12px;

            transition: 0.3s;
        }

        .stat-card:hover {
            transform:
                translateY(-4px);

            box-shadow:
                0 15px 30px
                rgba(0,0,0,0.10);
        }

        .stat-icon {
            width: 45px;
            height: 45px;

            border-radius: 11px;

            display: flex;

            justify-content: center;
            align-items: center;

            font-size: 20px;
        }

        .blue {
            background: #dbeafe;
        }

        .green {
            background: #dcfce7;
        }

        .orange {
            background: #ffedd5;
        }

        .purple {
            background: #f3e8ff;
        }

        .stat-info small {
            color: #6b7280;

            font-size: 11px;
        }

        .stat-info h3 {
            margin-top: 4px;

            font-size: 18px;

            color: #111827;
        }


        /* =========================================
           BOTTOM
        ========================================= */

        .bottom {
            display: grid;

            grid-template-columns: 2fr 1fr;

            gap: 18px;
        }

        .card {
            background: white;

            border-radius: 12px;

            padding: 20px;

            box-shadow:
                0 10px 25px
                rgba(0,0,0,0.07);
        }

        .card-title {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 18px;
        }

        .card-title h3 {
            font-size: 17px;

            color: #111827;
        }

        .card-title span {
            font-size: 11px;

            color: #6b7280;
        }


        /* =========================================
           QUICK MENU
        ========================================= */

        .quick-menu {
            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 10px;
        }

        .quick-menu a {
            padding: 15px;

            border: 1px solid #e5e7eb;

            border-radius: 10px;

            text-decoration: none;

            color: #374151;

            transition: 0.3s;
        }

        .quick-menu a:hover {
            border-color:   #e62f93;

            background: #eff6ff;

            color:   #e62f93;

            transform:
                translateY(-2px);
        }

        .quick-menu .icon {
            font-size: 22px;

            margin-bottom: 6px;
        }

        .quick-menu strong {
            display: block;

            font-size: 13px;
        }

        .quick-menu small {
            color: #6b7280;

            font-size: 10px;
        }


        /* =========================================
           ACCOUNT
        ========================================= */

        .account-box {
            text-align: center;
        }

        .account-avatar {
            width: 65px;
            height: 65px;

            margin: 5px auto 12px;

            border-radius: 50%;

            background: #dbeafe;

            color: #1e3a8a;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 28px;
        }

        .account-box h3 {
            margin-bottom: 5px;

            font-size: 16px;
        }

        .account-box p {
            color: #6b7280;

            font-size: 12px;

            margin-bottom: 17px;
        }

        .logout {
            display: block;

            background: #dc2626;

            color: white;

            padding: 10px;

            border-radius: 9px;

            text-decoration: none;

            font-size: 13px;

            transition: 0.3s;
        }

        .logout:hover {
            background: #b91c1c;
        }


        /* =========================================
           RESPONSIVE
        ========================================= */

        @media (max-width: 1000px) {

            .stats {
                grid-template-columns:
                    repeat(2, 1fr);
            }

            .bottom {
                grid-template-columns: 1fr;
            }
        }


        @media (max-width: 700px) {

            .sidebar {
                width: 75px;

                padding: 20px 10px;
            }

            .logo {
                justify-content: center;

                padding-bottom: 20px;
            }

            .logo h2,
            .logo small,
            .profile-info,
            .menu-title {
                display: none;
            }

            .profile {
                justify-content: center;

                padding: 10px;
            }

            .sidebar a {
                justify-content: center;

                padding: 13px 5px;
            }

            .sidebar a span:not(.menu-icon) {
                display: none;
            }

            .content {
                margin-left: 75px;

                padding: 20px;
            }

            .topbar {
                display: block;
            }

            .date {
                display: inline-block;

                margin-top: 10px;
            }
        }


        @media (max-width: 500px) {

            .stats {
                grid-template-columns: 1fr;
            }

            .quick-menu {
                grid-template-columns: 1fr;
            }

            .welcome-card h2 {
                font-size: 17px;
            }

            .topbar h1 {
                font-size: 22px;
            }

            .omset-card {
                padding: 14px 16px;
            }

            .omset-info h2 {
                font-size: 18px;
            }
        }

    </style>

</head>


<body>


<!-- =========================================
     SIDEBAR
========================================= -->

<div class="sidebar">


    <!-- LOGO -->

    <div class="logo">

        <div class="logo-icon">
            🛒
        </div>

        <div>

            <h2>
                Warung ABC
            </h2>

            <small>
                Kasir Management
            </small>

        </div>

    </div>


    <!-- PROFILE -->

    <div class="profile">

        <div class="profile-icon">
            👤
        </div>

        <div class="profile-info">

            <strong>
                <?php
                echo htmlspecialchars(
                    $_SESSION['nama_lengkap']
                );
                ?>
            </strong>

            <span>
                <?php
                echo htmlspecialchars(
                    $_SESSION['role']
                );
                ?>
            </span>

        </div>

    </div>


    <!-- MENU -->

    <div class="menu-title">
        Menu Utama
    </div>


    <ul>


        <?php if (
            $_SESSION['role'] == "admin" ||
            $_SESSION['role'] == "gudang"
        ) { ?>


            <li>

                <a href="data_barang.php">

                    <span class="menu-icon">
                        📦
                    </span>

                    <span>
                        Data Barang
                    </span>

                </a>

            </li>


            <li>

                <a href="data_pelanggan.php">

                    <span class="menu-icon">
                        👥
                    </span>

                    <span>
                        Data Pelanggan
                    </span>

                </a>

            </li>


        <?php } ?>


        <?php if (
            $_SESSION['role'] == "admin" ||
            $_SESSION['role'] == "kasir"
        ) { ?>


            <li>

                <a href="transaksi.php">

                    <span class="menu-icon">
                        💰
                    </span>

                    <span>
                        Transaksi Kasir
                    </span>

                </a>

            </li>


            <li>

                <a href="riwayat_transaksi.php">

                    <span class="menu-icon">
                        📋
                    </span>

                    <span>
                        Riwayat Transaksi
                    </span>

                </a>

            </li>


            <li>

                <a href="laporan_harian.php">

                    <span class="menu-icon">
                        📅
                    </span>

                    <span>
                        Laporan Harian
                    </span>

                </a>

            </li>


            <li>

                <a href="laporan_bulanan.php">

                    <span class="menu-icon">
                        📊
                    </span>

                    <span>
                        Laporan Bulanan
                    </span>

                </a>

            </li>


        <?php } ?>


    </ul>

</div>


<!-- =========================================
     CONTENT
========================================= -->

<div class="content">


    <!-- TOP BAR -->

    <div class="topbar">

        <div>

            <h1>
                Dashboard
            </h1>

            <p>
                Selamat datang kembali di sistem Warung ABC.
            </p>

        </div>


        <div class="date">

            📅

            <?php
            echo date('d M Y');
            ?>

        </div>

    </div>


    <!-- =========================================
         WELCOME
    ========================================= -->

    <div class="welcome-card">

        <h2>

            Halo,
            <?php
            echo htmlspecialchars(
                $_SESSION['nama_lengkap']
            );
            ?>

            👋

        </h2>


        <p>

            Anda login sebagai

            <strong>

                <?php
                echo htmlspecialchars(
                    $_SESSION['role']
                );
                ?>

            </strong>.

            Selamat bekerja!

        </p>

    </div>


    <!-- =========================================
         OMSET BULANAN
    ========================================= -->

    <div class="omset-card">

        <div class="omset-info">

            <small>
                OMSET BULAN INI
            </small>

            <h2>

                Rp
                <?php
                echo number_format(
                    $omset_bulanan,
                    0,
                    ',',
                    '.'
                );
                ?>

            </h2>

            <p>

                Total pendapatan bulan
                <?php
                echo date('F Y');
                ?>

            </p>

        </div>


        <div class="omset-icon">
            💰
        </div>

    </div>


    <!-- =========================================
         STATISTIK
    ========================================= -->

    <div class="stats">


        <div class="stat-card">

            <div class="stat-icon blue">
                📦
            </div>

            <div class="stat-info">

                <small>
                    Data Barang
                </small>

                <h3>
                    -
                </h3>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon green">
                👥
            </div>

            <div class="stat-info">

                <small>
                    Pelanggan
                </small>

                <h3>
                    -
                </h3>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon orange">
                💰
            </div>

            <div class="stat-info">

                <small>
                    Transaksi
                </small>

                <h3>
                    -
                </h3>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon purple">
                📋
            </div>

            <div class="stat-info">

                <small>
                    Riwayat
                </small>

                <h3>
                    -
                </h3>

            </div>

        </div>


    </div>


    <!-- =========================================
         BAGIAN BAWAH
    ========================================= -->

    <div class="bottom">


        <!-- MENU CEPAT -->

        <div class="card">

            <div class="card-title">

                <h3>
                    Menu Cepat
                </h3>

                <span>
                    Akses cepat
                </span>

            </div>


            <div class="quick-menu">


                <?php if (
                    $_SESSION['role'] == "admin" ||
                    $_SESSION['role'] == "gudang"
                ) { ?>


                    <a href="data_barang.php">

                        <div class="icon">
                            📦
                        </div>

                        <strong>
                            Data Barang
                        </strong>

                        <small>
                            Kelola stok barang
                        </small>

                    </a>


                    <a href="data_pelanggan.php">

                        <div class="icon">
                            👥
                        </div>

                        <strong>
                            Data Pelanggan
                        </strong>

                        <small>
                            Kelola pelanggan
                        </small>

                    </a>


                <?php } ?>


                <?php if (
                    $_SESSION['role'] == "admin" ||
                    $_SESSION['role'] == "kasir"
                ) { ?>


                    <a href="transaksi.php">

                        <div class="icon">
                            💰
                        </div>

                        <strong>
                            Transaksi Kasir
                        </strong>

                        <small>
                            Buat transaksi baru
                        </small>

                    </a>


                    <a href="riwayat_transaksi.php">

                        <div class="icon">
                            📋
                        </div>

                        <strong>
                            Riwayat Transaksi
                        </strong>

                        <small>
                            Lihat transaksi
                        </small>

                    </a>


                    <a href="laporan_harian.php">

                        <div class="icon">
                            📅
                        </div>

                        <strong>
                            Laporan Harian
                        </strong>

                        <small>
                            Lihat laporan penjualan harian
                        </small>

                    </a>


                    <a href="laporan_bulanan.php">

                        <div class="icon">
                            📊
                        </div>

                        <strong>
                            Laporan Bulanan
                        </strong>

                        <small>
                            Lihat laporan penjualan bulanan
                        </small>

                    </a>


                <?php } ?>


            </div>

        </div>


        <!-- AKUN -->

        <div class="card account-box">

            <div class="card-title">

                <h3>
                    Akun
                </h3>

            </div>


            <div class="account-avatar">
                👤
            </div>


            <h3>

                <?php
                echo htmlspecialchars(
                    $_SESSION['nama_lengkap']
                );
                ?>

            </h3>


            <p>

                Login sebagai

                <strong>

                    <?php
                    echo htmlspecialchars(
                        $_SESSION['role']
                    );
                    ?>

                </strong>

            </p>


            <a
                href="logout.php"
                class="logout"
            >
                🚪 Logout
            </a>


        </div>


    </div>


</div>


</body>

</html>