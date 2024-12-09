<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SiMuslim - Registrasi User</title>
  <link rel="stylesheet" href="css/registrasi_user.css">
</head>
<body>
  <div class="container">
    <div class="form-container">
      <h1 class="title">
        <img src="img/logosimuslim.png" alt="Logo SiMuslim" class="logo-img">
      </h1>
      <p class="subtitle">Registrasi Pengguna</p>
      
      <form action="#" method="POST" enctype="multipart/form-data">
        <!-- Nama Lengkap -->
        <div class="form-group">
          <input type="text" id="username" name="username" placeholder="Username" required>
        </div>

        <!-- Email -->
        <div class="form-group">
          <input type="email" id="email" name="email" placeholder="Email" required>
        </div> 

        <!-- Password -->
        <div class="form-group">
          <input type="password" id="password" name="password" placeholder="Password" required>
        </div>

        <!-- Konfirmasi Password dengan mata -->
        <div class="form-group password-group">
          <input 
            type="password" 
            id="confirm-password" 
            name="confirm-password" 
            placeholder="Konfirmasi Password" 
            required
          >
          <button 
            type="button" 
            onclick="toggleConfirmPassword()" 
            class="eye-button"
          >
            👁️
          </button>
        </div>

        <!-- Tombol Kirim -->
        <button type="submit" class="btn">Kirim</button>
      </form>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    function toggleConfirmPassword() {
      const confirmPasswordInput = document.getElementById("confirm-password");
      const type = confirmPasswordInput.type === "password" ? "text" : "password";
      confirmPasswordInput.type = type;
    }
  </script>
</body>
</html>

<?php
// Koneksi ke database
$host = "localhost"; // Ganti jika menggunakan host berbeda
$user = "root";      // Username MySQL
$password = "";      // Password MySQL
$dbname = "simuslim";

$conn = new mysqli($host, $user, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Validasi: Periksa jika password cocok
    if ($password !== $confirm_password) {
        echo "Password tidak cocok!";
        exit;
    }

    // Hash password untuk keamanan
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Masukkan data ke database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
      // Registrasi berhasil, redirect ke login_user.php
      header("Location: login_user.php");
      exit;
  } else {
      echo "Error: " . $stmt->error;
  }

    $stmt->close();
}

$conn->close();
?>
