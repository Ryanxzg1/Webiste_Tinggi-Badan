  <!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Alat Ukur Tinggi Badan</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/output.css">
</head>
<body class="bg-orange-50 text-gray-800 font-poppins">

  <!-- Navbar -->
  <nav class="bg-white shadow px-6 md:px-24 py-4 flex justify-between items-center">
    <div class="text-xl font-bold text-gray-800 flex items-center gap-2">
      Ryan_Rafif
    </div>
    <ul class="hidden md:flex gap-6 text-sm font-medium">
      <li><a href="index.php" class="hover:text-orange-600">Home</a></li>
      <!-- <li><a href="realtime/realtime.php" class="hover:text-orange-600">Real-time Display</a></li> -->
      <li><a href="includes/panduan.php" class="hover:text-orange-600">Panduan</a></li>
      <li><a href="auth/login.php" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm">Login</a></li>
    </ul>
  </nav>

  <!-- Hero Section -->
  <section class="min-h-[80dvh] flex items-center justify-center px-6 md:px-12">
    <div class="flex flex-col-reverse md:flex-row items-center justify-between max-w-7xl w-full gap-12">
      
      <!-- Text -->
      <div class="max-w-xl text-center md:text-left">
        <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
          Welcome to <span class="text-orange-600">Alat Ukur Tinggi Badan</span>
        </h1>
        <p class="text-lg text-gray-700 mb-1">
          by <span class="text-orange-600 font-semibold">Ryan_Rafif</span>
        </p>
        <p class="text-base text-gray-600 mb-6">
        Rasakan pengukuran tinggi badan secara real-time dengan solusi Produk IoT Alat Ukur Tinggi Badan.
        Lacak pengukuran Anda, analisis status tubuh ideal Anda, dan rasakan manfaatnya.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
          <a href="auth/login.php" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg text-sm">Get Started</a>
          <a href="includes/panduan.php" class="border border-orange-500 text-orange-500 hover:bg-orange-100 px-5 py-2 rounded-lg text-sm">Learn More</a>
        </div>
      </div>

      <!-- Image -->
      <div class="max-w-md w-full">
        <img src="assets/images/foto-1.jpg" alt="IoT Illustration" class="w-full rounded-xl shadow-lg" />
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center text-sm py-6 text-gray-500">
    &copy; <?= date('Y') ?> Ryan_Rafif | SMKN 2 KLATEN | Sistem Pengukur Tinggi Badan IoT
  </footer>

  <!-- File JavaScript -->
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
