<?php
// Inisialisasi variabel pesan error
$usernameError = $passwordError = "";

// Periksa apakah ada parameter error yang dikirimkan
if (isset($_GET['error'])) {
    $errorType = $_GET['error'];

    if ($errorType === "username") {
        $usernameError = "Username tidak ditemukan.";
    } elseif ($errorType === "password") {
        $passwordError = "Password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiMuslim Login</title>
    <link rel="stylesheet" href="css/loginuser.css"> <!-- Path CSS -->
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1 class="title">
                <img src="img/logosimuslim.png" alt="Logo SiMuslim" class="logo">
            </h1>
            <p class="subtitle">Masuk ke akun Anda</p>
            <form action="../controller/UserController.php?action=login" method="POST">
                <div class="form-group">
                    <input type="text" id="username" name="username" placeholder="Username" required>
                    <?php if ($usernameError): ?>
                        <div class="error-message"><?php echo htmlspecialchars($usernameError); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <?php if ($passwordError): ?>
                        <div class="error-message"><?php echo htmlspecialchars($passwordError); ?></div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn">Masuk</button>
            </form>
            <p class="register">
                Belum punya akun? <a href="registrasi_user.php">Registrasi User</a>
            </p>
        </div>
    </div>
</body>
</html>
