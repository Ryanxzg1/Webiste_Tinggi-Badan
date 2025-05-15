<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit();
}

include '../includes/db.php';

$pesan = '';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM tb_pengguna WHERE id = $id");
    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        echo "Data tidak ditemukan.";
        exit();
    }
} else {
    echo "ID tidak valid.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_lengkap'];
    $nip = $_POST['nip'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tinggi = floatval($_POST['tinggi_badan']);
    $berat = floatval($_POST['berat_badan']);

    // Hitung ulang berat ideal dan status
    if ($jenis_kelamin === 'Laki-laki') {
        $ideal = ($tinggi - 100) - (0.10 * ($tinggi - 100));
    } else {
        $ideal = ($tinggi - 100) - (0.15 * ($tinggi - 100));
    }

    $ideal = round($ideal, 2);
    $status = ($berat < $ideal) ? 'Kurus' : (($berat == $ideal) ? 'Ideal' : 'Gemuk');

    // Cek apakah user mengupload foto baru
    $foto = $data['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $fotoBaru = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $folder = '../assets/images/';
        if (move_uploaded_file($tmp, $folder . $fotoBaru)) {
            $foto = $fotoBaru;
        } else {
            $pesan = "❌ Gagal mengupload foto baru.";
        }
    }

    $update = mysqli_query($conn, "UPDATE tb_pengguna SET 
        nama_lengkap = '$nama',
        nip = '$nip',
        jenis_kelamin = '$jenis_kelamin',
        tinggi_badan = $tinggi,
        berat_badan = $berat,
        berat_ideal = $ideal,
        status_berat_badan = '$status',
        foto = '$foto'
        WHERE id = $id");

    if ($update) {
        header('Location: ../dashboard/dashboard_admin.php?status=updated');
        exit();
    } else {
        $pesan = "❌ Gagal memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Data</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/output.css">
</head>
<body class="bg-gray-100 py-8 px-4 font-poppins">
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Edit Data Pengguna</h2>

    <?php if ($pesan): ?>
      <p class="mb-4 text-sm <?= str_contains($pesan, '✅') ? 'text-green-600' : 'text-red-600' ?>">
        <?= $pesan ?>
      </p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="mb-4">
        <label class="block mb-1">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" value="<?= $data['nama_lengkap'] ?>" required class="w-full border px-3 py-2 rounded" />
      </div>
      <div class="mb-4">
        <label class="block mb-1">NIP</label>
        <input type="text" name="nip" value="<?= $data['nip'] ?>" required class="w-full border px-3 py-2 rounded" />
      </div>
      <div class="mb-4">
        <label class="block mb-1">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="w-full border px-3 py-2 rounded">
          <option value="Laki-laki" <?= $data['jenis_kelamin'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
          <option value="Perempuan" <?= $data['jenis_kelamin'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
        </select>
      </div>
      <div class="mb-4">
        <label class="block mb-1">Tinggi Badan (cm)</label>
        <input type="number" name="tinggi_badan" value="<?= $data['tinggi_badan'] ?>" required class="w-full border px-3 py-2 rounded" />
      </div>
      <div class="mb-4">
        <label class="block mb-1">Berat Badan (kg)</label>
        <input type="number" name="berat_badan" value="<?= $data['berat_badan'] ?>" required class="w-full border px-3 py-2 rounded" />
      </div>
      <div class="mb-4">
        <label class="block mb-1">Foto (Opsional jika ingin ganti)</label>
        <input type="file" name="foto" accept="image/*" class="w-full" />
        <p class="text-xs text-gray-500 mt-1">Foto saat ini: <?= $data['foto'] ?></p>
      </div>
      <div class="flex justify-between mt-6">
        <a href="../dashboard/dashboard_admin.php" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 text-sm">
          ← Kembali
        </a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Update
        </button>
      </div>
    </form>
  </div>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            poppins: ['Poppins', 'sans-serif']
          }
        }
      }
    }
  </script>
</body>
</html>
