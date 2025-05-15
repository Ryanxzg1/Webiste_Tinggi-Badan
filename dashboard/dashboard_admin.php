<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
  header('Location: ../auth/login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/output.css">
  <style>
  /* Styling for the popup modal */
  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
  }
  .modal-content {
    margin: 15% auto;
    display: block;
    width: 80%;
    max-width: 700px;
  }
  .close {
    color: white;
    font-size: 30px;
    font-weight: bold;
    position: absolute;
    top: 20px;
    right: 20px;
    
    padding: 10px 15px;
    border-radius: 50%;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
</style>
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
    <h1 class="text-3xl font-bold mb-1">Admin Dashboard</h1>
    <p class="text-gray-500 mb-6">
      Pantau seluruh data pengguna yang tercatat dari alat ukur tinggi badan otomatis, termasuk perhitungan berat badan ideal dan status tubuh (kurus, ideal, gemuk). Kendalikan dan evaluasi kinerja sistem dari satu panel kontrol pusat yang terintegrasi.
    </p>

    <!-- User Management -->
    <div class="bg-white shadow rounded-xl p-4">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold">Data Management</h3>
        <div class="flex gap-2">
          <a href="../CRUD/input_data.php" class="text-sm border px-3 py-1 rounded-md hover:bg-gray-100">Input Data</a>
        </div>
      </div>

      <table class="w-full text-sm text-left border">
        <thead class="bg-gray-100 text-gray-600">
          <tr>
            <th class="py-2 px-4">Nama</th>
            <th class="py-2 px-4">NIP</th>
            <th class="py-2 px-4">Jenis Kelamin</th>
            <th class="py-2 px-4">Foto</th>
            <th class="py-2 px-4">Status Berat</th>
            <th class="py-2 px-4">Aksi</th>
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
                <td class='py-2 px-4'>{$row['nama_lengkap']}</td>
                <td class='py-2 px-4'>{$row['nip']}</td>
                <td class='py-2 px-4'>{$row['jenis_kelamin']}</td>
                <td class='py-2 px-4'>
                  <img src='../assets/images/{$row['foto']}' alt='Foto' class='w-16 h-16 object-cover rounded-full cursor-pointer' onclick='openModal(\"../assets/images/{$row['foto']}\")' />
                </td>
                <td class='py-2 px-4'>
                  <span class='font-semibold " . 
                    ($row['status_berat_badan'] === 'Ideal' ? 'text-green-600' : 
                      ($row['status_berat_badan'] === 'Kurus' ? 'text-yellow-500' : 'text-red-600')) . "'>
                    {$row['status_berat_badan']}
                  </span>
                </td>
                <td class='py-2 px-4'>
                  <a href='../CRUD/update_data.php?id={$row['id']}' class='text-blue-600 hover:underline'> Edit </a> | 
                  <a href='../CRUD/hapus_data.php?id={$row['id']}' class='text-red-600 hover:underline' onclick=\"return confirm('Yakin hapus data?');\"> Hapus </a>
                </td>
              </tr>";
            }
          } else {
            echo "<tr><td colspan='6' class='py-4 text-center text-gray-500'>Data belum tersedia.</td></tr>";
          }
          ?>
        </tbody>
      </table>

      <?php
      // Optional: menampilkan total data
      $total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_pengguna");
      $jumlah = mysqli_fetch_assoc($total)['total'];
      ?>
      <p class="text-sm text-gray-500 mt-2">Showing 1–<?= $jumlah ?> of <?= $jumlah ?> data</p>
    </div>
  </div>

  <!-- Modal for Image -->
  <div id="myModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="img01" />
  </div>

  <script>
  function openModal(imgPath) {
    var modal = document.getElementById("myModal");
    var img = document.getElementById("img01");
    modal.style.display = "block";
    img.src = imgPath;
  }

  function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
  }

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
