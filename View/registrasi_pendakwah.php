<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SiMuslim - Registrasi Pendakwah</title>
  <link rel="stylesheet" href="css/registrasi_pendakwah.css">
</head>
<body>
  <div class="container">
    <div class="form-container">
      <h1 class="title">
        <img src="img/logosimuslim.png" alt="Logo SiMuslim" class="logo-img">
      </h1>
      <p class="subtitle">Registrasi Pendakwah</p>
      
      <form action="../controller/PendakwahController.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <!-- Username -->
        <div class="form-group">
          <input 
            type="text" 
            id="username" 
            name="username" 
            placeholder="Username" 
            required
            maxlength="10" 
          >
          
          <!-- Pesan error jika username lebih dari 10 karakter -->
          <p id="username-error" style="color: red; font-size: 14px; display: none;">Username maksimal 10 karakter.</p>
          
          <!-- Pesan error jika username sudah terdaftar -->
          <?php if(isset($_GET['error']) && $_GET['error'] == 'username_exists'): ?>
            <p style="color: red; font-size: 14px;">Username sudah terdaftar.</p>
          <?php endif; ?>
        </div>

        <!-- Nama Lengkap -->
        <div class="form-group">
          <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap" required>
        </div>

        <!-- Email -->
        <div class="form-group">
          <input type="email" id="email" name="email" placeholder="Email" required>
          
          <!-- Pesan error jika email sudah terdaftar -->
          <?php if(isset($_GET['error']) && $_GET['error'] == 'email_exists'): ?>
            <p style="color: red; font-size: 14px;">Email sudah terdaftar.</p>
          <?php endif; ?>
        </div>

        <!-- Password -->
        <div class="form-group">
          <div style="position: relative;">
            <input 
              type="password" 
              id="password" 
              name="password" 
              placeholder="Password" 
              required 
              style="padding-right: 40px;"
            >
            <!-- Tombol untuk melihat password -->
            <button 
              type="button" 
              onclick="togglePassword('password')" 
              style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 14px;"
            >
              👁️
            </button>
          </div>
        </div>

        <!-- Konfirmasi Password -->
        <div class="form-group">
          <div style="position: relative;">
            <input 
              type="password" 
              id="konfirmasi_password" 
              name="konfirmasi_password" 
              placeholder="Konfirmasi Password" 
              required
              style="padding-right: 40px;"
            >
            <!-- Tombol untuk melihat konfirmasi password -->
            <button 
              type="button" 
              onclick="togglePassword('konfirmasi_password')" 
              style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 14px;"
            >
              👁️
            </button>
          </div>
        </div>

        <!-- Dokumen Upload -->
        <div class="form-group">
          <label for="dokumen" style="display: block; margin-bottom: 8px;">Upload Dokumen (PDF atau Foto):</label>
          <input 
            type="file" 
            id="dokumen" 
            name="dokumen" 
            accept=".pdf, .jpg, .jpeg, .png" 
            required
          >
        </div>

        <!-- Tombol Kirim -->
        <button type="submit" class="btn">Kirim</button>
      </form>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    // Fungsi untuk melihat/mengubah tipe input password
    function togglePassword(id) {
      const passwordInput = document.getElementById(id);
      const type = passwordInput.type === "password" ? "text" : "password";
      passwordInput.type = type;
    }

    // Fungsi validasi sebelum form disubmit
    function validateForm() {
      const username = document.getElementById("username").value;
      const usernameError = document.getElementById("username-error");

      // Validasi panjang username
      if (username.length > 10) {
        usernameError.style.display = "block";  // Tampilkan pesan error
        return false;  // Mencegah form submit
      } else {
        usernameError.style.display = "none";  // Sembunyikan pesan error jika valid
      }

      const password = document.getElementById("password").value;
      const confirmPassword = document.getElementById("konfirmasi_password").value;

      // Regex untuk validasi password
      const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;

      // Validasi password
      if (!passwordPattern.test(password)) {
        alert("Password harus memiliki minimal 8 karakter, termasuk huruf besar, huruf kecil, dan simbol.");
        return false;  // Mencegah form submit
      }

      // Validasi konfirmasi password
      if (password !== confirmPassword) {
        alert("Password dan konfirmasi password tidak cocok!");
        return false;  // Mencegah form submit
      }

      return true;  // Jika semua validasi lulus, form akan disubmit
    }
  </script>
</body>
</html>
