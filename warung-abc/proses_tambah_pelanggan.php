<?php
// proses_tambah_pelanggan.php

session_start();
include 'includes/cek_session.php';
include 'config/koneksi.php';

$nama = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
$hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

$sql = "INSERT INTO tbl_pelanggan (nama_pelanggan, no_hp, alamat)
        VALUES ('$nama', '$hp', '$alamat')";

if (mysqli_query($koneksi, $sql)) {
    $id_user = $_SESSION['id_user'];
    $waktu = date('Y-m-d H:i:s');
    $aktivitas = "Tambah pelanggan: $nama";

    $log = "INSERT INTO tbl_log (id_user, aktivitas, waktu)
            VALUES ('$id_user', '$aktivitas', '$waktu')";

    mysqli_query($koneksi, $log);

    header('Location: data_pelanggan.php');
    exit;
} else {
    echo "Gagal menyimpan data: " . mysqli_error($koneksi);
}
?>