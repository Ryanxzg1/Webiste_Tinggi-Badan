<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'user') {
  header('Location: ../auth/login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/output.css">
</head>
<body class="bg-gray-50 text-gray-800 font-poppins">
  <nav class="bg-white shadow px-6 md:px-24 py-4 flex justify-between items-center">
    <div class="text-xl font-bold text-gray-800 flex items-center gap-2">
      Ryan_Rafif
    </div>
    <ul class="hidden md:flex gap-6 text-sm font-medium">
      <li><a href="../index.php" class="hover:text-orange-600">Home</a></li>
      <!-- <li><a href="../realtime/realtime.php" class="hover:text-orange-600">Real-time Display</a></li> -->
      <li><a href="../includes/panduan.php" class="hover:text-orange-600">Panduan</a></li>
      <li><a href="../auth/logout.php" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm">Logout</a></li>
    </ul>
  </nav>

  <div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-1">User Dashboard</h1>
    <p class="text-gray-500 mb-6">
      Lihat hasil pengukuran tinggi dan berat badan Anda secara otomatis, serta ketahui status tubuh Anda berdasarkan perhitungan berat badan ideal. Data Anda tercatat dengan aman dan dapat diakses kapan saja.
    </p>

    <!-- Data Display Only -->
    <div class="bg-white shadow rounded-xl p-4">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Data Pengguna</h3>
      </div>

      <table class="w-full text-sm text-left border">
        <thead class="bg-gray-100 text-gray-600">
          <tr>
            <th class="py-2 px-4">Nama</th>
            <th class="py-2 px-4">NIP</th>
            <th class="py-2 px-4">Jenis Kelamin</th>
            <th class="py-2 px-4">Foto</th>
            <th class="py-2 px-4">Status Berat</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include '../includes/db.php';

          $query = "SELECT * FROM tb_pengguna ORDER BY id DESC";
          $result = mysqli_query($conn, $query);

          if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr class='border-b'>
                <td class='py-2 px-4'>" . htmlspecialchars($row['nama_lengkap']) . "</td>
                <td class='py-2 px-4'>" . htmlspecialchars($row['nip']) . "</td>
                <td class='py-2 px-4'>" . htmlspecialchars($row['jenis_kelamin']) . "</td>
                <td class='py-2 px-4'>
                  <img src='../assets/images/" . htmlspecialchars($row['foto']) . "' alt='Foto' class='w-12 h-12 object-cover rounded-full' />
                </td>
                <td class='py-2 px-4'>
                  <span class='font-semibold " .
                    ($row['status_berat_badan'] === 'Ideal' ? 'text-green-600' :
                      ($row['status_berat_badan'] === 'Kurus' ? 'text-yellow-500' : 'text-red-600')) . "'>
                    {$row['status_berat_badan']}
                  </span>
                </td>
              </tr>";
            }
          } else {
            echo "<tr><td colspan='5' class='py-4 text-center text-gray-500'>Data belum tersedia.</td></tr>";
          }
          ?>
        </tbody>
      </table>

      <?php
      $total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_pengguna");
      $jumlah = mysqli_fetch_assoc($total)['total'];
      ?>
      <p class="text-sm text-gray-500 mt-2">Showing 1–<?= $jumlah ?> of <?= $jumlah ?> data</p>
    </div>
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
