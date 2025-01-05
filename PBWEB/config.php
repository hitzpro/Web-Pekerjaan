<?php
$servername = "localhost";
$username = "root";
$password = ""; // password kosong
$dbname = "nama_database"; // ganti dengan nama database yang sesuai

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}
echo "Koneksi berhasil!";
?>
