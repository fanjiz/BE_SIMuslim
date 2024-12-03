<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SiMuslim Login</title>
  <link rel="stylesheet" href="css/login_user_p.css">
</head>
<body>
  <div class="container">
    <div class="form-container">
      <!-- Mengganti tulisan dengan logo -->
      <h1 class="title">
        <img src="img/logosimuslim.png" alt="Logo SiMuslim" class="logo">
      </h1>
      <p class="subtitle">Masuk ke akun Anda</p>
      <form id="login-form">
        <div class="form-group">
          <input type="text" id="username" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
          <input type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn">Masuk</button>
      </form>
      <p class="register">
        Belum punya akun? <a href="registrasi_pendakwah.php">Registrasi Pendakwah</a>
      </p>
    </div>
  </div>

  <script src="../model/UserModel.js"></script> <!-- Include the JS Model -->
  <script>
    document.getElementById('login-form').addEventListener('submit', function(event) {
      event.preventDefault();  // Prevent form from submitting normally
      const username = document.getElementById('username').value;
      const password = document.getElementById('password').value;

      // Call the login method from the JS model
      login(username, password);
    });
  </script>
</body>
</html>
