<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
  header('Location: ../auth/login.php');
  exit();
}

include '../includes/db.php';

$pesan = '';

// ✅ Ambil tinggi terbaru dari tabel data_tinggi
$result = mysqli_query($conn, "SELECT tinggi FROM data_tinggi ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);
$tinggi_terbaru = $row ? $row['tinggi'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama_lengkap'];
  $nip = $_POST['nip'];
  $jenis_kelamin = $_POST['jenis_kelamin'];
  $tinggi = floatval($_POST['tinggi_badan']);
  $berat = floatval($_POST['berat_badan']);

  // Hitung berat badan ideal & status
  if ($jenis_kelamin === 'Laki-laki') {
    $ideal = ($tinggi - 100) - (0.10 * ($tinggi - 100));
  } else {
    $ideal = ($tinggi - 100) - (0.15 * ($tinggi - 100));
  }

  $ideal = round($ideal, 2);

  if ($berat < $ideal) {
    $status = 'Kurus';
  } elseif ($berat == $ideal) {
    $status = 'Ideal';
  } else {
    $status = 'Gemuk';
  }

  // Proses upload foto
  $foto = $_FILES['foto']['name'];
  $tmp = $_FILES['foto']['tmp_name'];
  $folder = '../assets/images/';
  $upload_ok = move_uploaded_file($tmp, $folder . $foto);

  if ($upload_ok) {
    $query = "INSERT INTO tb_pengguna (nama_lengkap, nip, jenis_kelamin, tinggi_badan, berat_badan, berat_ideal, status_berat_badan, foto)
              VALUES ('$nama', '$nip', '$jenis_kelamin', $tinggi, $berat, $ideal, '$status', '$foto')";

    if (mysqli_query($conn, $query)) {
      $pesan = '✅ Data berhasil ditambahkan.';
      header('Location: ../dashboard/dashboard_admin.php');
      exit();
    } else {
      $pesan = '❌ Gagal menyimpan ke database.';
    }
  } else {
    $pesan = '❌ Gagal mengupload foto.';
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Input Data</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-poppins">
  <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-4">Input Data Pengguna</h2>

    <?php if ($pesan): ?>
      <p class="mb-4 text-sm <?= str_contains($pesan, '✅') ? 'text-green-600' : 'text-red-600' ?>">
        <?= $pesan ?>
      </p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label class="block mb-1">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" required class="w-full border px-3 py-2 rounded" />
      </div>
      <div>
        <label class="block mb-1">NIP</label>
        <input type="text" name="nip" required class="w-full border px-3 py-2 rounded" />
      </div>
      <div>
        <label class="block mb-1">Jenis Kelamin</label>
        <select name="jenis_kelamin" required class="w-full border px-3 py-2 rounded">
          <option value="">-- Pilih --</option>
          <option value="Laki-laki">Laki-laki</option>
          <option value="Perempuan">Perempuan</option>
        </select>
      </div>
      <div>
        <label class="block mb-1">Tinggi Badan (cm)</label>
        <div class="flex gap-2">
          <input type="number" id="tinggi_badan" name="tinggi_badan" required class="w-full border px-3 py-2 rounded" />
          <button type="button" id="ambilTinggi" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded">Ambil Data</button>
          <button type="button" id="toggleWS" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded">ON</button>
        </div>

      </div>


      <div>
        <label class="block mb-1">Berat Badan (kg)</label>
        <input type="number" name="berat_badan" required class="w-full border px-3 py-2 rounded" />
      </div>
      <div>
        <label class="block mb-1">Foto</label>
        <input type="file" name="foto" accept="image/*" required class="w-full" />
      </div>
      <div class="flex justify-between mt-6">
        <a href="../dashboard/dashboard_admin.php" class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 text-sm">
          ← Kembali
        </a>
        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">
          Simpan
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

<script>
  let socket;
  let latestTinggi = null;
  let wsAktif = false;

  function setupWebSocket() {
    socket = new WebSocket("ws://192.168.43.44:81");

    socket.onopen = function () {
      console.log("WebSocket Terhubung ke ESP8266");
      if (wsAktif) socket.send("on");
    };

    socket.onmessage = function (event) {
      console.log("Data diterima dari ESP:", event.data);
      const tinggi = parseInt(event.data);
      if (!isNaN(tinggi)) {
        latestTinggi = tinggi;
      }
    };

    socket.onclose = function () {
      console.warn("WebSocket terputus.");
    };

    socket.onerror = function (error) {
      console.error("WebSocket error:", error);
    };
  }

  document.addEventListener("DOMContentLoaded", function () {
    setupWebSocket();

    const ambilBtn = document.getElementById("ambilTinggi");
    const toggleBtn = document.getElementById("toggleWS");

    ambilBtn.addEventListener("click", () => {
      if (latestTinggi !== null) {
        document.getElementById("tinggi_badan").value = latestTinggi;
      } else {
        alert("Belum ada data tinggi dari ESP8266.");
      }
    });

    toggleBtn.addEventListener("click", () => {
      if (!socket || socket.readyState !== WebSocket.OPEN) {
        alert("WebSocket belum siap. Coba refresh halaman.");
        return;
      }

      if (!wsAktif) {
        socket.send("on");
        wsAktif = true;
        toggleBtn.textContent = "OFF";
        toggleBtn.classList.replace("bg-gray-500", "bg-green-500");
        toggleBtn.classList.replace("hover:bg-gray-600", "hover:bg-green-600");
      } else {
        socket.send("off");
        wsAktif = false;
        toggleBtn.textContent = "ON";
        toggleBtn.classList.replace("bg-green-500", "bg-gray-500");
        toggleBtn.classList.replace("hover:bg-green-600", "hover:bg-gray-600");
      }
    });
  });
</script>



</body>
</html>
