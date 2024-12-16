<?php

// Memulai sesi
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login_pendakwah.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pendakwah</title>
    <link rel="stylesheet" href="profil.css">
    <style>
        /* profile.css */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .profile-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .profile-container h1 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="profile-container">
            <h1>Profil Pendakwah</h1>
            <form>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap:</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $_SESSION['nama_lengkap']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" readonly>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
