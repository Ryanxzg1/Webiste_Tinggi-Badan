<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Realtime Tinggi Badan</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" href="../assets/css/output.css">
</head>
<body class="bg-orange-50 text-gray-800 min-h-screen flex flex-col font-poppins">

  <!-- Navbar -->
  <nav class="bg-white shadow px-6 md:px-24 py-4 flex justify-between items-center">
    <div class="text-xl font-bold text-gray-800 flex items-center gap-2">
      Ryan_Rafif
    </div>
    <ul class="hidden md:flex gap-6 text-sm font-medium">
      <li><a href="../index.php" class="hover:text-orange-600">Home</a></li>
      <li><a href="realtime.php" class="hover:text-orange-600">Real-time Display</a></li>
      <li><a href="../includes/panduan.php" class="hover:text-orange-600">Panduan</a></li>
      <li><a href="../auth/login.php" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm">Login</a></li>
    </ul>
  </nav>

  <!-- Konten Utama -->
  <main class="flex-1 flex items-center justify-center px-4">
    <div class="text-center">
      <h1 class="text-3xl font-bold mb-4">Data Tinggi Badan</h1>
      <div id="tinggi" class="text-7xl font-extrabold text-orange-600">-- cm</div>
      <p class="mt-4 text-gray-500">Data diperbarui secara langsung dari alat pengukur</p>

      <!-- Tombol ON/OFF -->
      <div class="mt-6 flex justify-center gap-4">
        <button id="btnOn" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-md">ON</button>
        <button id="btnOff" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-md">OFF</button>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="text-center text-sm py-4 text-gray-500">
    &copy; <?= date('Y') ?> Ryan_Rafif | Realtime Monitoring
  </footer>

  <!-- WebSocket Script -->
  <script>
    const tinggiElem = document.getElementById('tinggi');
    const btnOn = document.getElementById('btnOn');
    const btnOff = document.getElementById('btnOff');
    const socket = new WebSocket('ws://192.168.43.44:81');
    const channel = new BroadcastChannel('tinggi_channel');

    

    socket.onopen = function () {
      console.log('WebSocket terhubung ke ESP8266');
    };

    socket.onmessage = function (event) {
      const tinggi = parseInt(event.data);
      if (!isNaN(tinggi)) {
        tinggiElem.textContent = `${tinggi} cm`;
      }
    };

    socket.onerror = function (error) {
      console.error('WebSocket error:', error);
    };

    socket.onclose = function () {
      console.warn('Koneksi WebSocket ditutup');
    };

    // Event tombol
    btnOn.addEventListener('click', () => {
      if (socket.readyState === WebSocket.OPEN) {
        socket.send("on");
        console.log("Dikirim: on");
      }
    });

    btnOff.addEventListener('click', () => {
      if (socket.readyState === WebSocket.OPEN) {
        socket.send("off");
        console.log("Dikirim: off");
      }
    });

    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            poppins: ['Poppins', 'sans-serif']
          }
        }
      }
    }
    socket.onmessage = function (event) {
    const tinggi = parseInt(event.data);
    if (!isNaN(tinggi)) {
      tinggiElem.textContent = `${tinggi} cm`;

    // Kirim data tinggi ke halaman lain
    channel.postMessage({ tinggi });
    }
    };
  </script>

</body>
</html>
