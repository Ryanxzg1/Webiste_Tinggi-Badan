<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Panduan</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/output.css">
</head>
<body class="bg-gray-50 text-gray-800 font-poppins ">

  <!-- Navbar -->
 <nav class="bg-white shadow px-6 md:px-24 py-4 flex justify-between items-center">
    <div class="text-xl font-bold text-gray-800 flex items-center gap-2">
      Ryan_Rafif
    </div>
    <ul class="hidden md:flex gap-6 text-sm font-medium">
      <li><a href="../index.php" class="hover:text-orange-600">Home</a></li>
      <!-- <li><a href="../realtime/realtime.php" class="hover:text-orange-600">Real-time Display</a></li> -->
      <li><a href="../includes/panduan.php" class="hover:text-orange-600">Panduan</a></li>
      <li><a href="../auth/login.php" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm">Login</a></li>
    </ul>
  </nav>

  <!-- Main Content -->
  <div class="max-w-4xl mx-auto mt-7 bg-white p-6 rounded-lg shadow text-center">
    <h2 class="text-2xl font-semibold mb-4">Panduan Penggunaan Alat Ukur Tinggi Badan</h2>
    
    <!-- PDF Embed -->
    <iframe src="panduan.pdf" width="100%" height="600px"></iframe>
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
