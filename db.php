<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "perpustakaan";

$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Buat DB jika belum ada
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// Buat tabel users
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
)");

// Buat tabel buku
$conn->query("CREATE TABLE IF NOT EXISTS buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(100),
    pengarang VARCHAR(100),
    tahun INT
)");

// Tambah user admin jika belum ada
$result = $conn->query("SELECT * FROM users WHERE username='admin'");
if ($result->num_rows == 0) {
    $pass = password_hash('123', PASSWORD_DEFAULT);
    $conn->query("INSERT INTO users (username, password) VALUES ('admin', '$pass')");
}
?>
