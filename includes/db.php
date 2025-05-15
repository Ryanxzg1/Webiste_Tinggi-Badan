<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db = "ukk_sija";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect());
}

?>