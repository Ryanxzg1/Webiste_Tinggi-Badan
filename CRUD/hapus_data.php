<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit();
}

include '../includes/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil nama file foto sebelum dihapus
    $fotoQuery = mysqli_query($conn, "SELECT foto FROM tb_pengguna WHERE id = $id");
    if ($fotoQuery && mysqli_num_rows($fotoQuery) > 0) {
        $fotoRow = mysqli_fetch_assoc($fotoQuery);
        $fotoPath = '../assets/images/' . $fotoRow['foto'];

        // Hapus data dari database
        $delete = mysqli_query($conn, "DELETE FROM tb_pengguna WHERE id = $id");
        if ($delete) {
            // Hapus foto dari folder jika ada
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
            header('Location: ../dashboard/dashboard_admin.php?status=sukses');
            exit();
        } else {
            echo "Gagal menghapus data.";
        }
    } else {
        echo "Data tidak ditemukan.";
    }
} else {
    echo "ID tidak valid.";
}
?>
