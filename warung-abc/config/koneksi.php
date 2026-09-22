<?php
$host ='localhost';
$user ='root';
$password ='';
$database ='warung-abc';

$koneksi = mysqli_connect($host, $user, $password, $database);
if(!$koneksi) {
    die('koneksi database gagal:'.mysqli_connect_error());
}
?>