<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "toko_hp";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if(!$koneksi) {
    die("Gagal Terkoneksi");
}
