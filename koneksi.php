<?php
$host = "43.156.249.217";
$user = "root";
$pass = "b4IynNkgjSvExV3t8p0o67K9zDGJ5M21";
$name = "skripsi";
$port = 30527; // ⬅️ tambahkan ini

$koneksi = mysqli_connect($host, $user, $pass, $name, $port);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
