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
      
      <form action="../controller/PendakwahController.php" method="POST" enctype="multipart/form-data">
        <!-- Nama Lengkap -->
        <div class="form-group">
          <input type="text" id="username" name="username" placeholder="Username" required>
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
              onclick="togglePassword()" 
              style="
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                cursor: pointer;
                font-size: 14px;"
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
    function togglePassword() {
      const passwordInput = document.getElementById("password");
      const type = passwordInput.type === "password" ? "text" : "password";
      passwordInput.type = type;
    }
  </script>
</body>
</html>
