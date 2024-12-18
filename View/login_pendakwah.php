<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SiMuslim Login</title>
  <link rel="stylesheet" href="css/login_pendakwah.css">
</head>
<body>
  <div class="container">
    <div class="form-container">
      <h1 class="title">
        <img src="img/logosimuslim.png" alt="Logo SiMuslim" class="logo">
      </h1>
      <p class="subtitle">Masuk ke akun Anda</p>
      <form action="login_pendakwah.php" method="POST">
        <div class="form-group">
          <input type="text" id="username" name="username" placeholder="Username" required>
          
          <!-- Pesan error jika username tidak ditemukan -->
          <?php if (isset($_GET['error']) && $_GET['error'] == 'Username tidak ditemukan'): ?>
            <p style="color: red; font-size: 14px;">Username tidak ditemukan.</p>
          <?php endif; ?>
        </div>

        <div class="form-group">
          <div style="position: relative;">
            <input type="password" id="password" name="password" placeholder="Password" required style="padding-right: 40px;">
            <!-- Tombol untuk melihat password -->
            <button 
              type="button" 
              onclick="togglePasswordVisibility()" 
              style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 14px;"
            >
              👁️
            </button>
          </div>
          
          <!-- Pesan error jika password salah -->
          <?php if (isset($_GET['error']) && $_GET['error'] == 'Password salah'): ?>
            <p style="color: red; font-size: 14px;">Password salah.</p>
          <?php endif; ?>
        </div>

        <button type="submit" name="login" class="btn">Masuk</button>
      </form>

      <p class="register">
        Belum punya akun? <a href="registrasi_pendakwah.php">Registrasi Pendakwah</a>
      </p>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    // Fungsi untuk melihat/mengubah tipe input password
    function togglePasswordVisibility() {
      const passwordInput = document.getElementById("password");
      const type = passwordInput.type === "password" ? "text" : "password";
      passwordInput.type = type;
    }
  </script>
</body>
</html>

<?php
// Memulai sesi
session_start();

// Cek apakah metode permintaan adalah POST untuk login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Ambil data dari form login
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Koneksi database
    include_once '../controller/config.php'; // File koneksi database

    if ($conn) {
        // Cek apakah username ada di database
        $stmt = $conn->prepare("SELECT * FROM pendakwah WHERE username = ?");
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Verifikasi password
                if (password_verify($password, $user['password'])) {
                    // Jika login berhasil, simpan data sesi
                    $_SESSION['user_logged_in'] = true;
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                    $_SESSION['email'] = $user['email'];

                    // Jika data berhasil dibaca, arahkan ke halaman homependakwah.html
                    header("Location: HOMEPAGE/homependakwah.html");
                    exit();
                } else {
                    // Password salah
                    header("Location: login_pendakwah.php?error=Password salah");
                    exit();
                }
            } else {
                // Username tidak ditemukan
                header("Location: login_pendakwah.php?error=Username tidak ditemukan");
                exit();
            }

            // Tutup statement
            $stmt->close();
        } else {
            // Error pada statement SQL
            die("Error pada statement SQL.");
        }

        // Tutup koneksi
        $conn->close();
    } else {
        // Koneksi database gagal
        die("Koneksi ke database gagal.");
    }
    exit();
}
?>
