<?php
// proses_simpan_transaksi.php

session_start();
include 'includes/cek_session.php';
include 'config/koneksi.php';

if (empty($_SESSION['keranjang'])) {
    $_SESSION['pesan_error'] = 'Keranjang masih kosong!';
    header('Location: transaksi.php');
    exit;
}

$id_kasir = $_SESSION['id_user'];

$id_pelanggan = !empty($_POST['id_pelanggan'])
    ? (int) $_POST['id_pelanggan']
    : null;

$id_pelanggan_sql = ($id_pelanggan === null)
    ? 'NULL'
    : "'$id_pelanggan'";

$no_transaksi = 'TRX-' . date('YmdHis');
$tanggal = date('Y-m-d H:i:s');
$total = 0;

foreach ($_SESSION['keranjang'] as $item) {
    $total += $item['subtotal'];
}

$sql = "INSERT INTO tbl_transaksi
        (no_transaksi, tanggal, id_kasir, id_pelanggan, total_bayar)
        VALUES
        ('$no_transaksi', '$tanggal', '$id_kasir', $id_pelanggan_sql, '$total')";

mysqli_query($koneksi, $sql);

$id_transaksi = mysqli_insert_id($koneksi);

foreach ($_SESSION['keranjang'] as $id_barang => $item) {
    $jumlah = $item['jumlah'];
    $subtotal = $item['subtotal'];

    $detail = "INSERT INTO tbl_detail_transaksi
                (id_transaksi, id_barang, jumlah, subtotal)
                VALUES
                ('$id_transaksi', '$id_barang', '$jumlah', '$subtotal')";

    mysqli_query($koneksi, $detail);

    $update_stok = "UPDATE tbl_barang
                    SET stok = stok - $jumlah
                    WHERE id_barang = '$id_barang'";

    mysqli_query($koneksi, $update_stok);
}

$waktu = date('Y-m-d H:i:s');
$aktivitas = "Transaksi: $no_transaksi";

$log = "INSERT INTO tbl_log
        (id_user, aktivitas, waktu)
        VALUES
        ('$id_kasir', '$aktivitas', '$waktu')";

mysqli_query($koneksi, $log);

unset($_SESSION['keranjang']);

header('Location: riwayat_transaksi.php');
exit;
?>