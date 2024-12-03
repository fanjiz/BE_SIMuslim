<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SiMuslim Login</title>
  <link rel="stylesheet" href="login_user_p.css">
</head>
<body>
  <div class="container">
    <div class="form-container">
      <!-- Mengganti tulisan dengan logo -->
      <h1 class="title">
        <img src="logosimuslim.png" alt="Logo SiMuslim" class="logo">
      </h1>
      <p class="subtitle">Masuk ke akun Anda</p>
      <form action="../HOMEPAGE/HOMEPENDAKWAH.HTML" method="POST">
        <div class="form-group">
          <input type="text" id="username" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
          <input type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn">Masuk</button>
      </form>
      <p class="register">
        Belum punya akun? <a href="../LOGINAWAL/PENDAKWAH.HTML">Registrasi Pendakwah</a>
      </p>
    </div>
  </div>
</body>
</html>
