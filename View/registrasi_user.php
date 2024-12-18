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
      
      <form action="#" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <!-- Nama Lengkap -->
        <div class="form-group">
          <input 
            type="text" 
            id="username" 
            name="username" 
            placeholder="Username" 
            required
            maxlength="10" <!-- Menambahkan batasan jumlah karakter -->
          
          <p id="username-error" style="color: red; font-size: 14px; display: none;"></p>
        </div>

        <!-- Email -->
        <div class="form-group">
          <input type="email" id="email" name="email" placeholder="Email" required>
        </div> 

        <!-- Password -->
        <div class="form-group password-group">
          <input 
            type="password" 
            id="password" 
            name="password" 
            placeholder="Password" 
            required
          >
          <!-- Tombol untuk melihat password -->
          <button 
            type="button" 
            onclick="togglePassword('password')" 
            class="eye-button"
          >
            👁️
          </button>
        </div>

        <!-- Konfirmasi Password -->
        <div class="form-group password-group">
          <input 
            type="password" 
            id="confirm-password" 
            name="confirm-password" 
            placeholder="Konfirmasi Password" 
            required
          >
          <!-- Tombol untuk melihat konfirmasi password -->
          <button 
            type="button" 
            onclick="togglePassword('confirm-password')" 
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
    // Fungsi untuk toggle visibility password
    function togglePassword(inputId) {
      const passwordInput = document.getElementById(inputId);
      const type = passwordInput.type === "password" ? "text" : "password";
      passwordInput.type = type;
    }

    // Fungsi untuk memvalidasi form
    function validateForm() {
      const username = document.getElementById('username').value;
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirm-password').value;
      
      // Validasi panjang username
      if (username.length > 10) {
        document.getElementById('username-error').innerText = "Username harus maksimal 10 karakter.";
        document.getElementById('username-error').style.display = "block";
        return false; // Mencegah form submit
      } else {
        document.getElementById('username-error').style.display = "none";
      }

      // Validasi password
      const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;
      if (!passwordPattern.test(password)) {
        alert("Password harus memiliki minimal 8 karakter, termasuk huruf besar, huruf kecil, dan simbol.");
        return false; // Mencegah form submit
      }

      // Cek apakah password dan konfirmasi password cocok
      if (password !== confirmPassword) {
        alert("Password dan konfirmasi password tidak cocok!");
        return false; // Mencegah form submit
      }

      return true; // Semua validasi lulus, form bisa disubmit
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

  // Validasi: Periksa panjang username
  if (strlen($username) > 10) {
      echo "<script>
              document.getElementById('username').insertAdjacentHTML(
                'afterend',
                '<p style=\"color: red; font-size: small;\">Username harus maksimal 10 karakter</p>'
              );
            </script>";
      exit;
  }

  // Validasi: Periksa jika password cocok
  if ($password !== $confirm_password) {
      echo "<script>alert('Password tidak cocok!');</script>";
      exit;
  }

  // Cek apakah username sudah ada
  $stmt_check_username = $conn->prepare("SELECT username FROM users WHERE username = ?");
  $stmt_check_username->bind_param("s", $username);
  $stmt_check_username->execute();
  $stmt_check_username->store_result();

  if ($stmt_check_username->num_rows > 0) {
      echo "<script>
              document.getElementById('username').insertAdjacentHTML(
                'afterend',
                '<p style=\"color: red; font-size: small;\">Username sudah terdaftar</p>'
              );
            </script>";
      $stmt_check_username->close();
      exit;
  }

  $stmt_check_username->close();

  // Cek apakah email sudah ada
  $stmt_check_email = $conn->prepare("SELECT email FROM users WHERE email = ?");
  $stmt_check_email->bind_param("s", $email);
  $stmt_check_email->execute();
  $stmt_check_email->store_result();

  if ($stmt_check_email->num_rows > 0) {
      echo "<script>
              document.getElementById('email').insertAdjacentHTML(
                'afterend',
                '<p style=\"color: red; font-size: small;\">Email sudah terdaftar</p>'
              );
            </script>";
      $stmt_check_email->close();
      exit;
  }

  $stmt_check_email->close();

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
